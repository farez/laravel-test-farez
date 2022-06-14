<?php

namespace App\Http\Livewire;

use App\Models\ShippingCharge;
use Livewire\Component;

class NewSaleForm extends Component
{
    public $quantity;
    public $unitCost;
    public $products;
    public $product = 'gold_coffee'; // Default to Gold coffee in the form.
    public $productSelectOptions; // Product options for the form.
    public $shippingCost;

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

        $this->shippingCost = ShippingCharge::orderByDesc('created_at')->firstOrFail();
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
        $sellingPrice = ($cost / (1 - $this->getMargin($this->product))) + $this->shippingCost->cost;
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
            'shipping_cost' => $this->shippingCost->cost,
            'selling_price' => $this->getSellingPriceProperty(),
        ]);

        // Increment the number of sales for this shipping cost.
        $this->shippingCost->number_of_sales = $this->shippingCost->number_of_sales + 1;
        $this->shippingCost->save();

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
