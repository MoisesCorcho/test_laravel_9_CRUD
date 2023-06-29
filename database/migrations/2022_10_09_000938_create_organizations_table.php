<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')
                ->comment('Nombre de la organización Cliente');
            $table->text('description')
                ->comment('Descripcion de la organización cliente')
                ->nullable();
            $table->string('nit')
                ->comment('Numero de identificacion tributaria de la organización')
                ->unique();
            $table->string('address')
                ->comment('Direccion de la organización cliente')
                ->nullable();
            $table->string('cellphone')
                ->comment('Numero de celular de la organización cliente')
                ->nullable();
            $table->string('phone')
                ->comment('Numero de telefono de la organización cliente')
                ->nullable();
            $table->string('email')
                ->comment('Correo electronico de la organización cliente')
                ->nullable()
                ->unique();
            $table->string('city')
                ->comment('Ciudad de la organización cliente')
                ->nullable();
            $table->foreignUuid('sellerId')
                ->nullable()
                ->comment('Foranea - Vendedor asignado')
                ->constrained('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('organizations');
    }
};
