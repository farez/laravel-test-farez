<?php

namespace App\Http\Livewire;

use App\Models\ShippingCharge;
use Livewire\Component;

class NewShippingForm extends Component
{
    public $shippingCost;

    protected $rules = [
        'shippingCost' => 'required|numeric|gt:0',
    ];

    public function render()
    {
        $costs = ShippingCharge::orderByDesc('created_at')->get();
        return view('livewire.new-shipping-form', compact('costs'));
    }

    public function createShippingCharge()
    {
        $this->validate();

        ShippingCharge::create([
            'cost' => $this->shippingCost,
            'number_of_sales' => 0,
        ]);

        $this->shippingCost = '';
    }
}
