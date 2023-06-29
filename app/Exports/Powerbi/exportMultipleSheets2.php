<?php

namespace App\Exports\Powerbi;

use App\Exports\Powerbi\formsExport;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class exportMultipleSheets2 implements WithMultipleSheets
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

