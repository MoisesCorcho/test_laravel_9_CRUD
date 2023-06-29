<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveyQuestionAnswers', function (Blueprint $table) {
            $table->id();
            $table->text('answer')
                ->nullable()
                ->comment('Campo para almacenar las respuestas en formato JSON');
            $table->boolean('state')
                ->default(0)
                ->comment('Estado de la pregunta, activa o inactiva');

            //Foraneas
            // $table->foreignId('surveyQuestionId')
            //     ->constrained('surveyQuestions')
            //     ->comment('Foranea - Preguntas');

            // $table->foreignId('surveyAnswerId')
            //     ->constrained('surveyAnswers')
            //     ->comment('Foranea - Respuestas');

            $table->foreignIdFor(\App\Models\SurveyQuestion::class, 'surveyQuestionId');
            $table->foreignIdFor(\App\Models\SurveyAnswer::class, 'surveyAnswerId');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_question_answers');
    }
};
