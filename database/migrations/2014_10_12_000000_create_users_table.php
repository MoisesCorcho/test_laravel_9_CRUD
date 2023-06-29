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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('firstName')
                ->comment('Nombre del usuario');
            $table->string('lastName')
                ->comment('Apellido del usuario');
            $table->string('photo')
                ->comment('Foto de perfil de usuario')
                ->nullable();
            $table->string('cellphone')
                ->comment('Numero de celular del usuario')
                ->nullable();
            $table->string('email')
                ->comment('Correo electronico del usuario')
                ->nullable()
                ->unique();
            $table->enum('dniType', [
                'CC',
                'NIT'
            ])->default('CC')
                ->comment('Tipo de documento de identidad del usuario');
            $table->string('dni')
                ->comment('Numero de identificacion del usuario')
                ->unique();
            $table->string('password')
                ->comment('Contraseña del usuario');
            $table->boolean('active')
                ->default(true)
                ->comment('Estado del usario');
            $table->integer('visitsPerDay')
                ->default(8)
                ->comment('Numero de visitas diarias del usuario');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
};
