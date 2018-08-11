<?php

use Faker\Generator as Faker;

$factory->define(App\Curso::class, function (Faker $faker) {
	$title = $faker->unique()->company;
    return [
        //

        'name'=> $title,
        'slug'=> str_slug($title)
    ];
});
