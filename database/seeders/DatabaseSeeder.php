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
        // \App\Models\User::factory(10)->create();



        DB::table('levels')->insert([
            'level' => 'Primaria'
        ]);
        DB::table('levels')->insert([
            'level' => 'Secundaria'
        ]);
        DB::table('levels')->insert([
            'level' => 'Bachillerato'
        ]);
        DB::table('levels')->insert([
            'level' => 'Universidad'
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


        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'level' => 'Primaria',
        ]);
    }
}
