<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Controllers\BaseController;
use App\Models\Member;
use App\Http\Requests\Member\StoreMemberRequest;
use App\Http\Requests\Member\UpdateMemberRequest;

class MemberController extends BaseController
{

    // public function index(Request $request)
    // {
    //     $member     = Member::query();
    //     $perPage    = $request->page_size ?? 20;
    //     $dni        = $request->dni ?? null;

    //     if ($dni) $member = $this->findByDni($member, $dni);

    //     return $this->sendResponse(
    //         $member->paginate($perPage)
    //             ->toArray(),
    //         Response::HTTP_OK,
    //         'Miembros encontrados correctamente.'
    //     );
    // }

    // Filtrar usuario por dni
    // public function findByDni(Builder $member, $dni)
    // {
    //     $member->where('dni', 'LIKE', "%$dni%");
    // }

    public function index(Request $request)
    {
        $name    = $request->name;
        $dni     = $request->dni;
        $perPage = $request->page_size ?? 20;

        $members = Member::query()
        ->when($dni,  function ($query, $dni) {
            $query->where('dni', 'like', "%$dni%");
        })
        ->when($name, function ($query, $name) {
            $query->where('firstName', 'like', "%$name%");
        });

        return $this->sendResponse(
            $members->paginate($perPage)
                ->toArray(),
            Response::HTTP_OK,
            'Miembros encontrados correctamente.'
        );
    }


    public function store(StoreMemberRequest $request)
    {
        $member = new Member();
        $member->firstName        = $request->firstName;
        $member->lastName         = $request->lastName;
        $member->dniType          = $request->dniType;
        $member->dni              = $request->dni;
        $member->address          = $request->address;
        $member->cellphone1       = $request->cellphone1;
        $member->cellphone2       = $request->cellphone2;
        $member->phone            = $request->phone;
        $member->birthday         = $request->birthday;
        $member->email            = $request->email;
        $member->memberPositionId = $request->memberPositionId;
        $member->organizationId   = $request->organizationId;
        $member->save();

        return $this->sendResponse(
            $member->toArray(),
            Response::HTTP_OK,
            'Miembro creado satisfactoriamente.'
        );
    }


    public function show($id)
    {
        $member = Member::query()->where('id', $id)->first();

        if (is_null($member)) {
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'Miembro no encontrado.'
            );
        }

        return $this->sendResponse(
            $member->toArray(),
            Response::HTTP_OK,
            'Miembro encontrado satisfactoriamente.'
        );
    }


    public function update(UpdateMemberRequest $request, $id)
    {
        $member = Member::query()->where('id', $id)->first();

        if (is_null($member)) {
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'Miembro no encontrado.'
            );
        }

        $member->update($request->all());

        return $this->sendResponse(
            $member->toArray(),
            Response::HTTP_OK,
            'Miembro actualizado satisfactoriamente.'
        );
    }


    public function destroy($id)
    {
        $member = Member::find($id);

        if (is_null($member)) {
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'Miembro no encontrado.'
            );
        }

        $member->delete();

        return $this->sendResponse(
            [],
            Response::HTTP_NO_CONTENT,
            'Usuario eliminado satisfactoriamente.'
        );
    }


}
