<?php

namespace App\Http\Controllers\Visit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Visit;
use App\Models\User;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Visit\StoreVisitRequest;
use App\Http\Requests\Visit\UpdateVisitRequest;
use App\Http\Requests\Visit\rescheduleVisitRequest;
use App\Models\ReasonForNotVisit;

class VisitController extends BaseController
{

    public function index()
    {
        $perPage = request()->page_size ?? 20;

        if (auth()->user()->getRoleNames()->first() == "Seller") {
            $visits = Visit::query()
                ->where('sellerId', auth()->user()->id)
                ->with(['organization', 'seller'])
                ->paginate($perPage);
        } else {
            $visits = Visit::query()->with(['organization', 'seller'])->orderBy('created_at', 'desc')->paginate($perPage);
        }

        return $this->sendResponse(
            $visits->toArray(),
            Response::HTTP_OK,
            'Visitas encontradas satisfactoriamente.'
        );
    }


    public function store(StoreVisitRequest $request)
    {

        $user = User::where('id', $request->sellerId)->first();

        $visit = new Visit();
        $visit->visitDate             = $request->visitDate;
        $visit->rescheduledDate       = $request->rescheduledDate;
        $visit->reasonForNotVisitDesc = $request->reasonForNotVisitDesc;
        $visit->status                = $request->status;
        $visit->sellerId              = $request->sellerId;
        $visit->reasonForNotVisitId   = $request->reasonForNotVisitId;
        $visit->organizationId        = $request->organizationId;
        $visit->surveyId              = $user->surveyId;

        $limite = $visit->numberOfVisits($request->visitDate);

        if ($limite) {
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'No se pueden registrar mas visitas en este dia ya se ha alcanzado el limite de 8 visitas diarias.'
            );
        }

        $visit->save();

        return $this->sendResponse(
            $visit->toArray(),
            Response::HTTP_OK,
            'Visita creada satisfactoriamente.'
        );
    }


    public function show($id)
    {
        $visit = Visit::query()->where('id', $id)->with(['organization', 'seller'])->first();

        if (is_null($visit)) {
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'Visita no encontrada.'
            );
        }

        return $this->sendResponse(
            $visit->toArray(),
            Response::HTTP_OK,
            'Visita encontrada satisfactoriamente'
        );
    }


    public function update(UpdateVisitRequest $request, $id)
    {
        $visit = Visit::query()->where('id', $id)->first();

        if (is_null($visit)) {
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'Visita no encontrada.'
            );
        }

        $limite = $visit->numberOfVisits($request->visitDate);

        if ($limite) {
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'No se pueden registrar mas visitas en este dia ya se ha alcanzado el limite de 8 visitas diarias.'
            );
        }

        $visit->update($request->all());

        return $this->sendResponse(
            $visit->toArray(),
            Response::HTTP_OK,
            'Visita actualizada satisfactoriamente.'
        );
    }


    public function destroy($id)
    {
        $visit = Visit::query()->where('id', $id)->first();

        if (is_null($visit)) {
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'Visita no encontrada.'
            );
        }

        $visit->delete();

        return $this->sendResponse(
            [],
            Response::HTTP_NO_CONTENT,
            'Visita eliminada satisfactoriamente.'
        );
    }

    /**
     * Retorna las visitas del vendedor que se encuentre logueado.
     *
     * @param [type] $id
     * @return void
     */
    public function visitsSeller()
    {
        $idSeller = auth()->id();
        $visits = Visit::where('sellerId', $idSeller)->get();

        return $this->sendResponse(
            $visits->toArray(),
            Response::HTTP_OK,
            'Visitas encontradas satisfactoriamente.'
        );
    }

    /**
     * Recive el id de una visita y cambia su estado a notVisited.
     *
     * @param [type] $id
     * @return void
     */
    public function disableVisit($id)
    {
        $visit = Visit::find($id);
        $user = User::find(auth()->id());

        if (is_null($visit)) {
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'Visita no encontrada.'
            );
        }

        if ($visit->sellerId != auth()->id() && !$user->is_admin()) {
            return $this->errorResponse(
                Response::HTTP_FORBIDDEN,
                'Acción denegada, no es el dueño de esta visita.'
            );
        }

        $visit->status = "notVisited";
        $visit->save();

        return $this->sendResponse(
            $visit->toArray(),
            Response::HTTP_OK,
            'Estado de visita actualizado satisfactoriamente.'
        );
    }


    /**
     * Recive el id de una visita y cambia su estado a visited.
     *
     * @param [type] $id
     * @return void
     */
    public function completeVisit($id)
    {
        $visit = Visit::find($id);
        $user  = User::find(auth()->id());

        if (is_null($visit)) {
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'Visita no encontrada.'
            );
        }

        if ($visit->sellerId != auth()->id() && !$user->is_admin()) {
            return $this->errorResponse(
                Response::HTTP_FORBIDDEN,
                'Acción denegada, no es el dueño de esta visita.'
            );
        }

        $visit->status = "visited";
        $visit->save();

        return $this->sendResponse(
            $visit->toArray(),
            Response::HTTP_OK,
            'Estado de visita actualizado satisfactoriamente.'
        );
    }

    public function reasonsForNotVisit()
    {
        $reasons = ReasonForNotVisit::all();

        return $this->sendResponse(
            $reasons->toArray(),
            Response::HTTP_OK,
            'Razones para no visitar encontradas satisfactoriamente.'
        );
    }

    /**
     * Recibe el id de una visita para actualizar, en este caso, el campo rescheduledDate será el campo que tenga
     * la fecha antigua y el campo visitDate será quien tenga la nueva fecha de reagendamiento.
     *
     * @param rescheduleVisitRequest $request
     * @param [String - uuid] $id
     * @return void
     */
    public function rescheduleVisit(rescheduleVisitRequest $request, $id)
    {
        $visit = Visit::query()->where('id', $id)->first();

        if (is_null($visit)) {
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'Visita no encontrada.'
            );
        }

        $limite = $visit->numberOfVisits($request->visitDate);

        if ($limite) {
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'No se pueden registrar mas visitas en este dia ya se ha alcanzado el limite de 8 visitas diarias.'
            );
        }

        $visit->update($request->all());

        return $this->sendResponse(
            $visit->toArray(),
            Response::HTTP_OK,
            'Visita reagendada satisfactoriamente.'
        );
    }
}
