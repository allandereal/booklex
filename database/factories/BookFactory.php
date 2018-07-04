<?php

use Faker\Generator as Faker;

$factory->define(App\Book::class, function (Faker $faker) {
    return [
        'isbn' => $faker->randomNumber(8),
        'title' => $faker->text(30),
        'authorId' => 1,
        'publisherId' => 1,
        'edition' => $faker->randomNumber(1),
        'yearPublished' => $faker->year,
        'price' => $faker->randomNumber(5),
        'created_by' => 1,
    ];
});
