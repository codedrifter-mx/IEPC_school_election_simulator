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
            $table->id('user_id')->comment('Id organizacion');;
            $table->string('name')->comment('Nombre organizacion');
            $table->string('email')->unique()->comment('Correo organizacion');
            $table->timestamp('email_verified_at')->nullable()->comment('Verificacion organizacion');
            $table->string('password')->comment('Contrasena organizacion');
            $table->string('level');
            $table->foreign('level')->references('level')->on('levels')->comment('Nivel escolar');

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
