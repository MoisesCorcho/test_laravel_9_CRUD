<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up()
    {
        Schema::create('reasonForNotVisits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')
                ->comment('Nombre de la razon por la cual no se pude cambiar la visita');
            $table->timestamps();
        });

    }


    public function down()
    {
        Schema::dropIfExists('reason_for_not_visits');
    }
};
