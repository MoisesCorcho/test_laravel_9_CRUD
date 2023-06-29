<?php

namespace App\Http\Controllers\MemberPosition;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\MemberPosition;
use App\Http\Controllers\BaseController;

class MemberPositionController extends BaseController
{
    public function getMemberPositions()
    {
        $positions = MemberPosition::select('id', 'name')->get();

        if (is_null($positions)) {
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'No se encontraron las posiciones.'
            );
        }

        return $this->sendResponse(
            $positions->toArray(),
            Response::HTTP_OK,
            'Posiciones encontradas satisfactoriamente.'
        );

    }
}
