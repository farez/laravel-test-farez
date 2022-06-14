<div class="w-3/4 mt-8">
    <h3 class="font-semibold text-lg text-gray-800 leading-tight">{{ __('Previous sales') }}</h3>
        <table class="min-w-full divide-y divide-gray-200 mt-4 border border-gray-200">
            <thead class="bg-gray-50">
                <tr class="text-xs text-gray-500 uppercase tracking-wider">
                    <th scope="col" class="px-6 py-3 font-medium text-left">{{ __('Quantity') }}</th>
                    <th scope="col" class="px-6 py-3 font-medium text-left">{{ __('Unit Cost (£)') }}</th>
                    <th scope="col" class="px-6 py-3 font-medium text-left">{{ __('Selling Price') }}</th>
                </tr>
            </thead>
            <tbody>
                @if($sales->isNotEmpty())
                    @foreach($sales as $sale)
                        <tr class="{{ $loop->odd? 'bg-white' : 'bg-gray-50'}}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-left">
                                {{ $sale->quantity }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-left">
                                &pound;{{ number_format($sale->unit_cost, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-left">
                                &pound;{{ number_format($sale->selling_price, 2) }}
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="p-4">
                            {{ __('No sale yet.') }}
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
</div>
