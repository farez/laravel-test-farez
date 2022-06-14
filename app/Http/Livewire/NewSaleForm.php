<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NewSaleForm extends Component
{
    public $quantity;
    public $unitCost;

    protected $rules = [
        'quantity' => 'required|numeric|integer|gt:0',
        'unitCost' => 'required|numeric|gt:0.1',
    ];

    public function render()
    {
        return view('livewire.new-sale-form');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function getSellingPriceProperty()
    {
        $cost = intval($this->quantity) * floatval($this->unitCost);
        if ($cost <= 0) {
            return 0.00;
        }
        $sellingPrice = ($cost / (1 - config('coffee.profit_margin'))) + config('coffee.shipping_cost');
        return $sellingPrice;
    }

    public function createSale()
    {
        $this->validate();

        auth()->user()->sales()->create([
            'product' => 'Gold coffee',
            'quantity' => $this->quantity,
            'unit_cost' => $this->unitCost,
            'profit_margin' => config('coffee.profit_margin'),
            'shipping_cost' => config('coffee.shipping_cost'),
            'selling_price' => $this->getSellingPriceProperty(),
        ]);
    }
}
