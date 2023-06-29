<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('memberPositions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')
                ->comment('Posicion dentro de la organización');
            $table->text('description')
                ->comment('Descripcion de la posicion dentro de la organización')
                ->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('member_positions');
    }
};
