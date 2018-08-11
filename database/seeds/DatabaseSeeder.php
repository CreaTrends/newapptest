<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(LaratrustSeeder::class);
        $this->call(CursosSeeder::class);
        $this->call(AlumnoSeeder::class);
        $this->call(NoteSeeder::class);
        // $this->call(UsersTableSeeder::class);
    }
}
