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
        Schema::create('electors', function (Blueprint $table) {
            $table->id('elector_id')->comment('Id votador');
            $table->unsignedBigInteger('event_id')->comment('Id evento');
            $table->foreign('event_id')->references('event_id')->on('events');
            $table->string('name')->comment('Nombres');
            $table->string('paternal_surname')->comment('Apellido paterno');
            $table->string('maternal_surname')->comment('Apellido materno');
            $table->string('email')->nullable()->comment('Correo votador');
            $table->string('code')->unique()->comment('Codigo evento');
            $table->timestamps();
        });

        $table = "electors";
        $comment = "Electores";

        DB::statement("ALTER TABLE " . $table . " COMMENT = '" . $comment . "'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('electors');
    }
};
