<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('firstName')
                ->comment('Nombres del miembro de la organizacion cliente');
            $table->string('lastName')
                ->comment('Apellidos del miembro de la organizacion cliente');
            $table->enum('dniType', [
                'CC',
                'NIT'
            ])->default('NIT')
                ->comment('Tipo de documento de identidad');
            $table->string('dni')
                ->comment('Numero de documento de identidad')
                ->unique();
            $table->string('address')
                ->comment('Direccion del miembro de la organización cliente')
                ->nullable();
            $table->string('cellphone1')
                ->comment('Primer numero de celular del miembro de la organización cliente')
                ->nullable();
            $table->string('cellphone2')
                ->comment('Segundo numero de celular del miembro de la organización cliente')
                ->nullable();
            $table->string('phone')
                ->comment('Numero de telefono del miembro de la organización cliente')
                ->nullable();
            $table->date('birthday')
                ->comment('Fecha de nacimiento del miembro de la organización cliente')
                ->nullable();
            $table->string('email')
                ->comment('Correo electronico del miembro de la organización cliente')
                ->nullable()
                ->unique();
            $table->foreignUuid('organizationId')
                ->constrained('organizations')
                ->comment('Foranea - Organizacion a la cual pertenece este miembro');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('members');
    }
};
