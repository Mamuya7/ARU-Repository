<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->name,
        'last_name' => $faker->name,
        'username' => Str::random(6)."/1000"."/S.2020",
        'email' => $faker->unique()->safeEmail,
        'gender' => $faker->randomElement(['male','female']),
        'password' => Hash::make('password'),
        'department_id' => factory(App\Department::class),
    ];
});
