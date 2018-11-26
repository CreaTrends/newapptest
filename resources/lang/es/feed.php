<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Parent Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used by the paginator library to build
    | the simple pagination links. You are free to change them to anything
    | you want to customize your views to better match your application.
    |
    */
    'accepted'             => 'The :attribute must be accepted.',
    'previous' => '&laquo; Previous',
    'next' => 'Next &raquo;',

    'type'=>[
        'food'=>'Comidas y Alimentos',
        'nap'=>'Siestas',
        'deposition'=>'Mudas / Baño',
        'photo'=>':attribute fue etiquetado en una foto',
        'activity'=>':attribute Realizó actividades hoy',
        'nota'=>':attribute '
    ],
    'moods'=>[
        'happy' => 'Feliz',
        'sad' => 'Triste',
        'normal'=>'Estado normal'
    ],
    'food'=>[
        'type'=>':attribute ',
        'amount'=>':attribute',
        'breakfast' => 'Desayuno :',
        'midmorning' => 'Colación AM :',
        'lunch' => 'Almuerzo :',
        'evening' => 'colación PM :',
        'dinner' => 'cena :',
        'milk' => 'leche :',
        'salad' => 'ensalada :',
        'none' => 'Nada',
            'some' => 'Algo',
            'half' => 'La Mitad',
            'most' => 'Casi Todo',
            'all' => 'todo',
        
    ],
    'deposition'=>[
        'time' => 'Hora : :attribute',
        'type' => ':attribute',
        'hard' => 'duro'
    ],
    'nap'=>[
        'start' => ':name durmió desde :attribute',
        'end' => ' hasta :attribute'
    ],
    'food_amount'=>[
        'none' => 'Nada',
        'some' => 'Algo',
        'half' => 'La Mitad',
        'most' => 'Casi Todo',
        'all' => 'todo',
    ],
    'tagged'=>':Name fue etiquetado en una imagen'

];