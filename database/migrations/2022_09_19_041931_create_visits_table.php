<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('visitDate')
                ->comment('Fecha en que se realiza la');
            $table->date('rescheduledDate')
                ->default(null)
                ->comment('Fecha de reagendamiento')
                ->nullable();
            $table->text('reasonForNotVisitDesc')
                ->comment('Descripcion de porque no se pudo realizar la visita')
                ->nullable();
            $table->enum('status', [
                'scheduled',
                'visited',
                'notVisited',
                'canceled',
                'rescheduled'
            ])->default('scheduled')
                ->comment('Estado de la visita');

            //Foraneas
            $table->foreignUuid('sellerId')
                ->constrained('users')
                ->comment('Foranea - vendedor que realiza la visita');
            $table->foreignUuid('reasonForNotVisitId')
                ->nullable()
                ->constrained('reasonForNotVisits')
                ->comment('Foranea - Razón por la cual no se realizó la visita');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('visits');
    }
};
