<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upper_candidates', function (Blueprint $table) {
            $table->id('candidate_id')->comment('Id candidato');
            $table->string('candidate_key', 8)->unique()->comment('Clave del candidato');
            $table->unsignedBigInteger('event_id')->comment('Id evento');
            $table->foreign('event_id')->references('event_id')->on('events')->onDelete("cascade")->comment('Id evento');

            $table->string('teamname')->comment('Nombre planilla');
            $table->string('name')->comment('Nombres');
            $table->string('paternal_surname')->comment('Apellido paterno');
            $table->string('maternal_surname')->comment('Apellido materno');

            $table->timestamps();
        });

        $table = "candidates";
        $comment = "Candidatos a elejir";

        DB::statement("ALTER TABLE " . $table . " COMMENT = '" . $comment . "'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidates');
    }
};
