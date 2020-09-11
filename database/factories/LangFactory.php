<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Lang_skill;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
$factory->define(Lang_skill::class, function (Faker $faker) {
	return [
        'language' => $faker->userName()
    ];
});