<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NewSaleForm extends Component
{
    public $quantity;
    public $unitCost;

    public function mount()
    {
        $this->quantity;
        $this->unitCost;
    }

    public function render()
    {
        return view('livewire.new-sale-form');
    }

    public function getSellingPriceProperty()
    {
        return $this->quantity * $this->unitCost;
    }
}
