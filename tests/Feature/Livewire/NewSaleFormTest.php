<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\NewSaleForm;
use App\Http\Livewire\PreviousSales;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;

class NewSaleFormTest extends TestCase
{
    use RefreshDatabase;

    /**
     * TESTS FOR NEW SALE FORM COMPONENT
     */

    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(NewSaleForm::class);

        $component->assertStatus(200);
    }

    /** @test */
    public function sales_page_contains_new_sale_form_component()
    {
        $this->actingAs(User::factory()->create());
        $this->get(route('coffee.sales'))->assertSeeLivewire('new-sale-form');
    }

    /** @test */
    public function sales_page_visible_to_authenticated_user()
    {
        $this->actingAs(User::factory()->create());
        $this->get(route('coffee.sales'))->assertOk();
    }

    /** @test */
    public function sales_page_not_visible_publicly()
    {
        $this->get(route('coffee.sales'))->assertSee('login');
    }

    /** @test */
    public function selling_price_is_calculated_and_displayed_correctly()
    {
        $quantity = 3;
        $unitCost = 5.50;
        $cost = $quantity * $unitCost;
        $sellingPrice = ($cost / (1 - config('coffee.profit_margin'))) + config('coffee.shipping_cost');

        Livewire::test(NewSaleForm::class, ['quantity' => $quantity, 'unitCost' => $unitCost])
            ->assertSet('sellingPrice', $sellingPrice)
            ->assertSee($sellingPrice);
    }

    /** @test  */
    function quantity_is_required()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(NewSaleForm::class, ['quantity' => ''])
            ->call('createSale')
            ->assertHasErrors(['quantity' => 'required']);
    }

    /** @test  */
    function quantity_is_integer()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(NewSaleForm::class, ['quantity' => 0.1])
            ->call('createSale')
            ->assertHasErrors(['quantity' => 'integer']);
    }

    /** @test  */
    function quantity_is_greater_than_zero()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(NewSaleForm::class, ['quantity' => 0])
            ->call('createSale')
            ->assertHasErrors(['quantity' => 'gt:0']);
    }

    /** @test  */
    function unitCost_is_required()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(NewSaleForm::class, ['unitCost' => ''])
            ->call('createSale')
            ->assertHasErrors(['unitCost' => 'required']);
    }

    /** @test  */
    function unit_cost_is_greater_than_zero_point_one()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(NewSaleForm::class, ['unitCost' => 0.05])
            ->call('createSale')
            ->assertHasErrors(['unitCost' => 'gt:0.1']);
    }

    /** @test  */
    function can_create_sale()
    {
        $this->actingAs(User::factory()->create());

        $product = 'Gold coffee';
        $quantity = 3;
        $unitCost = 5.50;
        $cost = $quantity * $unitCost;
        $profitMargin = config('coffee.profit_margin');
        $shippingCost = config('coffee.shipping_cost');
        $sellingPrice = ($cost / (1 - $profitMargin)) + $shippingCost;

        Livewire::test(NewSaleForm::class, [
            'product' => $product,
            'quantity' => $quantity,
            'unitCost' => $unitCost,
            'profit_margin' => $profitMargin,
            'shipping_cost' => $shippingCost,
            'selling_price' => $sellingPrice,
        ])->call('createSale');

        $this->assertTrue(DB::table('sales')
            ->where('product', '=', $product)
            ->where('quantity', '=', $quantity)
            ->where('unit_cost', '=', $unitCost)
            ->where('profit_margin', '=', $profitMargin)
            ->where('shipping_cost', '=', $shippingCost)
            ->where('selling_price', '=', $sellingPrice)
            ->exists());
    }

    /**
     * TESTS FOR PREVIOUS SALES COMPONENT
     */

    /** @test */
    public function sales_page_contains_previous_sales_component()
    {
        $this->actingAs(User::factory()->create());
        $this->get(route('coffee.sales'))->assertSeeLivewire('previous-sales');
    }

    /** @test */
    public function sale_details_are_visible_on_sales_page()
    {
        $this->actingAs(User::factory()->create());

        $product = 'Gold coffee';
        $quantity = 3;
        $unitCost = 5.50;
        $cost = $quantity * $unitCost;
        $profitMargin = config('coffee.profit_margin');
        $shippingCost = config('coffee.shipping_cost');
        $sellingPrice = ($cost / (1 - $profitMargin)) + $shippingCost;

        Livewire::test(NewSaleForm::class, [
            'product' => $product,
            'quantity' => $quantity,
            'unitCost' => $unitCost,
            'profit_margin' => $profitMargin,
            'shipping_cost' => $shippingCost,
            'selling_price' => $sellingPrice,
        ])->call('createSale');

        Livewire::test(PreviousSales::class)
            ->assertSee($quantity)
            ->assertSee($unitCost)
            ->assertSee($sellingPrice);
    }
}
