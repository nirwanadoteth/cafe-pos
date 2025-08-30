<?php

declare(strict_types=1);

namespace Tests\Feature\Filament;

use App\Enums\OrderStatus;
use App\Filament\Resources\Orders\OrderResource;
use App\Models\Order;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class OrderPdfActionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    private function userWithOrderViewPermission(): User
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        Permission::findOrCreate('view_any_order');
        $user->givePermissionTo('view_any_order');

        return $user;
    }

    public function test_pdf_action_hidden_for_non_completed_order(): void
    {
        $user = $this->userWithOrderViewPermission();
        $order = Order::factory()->create(['status' => OrderStatus::New]);

        $response = $this->actingAs($user)->get(OrderResource::getUrl('index'));
        $response->assertOk();
        // Ensure the order is listed
        $response->assertSee((string) $order->number, escape: false);
        // PDF action should not be visible for non-completed orders
        $response->assertDontSee('PDF');
    }

    public function test_pdf_action_visible_for_completed_order(): void
    {
        $user = $this->userWithOrderViewPermission();
        $order = Order::factory()->create(['status' => OrderStatus::Completed]);

        $response = $this->actingAs($user)->get(OrderResource::getUrl('index'));
        $response->assertOk();
        // Ensure the order is listed
        $response->assertSee((string) $order->number, escape: false);
        // PDF action should be visible for completed orders
        $response->assertSee('PDF');
    }
}
