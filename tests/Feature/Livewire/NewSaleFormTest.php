<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\NewSaleForm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class NewSaleFormTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(NewSaleForm::class);

        $component->assertStatus(200);
    }

    /** @test */
    public function sales_page_contains_new_sale_form_component()
    {
        Livewire::actingAs(User::factory()->create());
        $this->get(route('coffee.sales'))->assertSeeLivewire('new-sale-form');
    }

    /** @test */
    public function sales_page_visible_to_authenticated_user()
    {
        Livewire::actingAs(User::factory()->create());
        $this->get(route('coffee.sales'))->assertOk();
    }

    /** @test */
    public function sales_page_not_visible_publicly()
    {
        $this->get(route('coffee.sales'))->assertSee('login');
    }

    /** @test */
    public function sales_page_contains_previous_sales_component()
    {
        Livewire::actingAs(User::factory()->create());
        $this->get(route('coffee.sales'))->assertSeeLivewire('previous-sales');
    }

    /** @test */
    public function selling_price_is_calculated_and_displayed_correctly()
    {
        Livewire::test(NewSaleForm::class, ['quantity' => 3, 'unitCost' => '5.50'])
            ->assertSet('sellingPrice', 16.50)
            ->assertSee('16.50');
    }
}
