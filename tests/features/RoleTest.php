<?php

use App\Owner;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\RoleManager\app\Models\Role;
use Tests\TestCase;

class RoleTest extends TestCase
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
    public function index()
    {
        $response = $this->get('/system/roles');

        $response->assertStatus(200);
    }

    /** @test */
    public function create()
    {
        $response = $this->get('/system/roles/create');

        $response->assertStatus(200);
    }

    /** @test */
    public function store()
    {
        $postParams = $this->postParams();
        $response = $this->post('/system/roles', $postParams);

        $role = Role::whereName($postParams['name'])->first();

        $response->assertStatus(200)
            ->assertJsonFragment([
            'message' => 'The role was created!',
            'redirect'=>'/system/roles/'.$role->id.'/edit'
        ]);
    }

    /** @test */
    public function edit()
    {
        $role = Role::first();

        $response = $this->get('/system/roles/'.$role->id.'/edit');

        $response->assertStatus(200)
            ->assertViewHas('role', $role)
            ->assertViewHas('form');
    }

    /** @test */
    public function update()
    {
        $role = Role::create($this->postParams());
        $role->name = 'edited';
        $data = $role->toArray();
        $data['_method'] = 'PATCH';

        $response = $this->patch('/system/roles/'.$role->id, $data)
            ->assertStatus(200)
            ->assertJson(['message' => __(config('labels.savedChanges'))]);

        $this->assertTrue($this->wasUpdated($role));
    }

    /** @test */
    public function destroy()
    {
        $role = Role::create($this->postParams());

        $response = $this->delete('/system/roles/'.$role->id);

        $this->hasJsonConfirmation($response);
        $this->wasDeleted($role);
        $response->assertStatus(200);
    }

    /** @test */
    public function cantDestroyIfHasUsers()
    {
        $role = Role::create($this->postParams());
        $this->addNewUser($role);

        $response = $this->delete('/system/roles/'.$role->id);

        $response->assertStatus(302);
        $this->assertTrue($this->hasSessionErrorMessage());
        $this->wasNotDeleted($role);
    }

    private function wasUpdated($role)
    {
        return Role::whereId($role->id)->first(['name'])->name === 'edited';
    }

    private function wasDeleted($role)
    {
        return $this->assertNull(Role::whereName($role->name)->first());
    }

    private function wasNotDeleted($role)
    {
        return $this->assertNotNull(Role::whereId($role->id)->first());
    }

    private function hasSessionConfirmation($response)
    {
        return $response->assertSessionHas('flash_notification');
    }

    private function hasJsonConfirmation($response)
    {
        return $response->assertJsonFragment(['message']);
    }

    private function hasSessionErrorMessage()
    {
        return session('flash_notification')[0]->level === 'danger';
    }

    private function addNewUser($role)
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
             'name'                 => $this->faker->word,
             'display_name'         => $this->faker->word,
             'description'          => $this->faker->sentence,
             'menu_id'              => Menu::first(['id'])->id,
            '_method'               => 'POST',
        ];
    }
}
