<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use LaravelEnso\Forms\TestTraits\CreateForm;
use LaravelEnso\Forms\TestTraits\DestroyForm;
use LaravelEnso\Forms\TestTraits\EditForm;
use LaravelEnso\Permissions\Models\Permission;
use LaravelEnso\Roles\Models\Role;
use LaravelEnso\Tables\Traits\Tests\Datatable;
use LaravelEnso\Users\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use CreateForm;
    use Datatable;
    use DestroyForm;
    use EditForm;
    use RefreshDatabase;

    private $permissionGroup = 'system.roles';
    private $testModel;
    private array $generatedConfigFiles = [];
    private string $rolesConfigPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->rolesConfigPath = storage_path('framework/testing/roles-'.env('TEST_TOKEN', (string) getmypid()));
        Config::set('enso.roles.configPath', $this->rolesConfigPath);
        File::ensureDirectoryExists($this->rolesConfigPath);

        $this->seed()
            ->actingAs(User::first());

        $this->testModel = Role::factory()
            ->make();
    }

    protected function tearDown(): void
    {
        collect($this->generatedConfigFiles)
            ->each(fn (string $path) => File::delete($path));

        File::deleteDirectory($this->rolesConfigPath);

        parent::tearDown();
    }

    #[Test]
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
                'param'    => ['role' => $role->id],
            ])->assertJsonStructure(['message']);
    }

    #[Test]
    public function can_update_role()
    {
        $this->testModel->save();

        $this->testModel->name = 'edited';

        $this->patch(
            route('system.roles.update', $this->testModel->id, false),
            $this->testModel->toArray()
        )->assertStatus(200)
            ->assertJsonStructure(['message']);

        $this->assertEquals($this->testModel->name, $this->testModel->fresh()->name);
    }

    #[Test]
    public function cant_destroy_if_has_users()
    {
        $this->testModel->save();

        User::factory()->create([
            'role_id' => $this->testModel->id,
        ]);

        $this->delete(route('system.roles.destroy', $this->testModel->id, false))
            ->assertStatus(409);

        $this->assertNotNull($this->testModel->fresh());
    }

    #[Test]
    public function can_get_role_options()
    {
        $this->testModel->save();

        $this->get(route('system.roles.options', [
            'query' => $this->testModel->name,
            'limit' => 10,
        ], false))
            ->assertStatus(200)
            ->assertJsonFragment(['name' => $this->testModel->name]);
    }

    #[Test]
    public function can_fetch_role_permissions_configuration()
    {
        $role = Role::factory()->create();
        $permission = Permission::factory()->create();
        $role->permissions()->sync([$permission->id]);

        $this->get(route('system.roles.permissions.get', $role, false))
            ->assertStatus(200)
            ->assertJsonFragment(['id' => $role->id])
            ->assertJsonFragment([$permission->id]);
    }

    #[Test]
    public function can_update_role_permissions()
    {
        $role = Role::factory()->create();
        $permissions = Permission::factory()->count(2)->create();

        $this->post(route('system.roles.permissions.set', $role, false), [
            'rolePermissions' => $permissions->pluck('id')->toArray(),
        ])->assertStatus(200)
            ->assertJsonFragment(['message' => "The role's permissions were successfully updated"]);

        $this->assertEqualsCanonicalizing(
            $permissions->pluck('id')->toArray(),
            $role->fresh()->permissions->pluck('id')->toArray()
        );
    }

    #[Test]
    public function can_write_role_permissions_config()
    {
        $role = Role::factory()->create([
            'name'         => 'field-agent-'.Str::lower(Str::random(8)),
            'display_name' => 'Field Agent',
        ]);
        $permission = Permission::factory()->create([
            'name' => 'testing.roles.write.'.Str::lower(Str::random(8)),
        ]);
        $role->permissions()->sync([$permission->id]);
        $filePath = $this->rolesConfigPath.DIRECTORY_SEPARATOR.$role->name.'.php';
        $this->generatedConfigFiles[] = $filePath;

        $this->post(route('system.roles.permissions.write', $role, false))
            ->assertStatus(200)
            ->assertJsonFragment(['message' => 'The config file was successfully written']);

        $this->assertFileExists($filePath);
    }

    #[Test]
    public function sync_command_reads_roles_from_local_config()
    {
        $name = 'synced-role-'.Str::lower(Str::random(8));
        $filePath = $this->rolesConfigPath.DIRECTORY_SEPARATOR.$name.'.php';

        File::ensureDirectoryExists($this->rolesConfigPath);
        File::put($filePath, '<?php return [];');
        $this->generatedConfigFiles[] = $filePath;

        $permission = Permission::factory()->create([
            'name' => 'testing.roles.sync.'.Str::lower(Str::random(8)),
        ]);
        File::put($filePath, <<<PHP
<?php

return [
    'order' => 99,
    'role' => [
        'name' => '{$name}',
        'display_name' => 'Synced Role',
    ],
    'default_menu' => null,
    'permissions' => ['{$permission->name}'],
];
PHP);

        $this->artisan('enso:roles:sync')
            ->assertExitCode(0);

        $role = Role::whereName($name)->first();

        $this->assertNotNull($role);
        $this->assertSame('Synced Role', $role->display_name);
        $this->assertTrue($role->permissions->pluck('name')->contains($permission->name));
    }
}
