<?php

namespace App\Exports;

use App\Models\Survey;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class FormsExport implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithMapping
{

    public $questions = [];

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        /**
         * Se retorna una coleccion de un solo miembro para que no se repitan valores en la funcion de map
         * Esto por la forma poco convencional en que hice este Export, debido a la forma en que los datos
         * se guardaron en BD.
         */
        return collect(1);

    }

    public function headings(): array
    {
        $data = \App\Models\Survey::query()
        ->select('question')
        ->join('surveyQuestions', 'surveyQuestions.surveyId', '=', 'surveys.id')
        // ->where('createdForSeller', request('createdFor'))
        ->where('surveys.id', request('surveyId'))
        ->get();

        foreach ($data as $question) {
            array_push($this->questions, $question['question']);
        }

        return $this->questions;
    }

    public function map($client): array
    {
        $data = \App\Models\Survey::query()
            ->join('surveyQuestions', 'surveyQuestions.surveyId', '=', 'surveys.id')
            ->join('surveyQuestionAnswers', 'surveyQuestionAnswers.surveyQuestionId', '=', 'surveyQuestions.id')
            // ->where('createdForSeller', request('createdFor'))
            ->where('surveys.id', request('surveyId'))
            ->get();

        $answers  = []; //Arreglo que retornaremos.
        $answers2 = []; //Subarreglo que hará parte del arreglo que se retornará.

        $numberOfQuestions = \App\Models\Survey::query()
        ->select('question')
        ->join('surveyQuestions', 'surveyQuestions.surveyId', '=', 'surveys.id')
        // ->where('createdForSeller', request('createdFor'))
        ->where('surveys.id', request('surveyId'))
        ->count();

        $cont = 0;

        //Vamos a llenar un array de arrays
        foreach ($data as $d) {

            if (is_array(json_decode($d['answer'])) ) {
                array_push($answers2, json_decode($d['answer']));
            } else {
                array_push($answers2, $d['answer']);
            }

            if ($cont == ($numberOfQuestions-1)) {
                array_push($answers, $answers2);
                $answers2 = [];
                $cont=0;
            } else {
                $cont++;
            }

        }

        return $answers;
    }

}
