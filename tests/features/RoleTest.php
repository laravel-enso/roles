<?php

use App\Owner;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\RoleManager\app\Models\Role;
use LaravelEnso\TestHelper\app\Classes\TestHelper;

class RoleTest extends TestHelper
{
    use DatabaseMigrations;

    private $faker;

    protected function setUp()
    {
        parent::setUp();

        // $this->disableExceptionHandling();
        $this->faker = Factory::create();
        $this->signIn(User::first());
    }

    /** @test */
    public function index()
    {
        $this->get('/system/roles')
            ->assertStatus(200)
            ->assertViewIs('laravel-enso/rolemanager::index');
    }

    /** @test */
    public function create()
    {
        $this->get('/system/roles/create')
            ->assertStatus(200)
            ->assertViewIs('laravel-enso/rolemanager::create')
            ->assertViewHas('form');
    }

    /** @test */
    public function store()
    {
        $postParams = $this->postParams();
        $response = $this->post('/system/roles', $postParams);

        $role = Role::whereName($postParams['name'])->first();

        $response->assertStatus(200)
            ->assertJsonFragment([
                'message'  => 'The role was created!',
                'redirect' => '/system/roles/'.$role->id.'/edit',
            ]);
    }

    /** @test */
    public function edit()
    {
        $role = Role::first();

        $response = $this->get('/system/roles/'.$role->id.'/edit');

        $response->assertStatus(200)
            ->assertViewHas('role', $role)
            ->assertViewIs('laravel-enso/rolemanager::edit')
            ->assertViewHas('form');
    }

    /** @test */
    public function update()
    {
        $role = Role::create($this->postParams());
        $role->name = 'edited';
        $data = $role->toArray();

        $this->patch('/system/roles/'.$role->id, $data)
            ->assertStatus(200)
            ->assertJson(['message' => __(config('labels.savedChanges'))]);

        $this->assertEquals('edited', Role::whereId($role->id)->first(['name'])->name);
    }

    /** @test */
    public function destroy()
    {
        $role = Role::create($this->postParams());

        $this->delete('/system/roles/'.$role->id)
            ->assertStatus(200)
            ->assertJsonFragment(['message']);

        $this->assertNull(Role::whereName($role->name)->first());
    }

    /** @test */
    public function cant_destroy_if_has_users()
    {
        $role = Role::create($this->postParams());
        $this->createUser($role);

        $this->delete('/system/roles/'.$role->id)
            ->assertStatus(455);

        $this->assertNotNull(Role::whereId($role->id)->first());
    }

    private function createUser($role)
    {
        $user = new User([
            'first_name' => $this->faker->firstName,
            'last_name'  => $this->faker->lastName,
            'phone'      => $this->faker->phoneNumber,
            'is_active'  => 1,
        ]);
        $user->email = $this->faker->email;
        $user->owner_id = Owner::first(['id'])->id;
        $user->role_id = $role->id;
        $user->save();
    }

    private function postParams()
    {
        return [
            'name'         => $this->faker->word,
            'display_name' => $this->faker->word,
            'description'  => $this->faker->sentence,
            'menu_id'      => Menu::first(['id'])->id,
            '_method'      => 'POST',
        ];
    }
}
