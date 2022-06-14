<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\NewShippingForm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
}
