<?php

use Faker\Generator as Faker;
use LaravelEnso\Menus\app\Models\Menu;
use LaravelEnso\Roles\app\Models\Role;

$factory->define(Role::class, fn(Faker $faker) => [
    'name' => $faker->word,
    'display_name' => $faker->word,
    'description' => $faker->sentence,
    'menu_id' => fn() => factory(Menu::class)->create()->id,
]);
