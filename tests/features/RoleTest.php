<?php

use Faker\Factory;
use Tests\TestCase;
use LaravelEnso\Core\app\Models\User;
use LaravelEnso\RoleManager\app\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use LaravelEnso\FormBuilder\app\TestTraits\EditForm;
use LaravelEnso\FormBuilder\app\TestTraits\CreateForm;
use LaravelEnso\FormBuilder\app\TestTraits\DestroyForm;
use LaravelEnso\VueDatatable\app\Traits\Tests\Datatable;

class RoleTest extends TestCase
{
    use CreateForm, Datatable, DestroyForm, EditForm, RefreshDatabase;

    private $permissionGroup = 'system.roles';
    private $testModel;

    protected function setUp()
    {
        parent::setUp();

        // $this->withoutExceptionHandling();

        $this->seed()
            ->actingAs(User::first());

        $this->testModel = factory(Role::class)
            ->make();
    }

    /** @test */
    public function can_store_role()
    {
        $response = $this->post(
            route('system.roles.store'),
            $this->testModel->toArray()
        );

        $role = Role::whereName($this->testModel->name)
            ->first();

        $response->assertStatus(200)
            ->assertJsonFragment([
                'redirect' => 'system.roles.edit',
                'param' => ['role' => $role->id],
            ])->assertJsonStructure([
                'message'
            ]);
    }

    /** @test */
    public function can_update_role()
    {
        $this->testModel->save();

        $this->testModel->name = 'edited';

        $this->patch(
            route('system.roles.update', $this->testModel->id, false),
            $this->testModel->toArray()
        )->assertStatus(200)
        ->assertJsonStructure(['message']);

        $this->assertEquals('edited', $this->testModel->fresh()->name);
    }

    /** @test */
    public function cant_destroy_if_has_users()
    {
        $this->testModel->save();

        factory(User::class)->create([
            'role_id' => $this->testModel->id,
        ]);

        $this->delete(route('system.roles.destroy', $this->testModel->id, false))
            ->assertStatus(409);

        $this->assertNotNull($this->testModel->fresh());
    }
}
