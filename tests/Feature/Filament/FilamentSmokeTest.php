<?php

declare(strict_types=1);

namespace Tests\Feature\Filament;

use App\Filament\Resources\Categories\CategoryResource;
use App\Filament\Resources\Orders\OrderResource;
use App\Filament\Resources\Products\ProductResource;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class FilamentSmokeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Ensure a clean permission cache for each run
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function test_guest_is_redirected_to_login_when_visiting_resources(): void
    {
        $this->get(ProductResource::getUrl('index'))
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function test_user_with_permissions_can_access_core_resource_pages(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        // Minimal permissions to access index & create pages
        $perms = [
            'view_any_product', 'create_product',
            'view_any_order', 'create_order',
            'view_any_category', 'create_category',
        ];
        foreach ($perms as $name) {
            Permission::findOrCreate($name);
        }
        $user->givePermissionTo($perms);

        $this->actingAs($user);

        // Products
        $this->get(ProductResource::getUrl('index'))->assertOk();
        $this->get(ProductResource::getUrl('create'))->assertOk();

        // Orders
        $this->get(OrderResource::getUrl('index'))->assertOk();
        $this->get(OrderResource::getUrl('create'))->assertOk();

        // Categories
        $this->get(CategoryResource::getUrl('index'))->assertOk();
        $this->get(CategoryResource::getUrl('create'))->assertOk();
    }
}
