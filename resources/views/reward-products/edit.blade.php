<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">
                Edit Produk Reward
            </h2>
            <a href="{{ route('reward-products.index') }}"
                class="text-gray-600 hover:text-gray-900 font-medium transition">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow border border-gray-200 p-6 sm:p-8">
                <form action="{{ route('reward-products.update', $rewardProduct) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $rewardProduct->name) }}"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 border">
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">Tipe</label>
                        <select id="type" name="type" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 border">
                            <option value="food" {{ old('type', $rewardProduct->type) == 'food' ? 'selected' : '' }}>
                                Makanan</option>
                            <option value="drink" {{ old('type', $rewardProduct->type) == 'drink' ? 'selected' : '' }}>
                                Minuman</option>
                        </select>
                        @error('type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="points_cost" class="block text-sm font-medium text-gray-700">Harga Poin</label>
                            <input type="number" name="points_cost" id="points_cost"
                                value="{{ old('points_cost', $rewardProduct->points_cost) }}" min="0" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 border">
                            @error('points_cost') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700">Stok Tersedia</label>
                            <input type="number" name="stock" id="stock"
                                value="{{ old('stock', $rewardProduct->stock) }}" min="0" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 border">
                            @error('stock') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', $rewardProduct->is_active) ? 'checked' : '' }}
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-900">
                            Aktif (Tersedia untuk ditukarkan)
                        </label>
                    </div>

                    <div class="pt-5 border-t border-gray-200 flex justify-end">
                        <x-primary-button>Simpan Perubahan</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>