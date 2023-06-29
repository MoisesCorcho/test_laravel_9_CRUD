<?php

namespace App\Http\Controllers\ImportExport;

use Illuminate\Support\Arr;

use App\exports\FormsExport;
use Illuminate\Http\Request;
use App\Imports\CustomersImport;
use App\exports\PendingVisitsExport;

use App\Exports\Powerbi\powerBiJson;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Powerbi\powerBiJson3;
use App\exports\Clients\ClientsExport;
use App\exports\Clients\MembersExport;
use App\Http\Controllers\BaseController;
use PHPUnit\Framework\Constraint\IsJson;
use App\exports\Clients\ClientsExportCsv;
use App\exports\Clients\ClientsExportTsv;
use App\exports\Powerbi\exportMultipleSheets;
use App\Exports\Powerbi\exportMultipleSheets2;
use Symfony\Component\HttpFoundation\Response;

class ImportExportController extends BaseController
{
    /**
     * Funcion para importar clientes de archivo excel
     *
     * @return void
     */
    public function importOrganizations()
    {
        $file   = request()->file('file');
        $import = new CustomersImport;
        $import->import($file);

        if ($import->failures()->first()) {
            return $this->errorResponse(
                Response::HTTP_OK,
                'Error al importar las organizaciones.',
                $import->failures()->toArray()
            );
        }

        return $this->sendResponse(
            [],
            Response::HTTP_OK,
            'Organizaciones importadas con exito.'
        );
    }

    public function exportClientsXlsx()
    {
        return Excel::download(new ClientsExport, 'clients.xlsx');
    }

    public function exportClientsCsv()
    {
        return Excel::download(new ClientsExportCsv, 'clients-csv.csv');
    }

    public function exportClientsTsv()
    {
        return Excel::download(new ClientsExportTsv, 'clients-tsv.tsv', \Maatwebsite\Excel\Excel::TSV);
    }

    public function pendingVisits()
    {
        return Excel::download(new PendingVisitsExport, 'pendingVisits.xlsx');
    }

    public function exportMembersXlsx()
    {
        return Excel::download(new MembersExport, 'members.xlsx');
    }

    /**
     * Exporta la informacion del formulario que se quiera.
     *
     * @return void
     */
    public function exportForms()
    {

        $surveys = \App\Models\Survey::where('status', 1)->get();
        $sellers = \App\Models\User::role('Seller')->get();

        return (new exportMultipleSheets2($surveys, $sellers))->download('powerbiDataVeca.xlsx');
    }

    /**
     * Genera un excel con la informacion de las tablas en BD para luego hacer reportes en powerBi
     *
     * @return void
     */
    public function powerbiExport()
    {
        $surveys = \App\Models\Survey::where('status', 1)->get();
        $sellers = \App\Models\User::role('Seller')->get();

        return (new exportMultipleSheets($surveys, $sellers))->download('powerbiDataVeca.xlsx');
    }

    public function powerbiJson()
    {
        $powerBiJson = [];

        $activeSurveys = \App\Models\Survey::where('status', 1)->get();
        $sellers = \App\Models\User::role('Seller')->get();
        $organizations      = \App\Models\Organization::all();
        $members            = \App\Models\Member::all();
        $visits             = \App\Models\Visit::all();
        $reasonForNotVisits = \App\Models\ReasonForNotVisit::all();
        $memberPositions = \App\Models\MemberPosition::all();

        $addArrays = [];

        foreach ($activeSurveys as $survey) {
            foreach ($sellers as $seller) {
                if ($seller->surveyId == $survey->id) {
                    $response = new powerBiJson($survey->id, $survey->title, $seller);
                    $powerBiJson = $response->creatingMap2();
                    $addArrays = Arr::add($addArrays, "{$survey->title} {$seller->firstName}", $powerBiJson);
                }
            }
        }

        $arrayResponse = [
            "sellers"            => $sellers,
            "organizations"      => $organizations,
            "members"            => $members,
            "memberPositions"    => $memberPositions,
            "visits"             => $visits,
            "reasonForNotVisits" => $reasonForNotVisits,
            "Surveys"            => $addArrays,
        ];

        return response()->json($arrayResponse);
    }

    public function powerbiJson2()
    {
        $powerBiJson = [];

        $activeSurveys = \App\Models\Survey::where('status', 1)->get();
        $sellers = \App\Models\User::role('Seller')->get();
        $organizations      = \App\Models\Organization::all();
        $members            = \App\Models\Member::all();
        $visits             = \App\Models\Visit::all();
        $reasonForNotVisits = \App\Models\ReasonForNotVisit::all();
        $memberPositions = \App\Models\MemberPosition::all();

        $addArrays = [];

        foreach ($activeSurveys as $survey) {
            $response = new powerBiJson3($survey->id, $survey->title);
            $powerBiJson = $response->creatingMap2();
            $addArrays = Arr::add($addArrays, "{$survey->title}", $powerBiJson);
        }

        $arrayResponse = [
            "sellers"            => $sellers,
            "organizations"      => $organizations,
            "members"            => $members,
            "memberPositions"    => $memberPositions,
            "visits"             => $visits,
            "reasonForNotVisits" => $reasonForNotVisits,
            "Surveys"            => $addArrays,
        ];

        return response()->json($arrayResponse);
    }
}
