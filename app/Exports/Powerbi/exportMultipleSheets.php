<?php

namespace App\Exports\Powerbi;

use App\Exports\Powerbi\sellersExport;
use App\Exports\Powerbi\visitsExport;
use App\Exports\Powerbi\reasonForNotVisitExport;
use App\Exports\Powerbi\membersExport;
use App\Exports\Powerbi\membersPositionExport;
use App\Exports\Powerbi\organizationExport;
use App\Exports\Powerbi\formsExport;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class exportMultipleSheets implements WithMultipleSheets
{
    use Exportable;

    public $surveys;
    public $sellers;

    public function __construct($_surveys, $_sellers)
    {
        $this->surveys = $_surveys;
        $this->sellers = $_sellers;
    }

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new sellersExport();
        $sheets[] = new visitsExport();
        $sheets[] = new reasonForNotVisitExport();
        $sheets[] = new organizationExport();
        $sheets[] = new membersExport();
        $sheets[] = new membersPositionExport();

        foreach ($this->surveys as $survey) {
            foreach ($this->sellers as $seller) {
                if ($seller->surveyId == $survey->id) {
                    $sheets[] = new formsExport($survey->id, $survey->title, $seller);
                }
            }
        }


        return $sheets;
    }

}

