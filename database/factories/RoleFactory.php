<?php

namespace LaravelEnso\Roles\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaravelEnso\Menus\Models\Menu;
use LaravelEnso\Roles\Models\Role;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'display_name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'menu_id' => Menu::factory(),
        ];
    }
}
