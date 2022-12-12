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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id')->comment('Id usuario');
            $table->string('name')->comment('Nombre organizacion / funcionario');
            $table->string('charge')->nullable()->comment('Cargo funcionario');
            $table->string('municipality')->nullable()->comment('Municipio');
            $table->string('address')->nullable()->comment('Domicilio');
            $table->string('email')->unique()->comment('Correo');
            $table->timestamp('email_verified_at')->nullable()->comment('Verificacion');
            $table->string('level');
            $table->foreign('level')->references('level')->on('levels')->comment('Nivel');
            $table->string('password')->comment('Contrasena organizacion');


            $table->rememberToken()->comment('Interno');
            $table->timestamps();
        });

        $table = "users";
        $comment = "Organizaciones";

        DB::statement("ALTER TABLE " . $table . " COMMENT = '" . $comment . "'");
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
