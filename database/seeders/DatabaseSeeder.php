<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('levels')->insert([
            'level' => 'Primaria'
        ]);
        DB::table('levels')->insert([
            'level' => 'Secundaria'
        ]);
        DB::table('levels')->insert([
            'level' => 'Preparatoria'
        ]);
        DB::table('levels')->insert([
            'level' => 'Universidad'
        ]);
        DB::table('levels')->insert([
            'level' => 'Otro'
        ]);

        DB::table('levels')->insert([
            'level' => 'Administrador'
        ]);


        DB::table('schedules')->insert([
            'schedule' => 'Matutino'
        ]);
        DB::table('schedules')->insert([
            'schedule' => 'Mixto'
        ]);
        DB::table('schedules')->insert([
            'schedule' => 'Vespertino'
        ]);
        DB::table('schedules')->insert([
            'schedule' => 'Nocturno'
        ]);


        DB::table('users')->insert([
            'name' => 'Primaria Benito Juarez #402',
            'email' => 'a@a.com',
            'password' => '$2y$10$X.TEnrR1kcDcjgurs/CwE.n3tqC7kGP6vLVv8vpic.WOqqZEZyZty',
            'level' => 'Primaria',
        ]);

        DB::table('users')->insert([
            'name' => 'Secundaria Paraiso #8',
            'email' => 'b@b.com',
            'password' => '$2y$10$X.TEnrR1kcDcjgurs/CwE.n3tqC7kGP6vLVv8vpic.WOqqZEZyZty',
            'level' => 'Secundaria',
        ]);

        DB::table('users')->insert([
            'name' => 'Preparatoria Diurna #1',
            'email' => 'c@c.com',
            'password' => '$2y$10$X.TEnrR1kcDcjgurs/CwE.n3tqC7kGP6vLVv8vpic.WOqqZEZyZty',
            'level' => 'Preparatoria',
        ]);

        DB::table('users')->insert([
            'name' => 'Universidad Juarez del estado de Durango #942',
            'email' => 'd@d.com',
            'password' => '$2y$10$X.TEnrR1kcDcjgurs/CwE.n3tqC7kGP6vLVv8vpic.WOqqZEZyZty',
            'level' => 'Universidad',
        ]);

        DB::table('users')->insert([
            'name' => 'IEPC',
            'email' => 'e@e.com',
            'password' => '$2y$10$X.TEnrR1kcDcjgurs/CwE.n3tqC7kGP6vLVv8vpic.WOqqZEZyZty',
            'level' => 'Administrador',
            'email_verified_at' => '2022-01-01 00:00:00',
        ]);
    }
}
