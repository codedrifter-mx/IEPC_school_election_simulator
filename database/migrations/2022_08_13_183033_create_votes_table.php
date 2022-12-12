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
        Schema::create('votes', function (Blueprint $table) {
            $table->id('vote_id')->comment('Id voto');
            $table->unsignedBigInteger('elector_id')->comment('Id votador');
            $table->foreign('elector_id')->references('elector_id')->on('electors')->onDelete("cascade");
            $table->unsignedBigInteger('candidate_id')->comment('Id candidato');
            $table->foreign('candidate_id')->references('candidate_id')->on('candidates')->onDelete("cascade");
            $table->unsignedBigInteger('event_id')->comment('Id evento');
            $table->foreign('event_id')->references('event_id')->on('events')->comment('Id evento');
        });

        $table = "votes";
        $comment = "Votos";

        DB::statement("ALTER TABLE " . $table . " COMMENT = '" . $comment . "'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('votes');
    }
};
