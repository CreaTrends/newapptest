<?php

use Faker\Generator as Faker;

$factory->define(App\Note::class, function (Faker $faker) {
    $title = $faker->sentence(4);
    return [
        //
        'curso_id'  =>  rand(1,15),
        'user_id'  =>  rand(1,7),
        'subject'   =>  $title,
        'body'      =>  $faker->text(500),
        'attached'  =>  $faker->imageUrl($width = 1200, $height = 400),
        'status'    =>  $faker->randomElement(['1', '1']),
        'sticky'    =>  $faker->randomElement(['0', '1'])
    ];
});
