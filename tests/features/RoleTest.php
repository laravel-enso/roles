<?php

use App\Owner;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\RoleManager\app\Models\Role;
use LaravelEnso\TestHelper\app\Traits\SignIn;
use LaravelEnso\TestHelper\app\Traits\TestCreateForm;
use LaravelEnso\TestHelper\app\Traits\TestDataTable;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use RefreshDatabase, SignIn, TestDataTable, TestCreateForm;

    private $faker;
    private $prefix = 'system.roles';

    protected function setUp()
    {
        parent::setUp();

        // $this->withoutExceptionHandling();
        $this->faker = Factory::create();
        $this->signIn(User::first());
    }

    /** @test */
    public function store()
    {
        $postParams = $this->postParams();
        $response = $this->post(route('system.roles.store', $postParams, false));

        $role = Role::whereName($postParams['name'])->first();

        $response->assertStatus(200)
            ->assertJsonFragment([
                'message'  => 'The role was created!',
                'redirect' => 'system.roles.edit',
                'id'       => $role->id,
            ]);
    }

    /** @test */
    public function edit()
    {
        $role = Role::first();

        $response = $this->get(route('system.roles.edit', $role->id, false));

        $response->assertStatus(200)
            ->assertJsonStructure(['form']);
    }

    /** @test */
    public function update()
    {
        $role = Role::create($this->postParams());
        $role->name = 'edited';

        $this->patch(route('system.roles.update', $role->id, false), $role->toArray())
            ->assertStatus(200)
            ->assertJson(['message' => __(config('enso.labels.savedChanges'))]);

        $this->assertEquals('edited', $role->fresh()->name);
    }

    /** @test */
    public function destroy()
    {
        $role = Role::create($this->postParams());

        $this->delete(route('system.roles.destroy', $role->id, false))
            ->assertStatus(200)
            ->assertJsonFragment(['message']);

        $this->assertNull($role->fresh());
    }

    /** @test */
    public function cant_destroy_if_has_users()
    {
        $role = Role::create($this->postParams());
        $this->createUser($role);

        $this->delete(route('system.roles.destroy', $role->id, false))
            ->assertStatus(409);

        $this->assertNotNull($role->fresh());
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
