<?php

namespace App\Exports\Powerbi;

use Illuminate\Support\Arr;

use App\Models\SurveyAnswer;
use App\Models\SurveyQuestion;
use App\Models\SurveyQuestionAnswer;


class powerBiJson3 {

    public $surveyid;
    public $surveyName;
    // public $surveyId
    public function __construct(int $_surveyid, string $_surveyName)
    {
        $this->surveyid   = $_surveyid;
        $this->surveyName = $_surveyName;
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
        array_push($Myheadings, 'sellerId');

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

    public function createArray2 ()
    {
        $numRespuestas = SurveyAnswer::where('surveyId', $this->surveyid)->pluck('id');

        $arrResponse = [];

        foreach ($numRespuestas as $value) {
            $arrResponse = Arr::add($arrResponse, $value, []);
        }

        return $arrResponse;
    }

    public function creatingMap2()
    {
        $data = SurveyQuestion::query()
            ->select(
                'surveyQuestions.*',
                'surveyQuestionAnswers.*',
                'surveyAnswers.*',
                'surveyQuestionAnswers.id as surveyQuestionAnswersId',
                'surveyAnswers.sellerId as sellerIdAnswer'
                )
            ->join('surveyQuestionAnswers', 'surveyQuestionAnswers.surveyQuestionId', '=', 'surveyQuestions.id')
            ->join('surveyAnswers', 'surveyQuestionAnswers.surveyAnswerId', '=', 'surveyAnswers.id')
            ->where('surveyQuestions.surveyId', $this->surveyid)
            ->get();

        // dd($data[40]);

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

                $finalArray[$d->surveyAnswerId][0]["{$sq->question}"] = $sqa->answer;
            }

            if ($d->state == 1 and $d->questionOfThingsToDo == 1) {
                $finalArray[$d->surveyAnswerId][0]["estado"] = 1;
            }

            if ($d->state == 0 and $d->questionOfThingsToDo == 1) {
                $finalArray[$d->surveyAnswerId][0]["estado"] = "0";
            }

            $finalArray[$d->surveyAnswerId][0]["fecha"] = $d->date;

            $finalArray[$d->surveyAnswerId][0]["sellerId"] = $d->sellerIdAnswer;

        }

        // foreach ($finalArray as $key => $value) {
        //     $finalArray[$key][0] = $this->createArray($finalArray[$key][0]);
        // }

        foreach ($finalArray as $arr) {
            array_push($finalArray2, $arr[0]);
        }

        return $finalArray2;
    }


}
