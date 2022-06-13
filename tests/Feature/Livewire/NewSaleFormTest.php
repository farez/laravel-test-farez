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

}
