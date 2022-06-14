<div class="sm:w-3/4">
    <form wire:submit.prevent="createShippingCharge" class="flex flex-col sm:w-1/4">
        @csrf
        <div>
            <label for="shippingCost" class="block text-sm font-medium text-gray-700"> {{ __('New cost of shipment') }} </label>
            <div class="mt-1">
                <input wire:model="shippingCost" type="text" name="shippingCost" id="shippingCost" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
            </div>
            @error('shippingCost') <span class="text-red-700">{{ $message }}</span> @enderror
        </div>
        <div class="mt-2">
            <button wire:loading.remove wire:target="createShippingCharge" type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">{{ __('Set new price') }}</button>
            <button wire:loading wire:target="createShippingCharge" disabled class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600">{{ __('Saving...') }}</button>
        </div>
    </form>


    <table class="min-w-full divide-y divide-gray-200 mt-8 border border-gray-200">
        <thead class="bg-gray-50">
            <tr class="text-xs text-gray-500 uppercase tracking-wider">
                <th scope="col" class="px-6 py-3 font-medium text-left">{{ __('Shipment Cost') }}</th>
                <th scope="col" class="px-6 py-3 font-medium text-left">{{ __('Active') }}</th>
                <th scope="col" class="px-6 py-3 font-medium text-left">{{ __('Set at') }}</th>
                <th scope="col" class="px-6 py-3 font-medium text-left">{{ __('Number of sales') }}</th>
            </tr>
        </thead>
        <tbody>
            @if($costs->isNotEmpty())
                @foreach($costs as $cost)
                    <tr class="{{ $loop->odd? 'bg-white' : 'bg-gray-50'}}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-left">
                            {{ number_format($cost->cost, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-left">
                            @if($loop->first)
                                {{ __('Yes') }}
                            @else
                                {{ __('No') }}
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-left">
                            {{ $cost->created_at }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-left">
                            {{ $cost->number_of_sales }}
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" class="p-4">
                        {{ __('No shipping charges have been set yet.') }}
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
