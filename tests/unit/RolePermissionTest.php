<?php

use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\PermissionManager\app\Models\Permission;
use LaravelEnso\RoleManager\app\Models\Role;
use Tests\TestCase;

class RolePermissionTest extends TestCase
{
    use DatabaseMigrations;

    private $faker;

    protected function setUp()
    {
        parent::setUp();

        // $this->disableExceptionHandling();
        $this->faker = Factory::create();
        $this->actingAs(User::first());
    }

    /** @test */
    public function update()
    {
        $role = Role::create($this->postParams());
        // $permissions = Permission::implicit()->pluck('id');
        // $role->permissions()->attach($permissions);
        // $role->menus()->attach($role->menu_id);
        $response = $this->get('/system/roles/getPermissions/'.$role->id);
        // dd($response);
        var_dump($response);

        // $this->assertEquals($role->permissions, Permission::implicit()->pluck('id'));

    }

    private function postParams()
    {
        return [
             'name' => $this->faker->word,
             'display_name' => $this->faker->word,
             'description' => $this->faker->sentence,
             'menu_id' => Menu::first(['id'])->id,
            '_method'               => 'POST',
        ];
    }
}
