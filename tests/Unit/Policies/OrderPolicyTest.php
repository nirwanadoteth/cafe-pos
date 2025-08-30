<?php

namespace Tests\Unit\Policies;

use App\Models\Order;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class OrderPolicyTest extends TestCase
{
    public function test_user_without_permissions_cannot_update(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->create();

        $this->be($user);

        $this->assertFalse($user->can('update', $order));
    }

    public function test_user_with_permission_can_update(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->create();

        // Ensure permission tables are clear of cache and grant real permission
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        Permission::firstOrCreate(['name' => 'update_order', 'guard_name' => 'web']);
        $user->givePermissionTo('update_order');

        $this->be($user);

        $this->assertTrue($user->can('update', $order));
    }
}
