<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Controllers\BaseController;
use App\Models\Organization;
use App\Models\User;
use App\Http\Requests\Organization\StoreOrganizationRequest;
use App\Http\Requests\Organization\UpdateOrganizationRequest;

class OrganizationController extends BaseController
{

    public function index(Request $request)
    {
        $organizations = Organization::query();
        $perPage       = $request->page_size ?? 20;
        $nit           = $request->nit ?? null;

        if ($nit) $organizations = $this->findByDni($organizations, $nit);

        return $this->sendResponse(
            $organizations->paginate($perPage)
                ->toArray(),
            Response::HTTP_OK,
            'Organizaciones encontradas correctamente'
        );
    }


    public function store(StoreOrganizationRequest $request)
    {
        $organization = new Organization();
        $organization->name        = $request->name;
        $organization->description = $request->description;
        $organization->nit         = $request->nit;
        $organization->address     = $request->address;
        $organization->cellphone   = $request->cellphone;
        $organization->phone       = $request->phone;
        $organization->email       = $request->email;
        $organization->city        = $request->city;
        // $organization->seller()->associate(User::query()->where('id', $request->sellerId)->first());
        $organization->sellerId    = $request->sellerId;
        $organization->save();

        return $this->sendResponse(
            $organization->toArray(),
            Response::HTTP_OK,
            'Organización creada satisfactoriamente.'
        );
    }


    public function show($id)
    {
        $organization = Organization::query()->where('id', $id)->first();

        if (is_null($organization)) {
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'No se pudo enontrar la organización.'
            );
        }

        return $this->sendResponse(
            $organization->toArray(),
            Response::HTTP_OK,
            'Organización encontrada satisfactoriamente.'
        );
    }


    public function update(UpdateOrganizationRequest $request, $id)
    {
        $organization = Organization::query()->where('id', $id)->first();
        if (!$organization) {
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'No se pudo encontrar la organización.'
            );
        }

        $organization->update($request->all());
        return $this->sendResponse(
            $organization->toArray(),
            Response::HTTP_OK,
            'Organizacion actualizada satisfactoriamente.'
        );
    }


    public function destroy($id)
    {
        $organization = Organization::query()->where('id', $id)->first();
        if (!$organization) {
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'No se pudo encontrar la organización.'
            );
        }

        $organization->delete();

        return $this->sendResponse(
            [],
            Response::HTTP_NO_CONTENT,
            'Organizacion eliminada satisfactoriamente.'
        );
    }

    public function findByDni(Builder $organizations, $nit)
    {
        return $organizations->where('nit', 'like', "%{$nit}%");
    }
}
