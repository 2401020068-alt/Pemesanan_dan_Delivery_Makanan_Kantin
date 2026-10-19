<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KantinKuTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_landing_page_accessible()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('KantinKu');
    }

    public function test_buyer_pages_accessible()
    {
        $this->get('/buyer')->assertStatus(200);
        $this->get('/buyer/canteens')->assertStatus(200);
        $this->get('/buyer/canteens/s1')->assertStatus(200);
        $this->get('/buyer/menu')->assertStatus(200);
        $this->get('/buyer/cart')->assertStatus(200);
        $this->get('/buyer/orders')->assertStatus(200);
        $this->get('/buyer/orders/ORD-1001')->assertStatus(200);
        $this->get('/buyer/disputes')->assertStatus(200);
        $this->get('/buyer/profile')->assertStatus(200);
    }

    public function test_seller_pages_accessible()
    {
        $this->get('/seller')->assertStatus(200);
        $this->get('/seller/orders')->assertStatus(200);
        $this->get('/seller/orders/ORD-1001')->assertStatus(200);
        $this->get('/seller/shop')->assertStatus(200);
        $this->get('/seller/payments')->assertStatus(200);
        $this->get('/seller/profile')->assertStatus(200);
    }

    public function test_driver_pages_accessible()
    {
        $this->get('/driver')->assertStatus(200);
        $this->get('/driver/deliveries')->assertStatus(200);
        $this->get('/driver/profile')->assertStatus(200);
    }

    public function test_admin_pages_accessible()
    {
        $this->get('/admin')->assertStatus(200);
        $this->get('/admin/sellers')->assertStatus(200);
        $this->get('/admin/shops')->assertStatus(200);
        $this->get('/admin/users')->assertStatus(200);
        $this->get('/admin/reports')->assertStatus(200);
        $this->get('/admin/disputes')->assertStatus(200);
        $this->get('/admin/logs')->assertStatus(200);
        $this->get('/admin/profile')->assertStatus(200);
    }

    public function test_admin_can_export_csv()
    {
        $response = $this->get('/admin/reports/export');
        $response->assertStatus(200);
        $response->assertHeader('Content-Disposition', 'attachment; filename="laporan-transaksi-kantinku.csv"');
    }

    public function test_role_switcher_redirects()
    {
        $response = $this->get('/switch-role/seller');
        $response->assertRedirect('/seller');
    }

    public function test_can_add_to_cart_from_different_canteens()
    {
        // Add item from shop s1
        $this->post('/buyer/cart/add', [
            'menu_id' => 'm1',
            'qty' => 2,
        ])->assertRedirect();

        // Add item from shop s2
        $this->post('/buyer/cart/add', [
            'menu_id' => 'm5',
            'qty' => 1,
        ])->assertRedirect();

        $cart = session('cart');
        $this->assertCount(2, $cart);
        $this->assertEquals('s1', $cart['m1']['shop_id']);
        $this->assertEquals('s2', $cart['m5']['shop_id']);

        // Check cart page displays multi-canteen banner
        $response = $this->get('/buyer/cart');
        $response->assertStatus(200);
        $response->assertSee('Pesanan Multi-Kantin');

        // Check checkout page
        $checkoutResponse = $this->get('/buyer/checkout');
        $checkoutResponse->assertStatus(200);
    }

    public function test_profile_and_disputes_have_emerald_theme()
    {
        $profile = $this->get('/buyer/profile');
        $profile->assertStatus(200);
        $profile->assertSee('pattern-emerald');

        $disputes = $this->get('/buyer/disputes');
        $disputes->assertStatus(200);
        $disputes->assertSee('pattern-emerald');
    }
}
