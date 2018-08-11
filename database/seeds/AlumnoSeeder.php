<?php

use Illuminate\Database\Seeder;

class AlumnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        
        factory(App\Alumno::class, 30)->create()->each(function(App\Alumno $post) {
            $post->curso()->attach([
                rand(1,5), 
                rand(6,15)
            ]);
        });
    }
}
