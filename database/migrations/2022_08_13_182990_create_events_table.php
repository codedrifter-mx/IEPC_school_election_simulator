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
            $table->string('event_key', 8)->unique()->comment('Clave del evento');
            $table->unsignedBigInteger('user_id')->comment('Id organizacion');
            $table->foreign('user_id')->references('user_id')->on('users');

            $table->string('name')->comment('Nombre evento');
            $table->string('cycle')->comment('Ciclo Escolar');
            $table->unsignedBigInteger('population')->comment('Total Alumnos');
            $table->unsignedMediumInteger('groups')->comment('Total Grupos');
            $table->string('schedule')->comment('Turno');
            $table->foreign('schedule')->references('schedule')->on('schedules');

            $table->string('director')->comment('Nombre completo director');
            $table->string('responsible')->comment('Nombre completo responsable');
            $table->string('responsible_phone')->comment('Telefono responsable');

            $table->timestamp('start_at')->comment('Inicio de eleccion');
            $table->timestamp('end_at')->nullable()->comment('Fin de eleccion');
            $table->boolean('approved')->default(false)->comment('Aprobado IEPC');
            $table->timestamps();
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
