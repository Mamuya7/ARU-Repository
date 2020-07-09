<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Department;
use Faker\Generator as Faker;

$factory->define(Department::class, function (Faker $faker) {
    return [
        'department_name' => $faker->name,
        'department_code' => $faker->name,
        'school_id' => factory(App\School::class),
    ];
});
