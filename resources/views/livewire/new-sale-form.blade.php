<div>
    <form>
        <div class="grid grid-cols-4 gap-4 align-baseline">
            <div>
                <label for="quantity" class="block text-sm font-medium text-gray-700"> {{ __('Quantity') }} </label>
                <div class="mt-1">
                    <input wire:model="quantity" type="text" name="quantity" id="quantity" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                </div>
            </div>
            <div>
                <label for="unitCost" class="block text-sm font-medium text-gray-700"> {{ __('Unit Cost £') }} </label>
                <div class="mt-1">
                    <input wire:model="unitCost" type="text" name="unitCost" id="unitCost" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                </div>
            </div>
            <div>
                <label for="sellingPrice" class="block text-sm font-medium text-gray-700"> {{ __('Selling Price') }} </label>
                <div class="mt-1">
                    <div wire:loading class="inline-block align-middle mt-2">{{ __('Calculating...') }}</div>
                    <div wire:loading.remove id="sellingPrice" class="inline-block align-middle mt-2 w-full sm:text-sm border-0 disabled">{{ number_format($this->sellingPrice, 2) }}</div>
                </div>
            </div>
            <div class="flex flex-col mt-auto">
                <button class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">{{ __('Record sale') }}</button>
            </div>
        </div>
    </form>
</div>
