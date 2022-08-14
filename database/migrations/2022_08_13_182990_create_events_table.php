<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('events', function (Blueprint $table) {
            $table->id('event_id')->comment('Id evento');
            $table->unsignedBigInteger('user_id')->comment('Id organizacion');
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->string('name')->comment('Nombre evento');
            $table->string('schedule')->comment('Horario');
            $table->foreign('schedule')->references('schedule')->on('schedules');
            $table->string('director')->comment('Nombre completo director');
            $table->string('in_charge')->comment('Nombre completo responsable');
            $table->unsignedBigInteger('population')->comment('Poblacion estudiantil');
            $table->unsignedMediumInteger('groups')->comment('Poblacion estudiantil');
            $table->timestamp('added_at')->nullable()->comment('Creacion de eleccion');
            $table->timestamp('start_at')->nullable()->comment('Inicio de eleccion');
            $table->timestamp('end_at')->nullable()->comment('Fin de eleccion');
        });

        $table = "events";
        $comment = "Eventos electorales";

        DB::statement("ALTER TABLE " . $table . " COMMENT = '" . $comment . "'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
};
