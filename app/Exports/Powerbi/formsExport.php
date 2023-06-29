<?php

namespace App\Exports\Powerbi;

use Illuminate\Support\Arr;

use App\Models\Survey;
use App\Models\SurveyAnswer;
use App\Models\SurveyQuestion;
use App\Models\SurveyQuestionAnswer;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class formsExport implements
    FromQuery,
    WithTitle,
    WithHeadings,
    ShouldAutoSize,
    WithMapping
{

    public $surveyid;
    public $surveyName;
    public $seller;
    public $fechaInicio;
    public $fechaFinal;


    public function __construct(int $_surveyid, string $_surveyName, $_seller)
    {
        $this->surveyid   = $_surveyid;
        $this->surveyName = $_surveyName;
        $this->seller     = $_seller;
        $this->fechaInicio = request()->fecha_inicio;
        $this->fechaFinal = request()->fecha_final;
    }

    public function creatingHeadings()
    {
        $Myheadings = [];

        $data = SurveyQuestion::query()
        ->where('surveyId', $this->surveyid)
        ->get();

        foreach ($data as $question) {
            array_push($Myheadings, $question['question']);
        }

        array_push($Myheadings, 'estado');
        array_push($Myheadings, 'fecha');

        return $Myheadings;
    }

    public function cleanArray($arr)
    {
        foreach ($this->creatingHeadings() as $head) {
            $arr[$head] = "";
        }

        return $arr;
    }

    public function formatingHeadings (Array $headings)
    {
        $ArrResponse = [];
        $ArrResponse2 = [];

        foreach ($headings as $key => $heading) {
            $ArrResponse["id"] = $heading;
            array_push($ArrResponse2, $ArrResponse);
        }

        $ArrResponse = collect($ArrResponse2)->keyBy('id');

        $ArrResponse = $this->cleanArray($ArrResponse);

        return $ArrResponse->toArray();
    }

    public function createArray (Array $array)
    {
        $arrResponse = [];

        foreach ($array as $arr) {
            $arrResponse[] = $arr;
        }

        return $arrResponse;
    }

    //Retorna un arreglo de arreglos (el numero de estos será el numero de respuestas que haya)
    public function createArray2 ()
    {
        $fInicio = $this->fechaInicio;
        $fFinal  = $this->fechaFinal;

        $numRespuestas = SurveyAnswer::where('sellerId', $this->seller->id)
            ->when($fFinal, function ($query) use ($fInicio, $fFinal) {
                $query->whereBetween('surveyAnswers.date', [$fInicio, $fFinal]);
            })
            ->pluck('id');

        $arrResponse = [];

        foreach ($numRespuestas as $value) {
            $arrResponse = Arr::add($arrResponse, $value, []);
        }

        return $arrResponse;
    }

    public function creatingMap2()
    {
        $fInicio = $this->fechaInicio;
        $fFinal  = $this->fechaFinal;

        $data = SurveyQuestion::query()
            ->select(
                'surveyQuestions.*',
                'surveyQuestionAnswers.*',
                'surveyAnswers.*',
                'surveyQuestionAnswers.id as surveyQuestionAnswersId',
                'surveyAnswers.created_at as fechaFiltro'
                )
            ->join('surveyQuestionAnswers', 'surveyQuestionAnswers.surveyQuestionId', '=', 'surveyQuestions.id')
            ->join('surveyAnswers', 'surveyQuestionAnswers.surveyAnswerId', '=', 'surveyAnswers.id')
            ->where('surveyQuestions.surveyId', $this->surveyid)
            ->where('surveyAnswers.sellerId', $this->seller->id)
            ->when($fFinal, function ($query) use ($fInicio, $fFinal) {
                $query->whereBetween('surveyAnswers.date', [$fInicio, $fFinal]);
            })
            ->get();

        $finalArray = $this->createArray2();
        $finalArray2 = [];

        $headings = $this->creatingHeadings();
        $arrayHeadingsKey = $this->formatingHeadings($headings); //Subarreglo que hará parte del arreglo que se retornará.

        foreach ($finalArray as $key => $value) {
            array_push($finalArray[$key] , $arrayHeadingsKey);
        }

        //Recorremos las preguntas.
        foreach ($data as $key => $d) {

            //Obtenemos la pregunta.
            $sq = SurveyQuestion::where(['question' => $d['question'], 'surveyId' => $this->surveyid])->first();

            if ($sq) {
                //Obtenemos la respuesta de la pregunta.
                $sqa = SurveyQuestionAnswer::query()
                    ->where('surveyQuestionId', $sq->id)
                    ->where('id', $d->surveyQuestionAnswersId)
                    ->first();

                if (stristr($sqa->answer, '["')) {
                    $sqa->answer = str_replace(['"', '[', ']'], '', $sqa->answer);
                }

                $finalArray[$d->surveyAnswerId][0]["{$sq->question}"] = $sqa->answer;
            }

            if ($d->state == 1 and $d->questionOfThingsToDo == 1) {
                $finalArray[$d->surveyAnswerId][0]["estado"] = 'Pendiente';
            }

            if ($d->state == 0 and $d->questionOfThingsToDo == 1) {
                $finalArray[$d->surveyAnswerId][0]["estado"] = 'Finalizado';
            }

            $finalArray[$d->surveyAnswerId][0]["fecha"] = date_format(date_create($d->date), 'Y/m/d');

        }

        foreach ($finalArray as $key => $value) {
            $finalArray[$key][0] = $this->createArray($finalArray[$key][0]);
        }

        foreach ($finalArray as $arr) {
            array_push($finalArray2, $arr[0]);
        }

        return $finalArray2;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        /**
         * Se retorna una coleccion de un solo miembro para que no se repitan valores en la funcion de map
         * Esto por la forma poco convencional en que hice este Export, debido a la forma en que los datos
         * se guardaron en BD.
         */
        // return collect(1);

        return Survey::query()
            ->where('id', $this->surveyid);

    }

    public function title(): string
    {
        return "{$this->surveyName} {$this->seller->firstName}";
    }

    public function headings(): array
    {
        return $this->creatingHeadings();
    }

    public function map($client): array
    {
        return $this->creatingMap2();
    }

}


