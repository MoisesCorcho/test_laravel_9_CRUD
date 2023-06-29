<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Arr;

use App\Models\User;
use App\Models\Organization;
use App\Models\Survey;
use App\Models\SurveyQuestionAnswer;
use App\Http\Controllers\BaseController;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\SellerListResource;
use App\Http\Resources\Clients\AvailableClientsResource;
use App\Models\SurveyAnswer;
use App\Models\SurveyQuestion;

class UserController extends BaseController
{

    public function index(Request $request)
    {
        $users   = User::query()->withTrashed();
        $dni     = $request->dni ?? null;
        $perPage = $request->page_size ?? 20;

        if ($dni) $users = $this->findByDni($dni, $users);

        return $this->sendResponse(
            $users->paginate($perPage)
                  ->toArray(),
            Response::HTTP_OK,
            'Usuarios encontrados correctamente'
        );
    }

    public function store(StoreUserRequest $request)
    {
        $user = new User();
        $user->firstName    = $request->firstName;
        $user->lastName     = $request->lastName;
        $user->photo        = $request->photo ?? null;
        $user->cellphone    = $request->cellphone;
        $user->email        = $request->email;
        $user->dniType      = $request->dniType;
        $user->dni          = $request->dni;
        $user->active       = $request->active;
        $user->visitsPerDay = $request->visitsPerDay ?? null;
        $user->password     = Hash::make($request->password);
        $user->assignRole(Role::query()->find($request->get('role_id')));
        $user->save();

        return $this->sendResponse(
            $user->toArray(),
            Response::HTTP_OK,
            'Usuario creado satisfactoriamente'
        );
    }


    public function show(Request $request, $id)
    {
        $user = User::query()->withTrashed()->with('roles')->where('id', $id)->first();

        if(is_null($user)){
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'Error al encontrar el usuario'
            );
        }
        return $this->sendResponse(
            $user->toArray(),
            Response::HTTP_OK,
            'Usuario encontrado'
        );
    }


    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::query()->where('id', $id)->first();

        if (is_null($user)) {
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'Usuario no encontrado'
            );
        }

        $user->firstName    = $request->firstName;
        $user->lastName     = $request->lastName;
        $user->cellphone    = $request->cellphone;
        $user->email        = $request->email;
        $user->visitsPerDay = $request->visitsPerDay ?? null;
        if (!is_null($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->assignRole(Role::query()->find($request->get('role_id')));
        $user->update();

        // $user->update($request->all());

        return $this->sendResponse(
            $user->toArray(),
            Response::HTTP_OK,
            'usuario actualizado satisfactoriamente'
        );
    }


    public function destroy($id)
    {
        $user = User::query()->where('id', $id)->first();

        if (is_null($user)) {
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'Usuario no encontrado'
            );
        }

        $user->active = 0;
        $user->update();
        $user->delete();

        return $this->sendResponse(
            [],
            Response::HTTP_NO_CONTENT,
            'Usuario eliminado satisfactoriamente'
        );
    }


    public function findByDni($dni, Builder $user)
    {
        return $user->where('dni', 'like', '%'.$dni.'%');
    }


    public function sellersList()
    {
        $sellers = SellerListResource::collection(User::role('Seller')->get());

        if (is_null($sellers)) {
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'No se encontraron vendedores.'
            );
        }

        return [
            'success' => true,
            'message' => 'Vendedores encontrados con exito',
            'data'    => $sellers
        ];
    }

    public function getRoles()
    {

        $roles = DB::table('roles')->select('id','name')->get();

        if (is_null($roles)) {
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'No se encontraron los roles.'
            );
        }

        return $this->sendResponse(
            $roles->toArray(),
            Response::HTTP_OK,
            'Roles encontrados satisfactorimente.'
        );
    }

    public function getSellersWithClients()
    {
        $response = User::withTrashed()->with('organizations')->role('Seller')->paginate();

        if (is_null($response)) {
            $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'No se encontraron vendedores'
            );
        }

        return $this->sendResponse(
            $response->toArray(),
            Response::HTTP_OK,
            'Vendedores encontrados satisfactoriamente.'
        );
    }

    /*
    * Funcion para obtener los clientes que se encuentren disponibles.
    */
    public function availableClients()
    {
        //Obtenemos un array con los ids de todas las organizaciones
        $organizaciones = Organization::all()->pluck('id');

        //Obtenemos una coleccion con todos los vendedores y sus clientes asignados
        $response = User::with('organizations')->role('Seller')->get();

        //Convertimos la coleccion a un array php
        $responsejson = json_decode($response, true);

        //Creamos el arreglo donde guardaremos los id de las organizaciones que estan asignadas
        $ids = [];

        //Recorremos el arreglo de organizaciones y llenamos ids[]
        foreach ($responsejson as $value) {
            foreach ($value['organizations'] as $value2) {
                array_push($ids, $value2['id']);
            }
        }

        /* Comparamos arrays y se obtienen aquellos valores que esten dentro del primer array que no
        esten en el segundo para luego utilizarlos como filtro dentro de una consulta con eloquent*/
        $disponibles = array_diff($organizaciones->toArray(), $ids);

        //Array que llenaremos con el nombre y el id de las organizaciones disponibles
        $orgDisponibles = [];

        foreach ($disponibles as $disp) {
            $org = Organization::find($disp);

            $x = array(
                'id'   => $org->id,
                'name' => $org->name
            );
            array_push($orgDisponibles, $x);
        }

        if (is_null($response)) {
            return ['data' => []];
        } else {
            return $this->sendResponse(
                $orgDisponibles,
                Response::HTTP_OK,
                'Clientes disponibles encontrados correctamente.'
            );
        }

    }

    public function assignClientToSeller($idOrganizacion, $idUsuario)
    {

        $usuario      = User::where('id', $idUsuario)->first();
        $organizacion = Organization::where('id', $idOrganizacion)->first();

        if (is_null($usuario) || is_null($organizacion)) {
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'Usuario o Cliente no encontrado.'
            );
        }

        $organizacion->seller()->associate($usuario);
        $organizacion->save();

        //Retornamos el usuario con sus clientes asignados
        $response = $usuario::where('id', $usuario->id)->with('organizations')->get();

        return $this->sendResponse(
            $response->toArray(),
            Response::HTTP_OK,
            'Organizacion asignada correctamente.'
        );
    }

    public function removeClientToSeller($idOrganizacion, $idUsuario)
    {
        $usuario      = User::where('id', $idUsuario)->first();
        $organizacion = Organization::where('id', $idOrganizacion)->first();

        if (is_null($usuario) || is_null($organizacion)) {
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'Usuario o Cliente no encontrado.'
            );
        }

        $organizacion->seller()->dissociate($usuario);
        $organizacion->save();

        //Retornamos el usuario con sus clientes asignados
        $response = $usuario::where('id', $usuario->id)->with('organizations')->get();

        return $this->sendResponse(
            $response->toArray(),
            Response::HTTP_OK,
            'Organizacion desasignada correctamente.'
        );
    }

    /*
    * Retorna aquellas tareas pendientes (que quedaron de sus respuestas de los forms) del vendedor.
    */
    public function pendingTasks()
    {
        $response = SurveyAnswer::query()
            ->select(
                'answer as task',
                'state',
                'users.firstName as seller' ,
                'surveyQuestionAnswers.id as questionAnswerId',
                'surveyAnswers.surveyId',
                'surveyAnswers.date as answerDate',
            )
            ->join('surveyQuestionAnswers', 'surveyQuestionAnswers.surveyAnswerId', '=', 'surveyAnswers.id')
            ->join('surveyQuestions', 'surveyQuestions.id', '=', 'surveyQuestionAnswers.surveyQuestionId')
            ->join('users', 'surveyAnswers.sellerId', '=', 'users.id')
            ->where('surveyAnswers.sellerId', auth()->id())
            ->where('surveyQuestions.questionOfThingsToDo', 1)
            ->whereRaw('CHAR_LENGTH(answer) > 0')
            ->get();

        return $this->sendResponse(
            $this->findPositionQuestion($response),
            Response::HTTP_OK,
            'Pendientes encontrados satisfactoriamente'
        );
    }


    public function disableTask($id)
    {
        $task = SurveyQuestionAnswer::find($id);

        if (!$task) {
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'No existe un pendiente con este id.'
            );
        }

        $answerId = $task->surveyAnswerId;
        $ownerId = SurveyAnswer::find($answerId)->sellerId;

        if ($ownerId !== auth()->id()) {
            return $this->errorResponse(
                Response::HTTP_FORBIDDEN,
                'No puede realizar esta acción, no es el dueño de este pendiente.'
            );
        }

        $task->state = 0;
        $task->save();

        return $this->sendResponse(
            $task->toArray(),
            Response::HTTP_OK,
            'Pendiente desactivado satisfactoriamente.'
        );
    }

    public function findPositionQuestion($responses)
    {
        $survey = null;
        $questions = null;
        $questionOrganizationId = null;
        $questionPendingId = null;
        $numberOfPositions = null;
        $numberOfQuestions = null;
        $responseOrganization = null;
        $arrayResponse = [];

        foreach ($responses as $res) {
            //Encontramos el survey
            $survey = Survey::find($res->surveyId);

            //Encontramos las preguntas del survey
            $questions = SurveyQuestion::where('surveyId', $survey->id)->get();

            //Obtenemos el numero de preguntas que tiene el formulario
            $numberOfQuestions = SurveyQuestion::where('surveyId', $survey->id)->count();

            foreach ($questions as $ques) {

                //Obtenemos el id de la pregunta que almacena el cliente
                if ($ques->tableType == 'organization') {
                    $questionOrganizationId = $ques->id;
                }

                //Obtenemos la pregunta que almacena los pendientes
                if ($ques->questionOfThingsToDo == 1) {
                    $questionPendingId = $ques->id;
                }
            }

            //Obtenemos cuantas posiciones de diferencia hay entre ambas preguntas si en el formulario la pregunta de pendientes es creada luego que la de cliente
            if ($questionPendingId > $questionOrganizationId) {
                $numberOfPositions = $questionPendingId - $questionOrganizationId;
            }

            //Obtenemos cuantas posiciones de diferencia hay entre ambas preguntas si en el formulario la pregunta de pendientes es creada antes que la de cliente
            if ($questionPendingId < $questionOrganizationId) {
                $numberOfPositions = $questionOrganizationId - $questionPendingId;
            }

            //Encontramos la respuesta que contiene al cliente
            $responseOrganization = SurveyQuestionAnswer::find($res->questionAnswerId - $numberOfPositions);

            //Añadimos al arreglo que retornaremos el cliente que encontramos en el paso anterior
            $res2 = Arr::add(
                $res->toArray(),
                'cliente',
                str_replace(['"', '[', ']'], '', $responseOrganization->answer)
            );

            //Quitamos del arreglo de la respuesta este campo pues no será necesrio.
            unset($res2['surveyId']);

            //Agregamos al arreglo que retornaremos con las respesutas la respuesta por la cual vamos iterando
            array_push($arrayResponse, $res2);
        }

        return $arrayResponse;
    }
}

