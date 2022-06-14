<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NewSaleForm extends Component
{
    public $quantity;
    public $unitCost;
    public $products;
    public $product = 'gold_coffee'; // Default to Gold coffee in the form.
    public $productSelectOptions; // Product options for the form.

    protected $rules = [
        'quantity' => 'required|numeric|integer|gt:0',
        'unitCost' => 'required|numeric|gt:0.1',
        'product' => 'required',
    ];

    public function mount()
    {
        $this->products = config('coffee.products');
        foreach ($this->products as $productId => $productData) {
            $this->productSelectOptions[$productId] = $productData['label'];
        }
    }

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
        $sellingPrice = ($cost / (1 - $this->getMargin($this->product))) + config('coffee.shipping_cost');
        return $sellingPrice;
    }

    public function createSale()
    {
        $this->validate();

        auth()->user()->sales()->create([
            'product' => $this->getLabel($this->product),
            'quantity' => $this->quantity,
            'unit_cost' => $this->unitCost,
            'profit_margin' => $this->getMargin($this->product),
            'shipping_cost' => config('coffee.shipping_cost'),
            'selling_price' => $this->getSellingPriceProperty(),
        ]);

        $this->emit('new_sale_created');
    }

    public function getLabel($product)
    {
        return $this->products[$product]['label'];
    }

    public function getMargin($product)
    {
        return $this->products[$product]['margin'];
    }
}
