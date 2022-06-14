<div class="sm:w-3/4">
    <form wire:submit.prevent="createShippingCharge" class="flex flex-col sm:w-1/4">
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
</div>
