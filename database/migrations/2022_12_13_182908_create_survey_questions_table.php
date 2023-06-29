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
        Schema::create('surveyQuestions', function (Blueprint $table) {
            $table->id();
            $table->string('type')
                ->comment('Tipo de pregunta - text, textarea, select, radio, checkbox');
            $table->string('question')
                ->comment('Campo para guardar la pregunta');
            $table->text('description')
                ->nullable()
                ->comment('Descripcion de la pregunta');
            $table->text('tableType')
                ->nullable()
                ->comment('Los tipos son "organization", "member", "memberPosition" para identificar cuales son las preguntas que usaran datos de otras tablas.');
            $table->text('data')
                ->nullable()
                ->comment('Se guardará un JSON con las preguntas cuando hayan opciones (select, radio, etc) de otro modo será vacio');
            $table->boolean('questionOfThingsToDo')
                ->default(0)
                ->comment('Identificador para saber si es una pregunta utilizada para almacenar los pendientes dejados en las citas');
            $table->timestamps();

            //Foraneas
            // $table->foreignId('surveyId')
            //     ->constrained('surveys')
            //     ->comment('Foranea - Formulario al cual pertenecen las preguntas');

            $table->foreignIdFor(\App\Models\Survey::class, 'surveyId');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_questions');
    }
};
