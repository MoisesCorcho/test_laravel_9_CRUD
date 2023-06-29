<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->foreignUuid('organizationId')
                ->constrained('organizations')
                ->onUpdate('cascade')
                ->onDelete('cascade')
                ->comment('Foranea - cliente con el cual se realiza la visita');
        });
    }


    public function down()
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->dropColumn('memberId');
        });
    }
};
