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
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->string('title')
                ->comment('Titulo del formulario');
            $table->text('description')
                ->nullable()
                ->comment('Descripcion del formulario');
            $table->boolean('status')
                ->comment('Estado del formulario, activo o inactivo');
            $table->softDeletes();
            $table->timestamps();
            //Foraneas
            $table->foreignUuid('createdBy')
                ->constrained('users')
                ->comment('Foranea - Administrador creador del formulario');

            // $table->foreignUuid('createdForSeller')
            //     ->constrained('users')
            //     ->comment('Foranea - Vendedor asignado para el formulario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surveys');
    }
};
