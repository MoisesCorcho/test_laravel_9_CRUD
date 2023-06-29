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
        Schema::create('surveyAnswers', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date')
                ->nullable()
                ->comment('Fecha en la que se realizó la respuesta del formulario');

            //Foraneas
            // $table->foreignId('surveyId')
            //     ->constrained('surveys')
            //     ->comment('Foranea - Formulario al cual pertenecen las respuestas');

            $table->foreignIdFor(\App\Models\Survey::class, 'surveyId');
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
        Schema::dropIfExists('survey_answers');
    }
};
