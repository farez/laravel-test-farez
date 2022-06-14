<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\NewSaleForm;
use App\Http\Livewire\NewShippingForm;
use App\Models\Sale;
use App\Models\ShippingCharge;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;

class NewShippingFormTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(NewShippingForm::class);

        $component->assertStatus(200);
    }

    /** @test */
    public function shipping_page_contains_new_shipping_form_component()
    {
        $this->actingAs(User::factory()->create());
        $this->get(route('shipping.partners'))->assertSeeLivewire('new-shipping-form');
    }

    /** @test */
    public function shipping_page_visible_to_authenticated_user()
    {
        $this->actingAs(User::factory()->create());
        $this->get(route('shipping.partners'))->assertOk();
    }

    /** @test */
    public function shipping_page_not_visible_publicly()
    {
        $this->get(route('shipping.partners'))->assertSee('login');
    }

    /** @test  */
    function cost_is_required()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(NewShippingForm::class, ['shippingCost' => ''])
            ->call('createShippingCharge')
            ->assertHasErrors(['shippingCost' => 'required']);
    }

    /** @test  */
    function cost_is_numeric()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(NewShippingForm::class, ['shippingCost' => 'abc'])
            ->call('createShippingCharge')
            ->assertHasErrors(['shippingCost' => 'numeric']);
    }

    /** @test  */
    function cost_is_greater_than_0()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(NewShippingForm::class, ['shippingCost' => 0.00])
            ->call('createShippingCharge')
            ->assertHasErrors(['shippingCost' => 'gt:0']);
    }

    /** @test  */
    function can_create_active_shipping_cost()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(NewShippingForm::class, [
            'shippingCost' => 12.50,
        ])->call('createShippingCharge');
        $latestCost = ShippingCharge::orderByDesc('created_date')->first();

        $this->assertTrue($latestCost->cost == 12.50);
    }

    /** @test  */
    function can_see_shipping_cost_on_shipping_page()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(NewShippingForm::class, ['shippingCost' => 12.50,])
            ->call('createShippingCharge')
            ->assertSee(12.50);
    }

    /** @test  */
    function new_sale_uses_latest_shipping_cost()
    {
        $this->actingAs(User::factory()->create());

        // Create the shipping charge
        Livewire::test(NewShippingForm::class, ['shippingCost' => 12.50,])
            ->call('createShippingCharge');

        // Create the sale
        $product = 'gold_coffee';
        $quantity = 3;
        $unitCost = 5.50;
        Livewire::test(NewSaleForm::class, [
            'product' => $product,
            'quantity' => $quantity,
            'unitCost' => $unitCost,
        ])->call('createSale');

        // Get the latest sale
        $latestSale = Sale::orderByDesc('created_date')->first();

        $this->assertTrue($latestSale['shipping_cost'] == 12.50);
    }

    /** @test  */
    function new_sale_increments_number_of_sales()
    {
        $this->actingAs(User::factory()->create());

        // Create the shipping charge
        Livewire::test(NewShippingForm::class, ['shippingCost' => 12.50,])
            ->call('createShippingCharge');

        // Create the sale
        $product = 'gold_coffee';
        $quantity = 3;
        $unitCost = 5.50;
        Livewire::test(NewSaleForm::class, [
            'product' => $product,
            'quantity' => $quantity,
            'unitCost' => $unitCost,
        ])->call('createSale');

        // Get the latest sale
        $latestCost = ShippingCharge::orderByDesc('created_date')->first();

        $this->assertTrue($latestCost->number_of_sales == 1);
    }
}
