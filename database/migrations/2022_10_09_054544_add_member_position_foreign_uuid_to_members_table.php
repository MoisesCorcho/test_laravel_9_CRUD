<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->foreignUuid('memberPositionId')
                ->constrained('memberPositions')
                ->comment('Foranea - Posicion del miembro dentro de la empresa');
        });
    }


    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('memberPositionId');
        });
    }
};
