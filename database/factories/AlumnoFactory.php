<?php


use Faker\Generator as Faker;
$factory->define(App\Alumno::class, function (Faker $faker) {
    
    $title = $faker->sentence(4);
    $gender = $faker->randomElements(['male', 'female'])[0];
    $color = str_replace('#', '', $faker->hexcolor);
    $avatar_url = 'https://ui-avatars.com/api/?length=2&size=128&background='.$color.'&color=fff&name=';
    return [
        
        'firstname' => $faker->firstName($gender),
        'lastname'  => $faker->lastName,
        'city'      => 'Santiago',
        'address'   => $faker->address,
        'gender'    => $gender,
        'allow_photos'  => '1',
        'image'=> 'default.jpg',
        'status'    =>'1'
    ];
});