<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NewSaleForm extends Component
{
    public $quantity;
    public $unitCost;

    public function render()
    {
        return view('livewire.new-sale-form');
    }

    public function getSellingPriceProperty()
    {
        $cost = $this->quantity * $this->unitCost;
        $sellingPrice = ($cost / (1 - config('coffee.profit_margin'))) + config('coffee.shipping_cost');
        return $sellingPrice;
    }
}
