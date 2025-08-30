<?php

namespace Tests\Unit\Policies;

use App\Models\Product;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class ProductPolicyTest extends TestCase
{
    public function test_user_without_permissions_cannot_update(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->be($user);

        $this->assertFalse($user->can('update', $product));
    }

    public function test_user_with_permission_can_update(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        app(PermissionRegistrar::class)->forgetCachedPermissions();
        Permission::firstOrCreate(['name' => 'update_product', 'guard_name' => 'web']);
        $user->givePermissionTo('update_product');

        $this->be($user);

        $this->assertTrue($user->can('update', $product));
    }
}
