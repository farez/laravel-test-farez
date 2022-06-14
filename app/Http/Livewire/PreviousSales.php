<?php

namespace App\Http\Livewire;

use App\Models\Sale;
use Livewire\Component;

class PreviousSales extends Component
{
    public $sales;

    protected $listeners = [
        'new_sale_created' => 'actionNewSaleCreated'
    ];

    public function mount()
    {
        $this->sales = Sale::orderByDesc('created_at')->get();
    }

    public function actionNewSaleCreated()
    {
        $this->sales = Sale::orderByDesc('created_at')->get();
    }

    public function render()
    {
        return view('livewire.previous-sales');
    }
}
