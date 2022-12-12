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
            $table->string('elector_key', 8)->unique()->comment('Clave Elector');
            $table->string('event_key');
            $table->foreign('event_key')->references('event_key')->on('events')->onDelete("cascade")->comment('Clave evento');

            $table->string('paternal_surname')->comment('Apellido paterno');
            $table->string('maternal_surname')->comment('Apellido materno');
            $table->string('name')->comment('Nombres');
            $table->string('grade')->comment('Grado');
            $table->string('group')->comment('Grupo');

            $table->string('email')->nullable()->comment('Correo Elector');

            $table->string('code')->unique()->comment('Codigo votacion');
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
