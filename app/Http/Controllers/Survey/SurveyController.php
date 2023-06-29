<?php

namespace App\Http\Controllers\Survey;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Objective;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

use App\Enums\SurveyQuestionEnum;
use App\Http\Controllers\BaseController;
use App\Models\Organization;
use App\Models\User;
use App\Models\Member;
use App\Models\Survey;
use App\Models\MemberPosition;
use App\Models\SurveyQuestion;
use App\Models\SurveyAnswer;
use App\Models\SurveyQuestionAnswer;
use App\Http\Requests\Survey\StoreSurveyRequest;
use App\Http\Requests\Survey\UpdateSurveyRequest;
use App\Http\Requests\Survey\StoreSurveyAnswerRequest;
use App\Http\Resources\Survey\SurveyResource;
use App\Http\Resources\Survey\sellerOrganizationResource;
use App\Http\Resources\Survey\sellerOrganizationMemberResource;
use App\Http\Resources\Survey\clientPositionResource;

class SurveyController extends BaseController
{

    public function index()
    {
        $user = auth()->id();

        $surveys = Survey::where('createdBy', $user)->orderBy('created_at', 'DESC')->paginate(10);

        if (is_null($surveys)) {
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'Error al encontrar los formularios.'
            );
        }

        return SurveyResource::collection($surveys);

        //Si retorno el recurso dentro de la respuesta json no se muestran los datos de la paginacion que da el motodo paginate()
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Formularios encontrados satisfactoriamente.',
        //     'data'    => SurveyResource::collection($surveys)
        // ]);
    }

    public function store(StoreSurveyRequest $request)
    {
        $data = $request->validated();

        //Obtenemos el usuario logueado.
        $admin = auth()->user();

        //Validamos que el usuario exista.
        if (!$admin) {
            return $this->errorResponse(
                Response::HTTP_FORBIDDEN,
                'Usuario no existe.'
            );
        }

        //Verificamos que el rol del usuario sea "Admin"
        if (!$admin->is_admin()) {
            return $this->errorResponse(
                Response::HTTP_FORBIDDEN,
                'Usuario no autorizado para realizar esta acción (No tiene el rol de administrador).'
            );
        }

        //Agregamos al array de request el id del Admin creador del formulario
        $data['createdBy'] = $admin->id;

        //Guardamos los datos del formulario en BD
        $survey = Survey::create($data);

        //Creamos las preguntas que recibiran datos de otras tablas ("Organization", "Member", "memberPositions")
        $dataQuestions = [
            "questions" => [
                [
                    "type" => "select",
                    "question" => "¿Es nuevo el cliente?",
                    "tableType" => "newclient",
                    "surveyId" => $survey->id,
                    "data" => json_encode([])
                ],
                [
                    "type" => "select",
                    "question" => "Cliente",
                    "tableType" => "organization",
                    "surveyId" => $survey->id,
                    "data" => json_encode([])
                ],
                [
                    "type" => "select",
                    "question" => "Nombre de contacto",
                    "surveyId" => $survey->id,
                    "tableType" => "member",
                    "data" => json_encode([])
                ],
                [
                    "type" => "select",
                    "question" => "Cargo de contacto",
                    "surveyId" => $survey->id,
                    "tableType" => "memberPosition",
                    "data" => json_encode([])
                ],

                //Hora de inicio y de fin son preguntas obligatorias para medir cuanto demora cada visita.
                [
                    "type" => "text",
                    "question" => "Hora de Inicio",
                    "surveyId" => $survey->id,
                    "tableType" => "HoraDeInicio",
                    "data" => json_encode([])
                ],
                [
                    "type" => "text",
                    "question" => "Hora de Finalización",
                    "surveyId" => $survey->id,
                    "tableType" => "HoraDeFin",
                    "data" => json_encode([])
                ],
            ]
        ];

        // Creamos las preguntas que hicimos manualmente.
        foreach ($dataQuestions['questions'] as $dataQuestion) {
            SurveyQuestion::create($dataQuestion);
        }

        //Guardamos las preguntas en BD
        foreach ($data['questions'] as $question) {
            $question['surveyId'] = $survey->id;
            $this->createQuestion($question);
        }

        return response()->json([
            new SurveyResource($survey),
            Response::HTTP_OK,
            'Formulario creado satisfactorimente.'
        ]);

    }

    public function show(Request $request, $id)
    {
        $user = $request->user();
        $survey = Survey::find($id);

        if (is_null($survey)) {
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'No se pudo encontrar el formulario.'
            );
        }

        if ($user->id !== $survey->createdBy) {
            return $this->errorResponse(
                Response::HTTP_FORBIDDEN,
                'Usuario no autorizado para realizar esta acción (No es el dueño de este formulario).'
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Formulario encontrados satisfactoriamente',
            'data'    => new SurveyResource($survey)
        ]);

    }

    public function update(UpdateSurveyRequest $request, $id)
    {
        //Obtenemos la data del request validada.
        $data = $request->validated();

        //Encontramos el formulario por medio del id.
        $survey = Survey::find($id);

        //Actualizamos los datos del formulario.
        $survey->update($data);

        //Creamos un array plano con los id del formulario que queremos actualizar.
        $existingIds = $survey->questions()->pluck('id')->toArray();

        //Creamos un array con los id de las preguntas que se enviaron en el request
        $newIds = Arr::pluck($data['questions'], 'id');

        /*Creamos un array de ids (para borrar) formado por las preguntas que ya existen,
         *pero que no se enviaron en el request*/
        $toDelete = array_diff($existingIds, $newIds);

        /*Creamos un array con los id de las preguntas que se enviaron en el request
         *y que no existen en el formulario a actualizar para crearlas como nuevas preguntas*/
        $toAdd = array_diff($newIds, $existingIds);

        //Borramos las preguntas seleccionadas.
        SurveyQuestion::destroy($toDelete);


        //Creamos las nuevas preguntas.
        foreach ($data['questions'] as $question) {
            if (in_array($question['id'], $toAdd)) {
                $question['surveyId'] = $survey->id;
                $this->createQuestion($question);
            }
        }

        //Actualizamos las preguntas existentes.

        //creamos la instancia de una coleccion con las preguntas del request y las identificamos por su id
        $questionMap = collect($data['questions'])->keyBy('id');
        foreach ($survey->questions as $question) {
            if (isset($questionMap[$question->id])) {
                $this->updateQuestion($question, $questionMap[$question->id]);
            }
        }

        return response()->json([
            new SurveyResource($survey),
            Response::HTTP_OK,
            'Formulario actualizado satisfactorimente.'
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $survey = Survey::find($id);

        //Validamos que quien pueda realizar esta accion sea quien la creó.
        if ($user->id !== $survey->createdBy) {
            return $this->errorResponse(
                Response::HTTP_FORBIDDEN,
                'Usuario no autorizado para realizar esta acción (No es el dueño de este formulario).'
            );
        }

        if (is_null($survey)) {
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'No se pudo encontrar el formulario.'
            );
        }

        //Buscamos todos los clientes asignados al formulario.
        $sellersAssignedToSurvey = User::query()->where('surveyId', $survey->id)->get();

        //Recorremos el array de sellers y los vamos desasignando uno a uno.
        foreach ($sellersAssignedToSurvey as $seller) {
            $this->unassignSurveyToSeller($survey->id, $seller->id);
        }
        $survey->delete();

        return $this->sendResponse(
            [],
            Response::HTTP_NO_CONTENT,
            'Formulario eliminado satisfactoriamente.'
        );
    }

    public function createQuestion($data)
    {
        //Convertimos a formato JSON la propiedad data donde se almacenan las preguntas.
        if (is_array($data['data'])) {
            $data['data'] = json_encode($data['data']);
        }

        //Validamos cada pregunta perteneciente a la propiedad data.
        $validator = Validator::make($data, [
            'type'                 => ['required', Rule::in(SurveyQuestionEnum::getValues())],
            'question'             => 'required|string',
            'description'          => 'nullable|string',
            'data'                 => 'present',
            'surveyId'             => 'exists:surveys,id',
            'questionOfThingsToDo' => 'integer'
        ]);

        //Retornamos la creacion de una nueva pregunta.
        return SurveyQuestion::create($validator->validated());
    }

    public function updateQuestion($question, $data)
    {
        //Convertimos a formato JSON la propiedad data donde se almacenan las preguntas.
        if (is_array($data['data'])) {
            $data['data'] = json_encode($data['data']);
        }

        //Validamos cada pregunta perteneciente a la propiedad data.
        $validator = Validator::make($data, [
            'id'          => 'exists:surveyQuestions,id',
            'type'        => ['required', Rule::in(SurveyQuestionEnum::getValues())],
            'question'    => 'required|string',
            'description' => 'nullable|string',
            'data'        => 'present',
            'surveyId'    => 'exists:surveys,id' //Si luego no sirve podria ser esto (Compara).
        ]);

        //Retornamos la actualizacion de la pregunta.
        return $question->update($validator->validated());
    }

    public function storeAnswer(StoreSurveyAnswerRequest $request, $id)
    {
        $validated = $request->validated();
        $survey = Survey::find($id);
        $idVendedor = auth()->id();

        $seller = User::where('id', $idVendedor)->first();

        //Solo puede hacer respuestas a este formulario aquel vendedor que lo tenga asignado.
        if ($seller->getRoleNames()->first() !== "Seller") {
            return $this->errorResponse(
                Response::HTTP_FORBIDDEN,
                'Usuario no cuenta con los permisos requeridos para realizar esta acción, debe ser de tipo Seller.'
            );
        }

        //Establecemos la zona horario de Bogota Colombia
        date_default_timezone_set('America/Bogota');

        //Almacenamos cuando se guardó la respuesta y a cual survey pertenece
        $surveyAnswer = SurveyAnswer::create([
            'date'      => date('Y-m-d H:i:s'),
            'surveyId'  => $survey->id,
            'sellerId' => $idVendedor
        ]);

        //Guardamos las respuestas
        foreach ($validated['answers'] as $questionId => $answer) {

            $question = SurveyQuestion::where(['id' => $questionId, 'surveyId' => $survey->id])->get();

            if (!$question) {
                return $this->errorResponse(
                    Response::HTTP_NOT_FOUND,
                    'No existe la pregunta.'
                );
            }

            /**
             * Para eliminar los espacios en blanco debe pasarse como argumento una cadena de texto, pero no quiero hacerlo ahora porque
             * abajo se sigue utilizando la variable $answer y no quiero generar problemas ahora mismo :)
            */
            //$answer = trim($answer);

            $data = [
                'answer'           => is_array($answer) ? json_encode($answer, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES ) : $answer,
                'surveyQuestionId' => $questionId,
                'surveyAnswerId'   => $surveyAnswer->id,
                'state'            => 0
            ];

            //Si la respuesta es para una pregunta de tareas pendientes, le cambiamos el estado a 1 (activa)
            if ( $question[0]['questionOfThingsToDo'] == 1 and strlen(trim($answer)) != 0) {
                $data['state'] = 1;
                SurveyQuestionAnswer::create($data);
            } else {
                SurveyQuestionAnswer::create($data);
            }

        }
        return $this->sendResponse(
            [],
            Response::HTTP_OK,
            'Respuesta registrada satisfactoriamente.'
        );
    }

    /**
     * Retorna las organizaciones que tiene asociadas un vendedor
     */
    public function sellerOrganizations($id)
    {
        $seller = User::find($id);

        if (is_null($seller)) {
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'No se pudo encontrar el vendedor.'
            );
        }

        $organizations = Organization::where('sellerId', $seller->id)->get();

        return sellerOrganizationResource::collection($organizations);
    }

    /**
     * Retorna los miembros pertenecientes a una organizacion
     *
     * @param [type] $id
     * @return resource de members
     *
     */
    public function sellerOrganizationsMembers($id)
    {
        $organization = Organization::find($id);

        if (is_null($organization)) {
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'No se pudo encontrar la organizacion.'
            );
        }

        $members = Member::where('organizationId', $organization->id)->get();

        return sellerOrganizationMemberResource::collection($members);
    }

    public function clientPositions()
    {
        $memberPositions = MemberPosition::all();
        return clientPositionResource::collection($memberPositions);
    }

    public function sellerSurveys($id)
    {
        $seller = User::find($id);

        if (is_null($seller)) {
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'No se pudo encontrar el vendedor.'
            );
        }

        $survey = Survey::where('id', $seller->surveyId)->first();

        return response()->json([
            'success' => true,
            'message' => 'Formulario encontrado satisfactoriamente',
            'data'    => new SurveyResource($survey)
        ]);
    }

    public function assignSurveyToSeller($idSurvey, $idSeller)
    {
        $seller = User::where('id', $idSeller)->first();
        $survey = Survey::where('id', $idSurvey)->first();

        if (is_null($seller) || is_null($survey)) {
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'Usuario o formulario no encontrado.'
            );
        }

        $seller->survey()->associate($survey);
        $seller->save();

        //Retornamos el usuario con su survey asignados
        $response = $seller::where('id', $seller->id)->with('survey')->get();

        return $this->sendResponse(
            $response->toArray(),
            Response::HTTP_OK,
            'Formulario asignado correctamente.'
        );
    }

    public function unassignSurveyToSeller($idSurvey, $idSeller)
    {
        $seller = User::where('id', $idSeller)->first();
        $survey = Survey::where('id', $idSurvey)->first();

        if (is_null($seller) || is_null($survey)) {
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'Usuario o formulario no encontrado.'
            );
        }

        $seller->survey()->dissociate($survey);
        $seller->save();

        //Retornamos el usuario con su survey asignado
        $response = $seller::where('id', $seller->id)->with('survey')->get();

        return $this->sendResponse(
            $response->toArray(),
            Response::HTTP_OK,
            'Formulario desasignado correctamente.'
        );
    }

    public function sellersAssignedToSurvey($idSurvey)
    {
        $sellers = User::query()
            ->selectRaw("id, concat(firstName, ' ', lastName) as nombre_completo")
            ->where('surveyId', $idSurvey)
            ->get();

        if (is_null($sellers)) {
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'No hay vendedores asignados a este formulario.'
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Vendedores encontrados satisfactoriamente',
            'data'    => $sellers
        ]);
    }

    public function sellersWithoutSurvey()
    {
        $sellers = User::query()
        ->selectRaw("id, concat(firstName, ' ', lastName) as nombre_completo")
        ->role('Seller')
        ->where('surveyId', null)
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Vendedores sin formulario asignado encontrados satisfactoriamente',
            'data'    => $sellers
        ]);
    }

}
