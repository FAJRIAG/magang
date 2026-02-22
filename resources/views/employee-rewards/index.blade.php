<x-employee-layout>
    <div class="space-y-6">

        <!-- Balance Card -->
        <div
            class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white transform transition hover:scale-105">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-white/20 rounded-lg p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
            </div>
            <p class="text-sm font-medium text-purple-100 uppercase tracking-wide">Saldo Reward Anda</p>
            <p class="text-4xl font-bold mt-2">{{ number_format($balance) }}</p>
            <p class="text-sm text-purple-100 mt-1">Poin tersedia untuk ditukar</p>
        </div>

        <!-- Reward Catalog -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200">
            <div
                class="px-6 py-5 bg-gradient-to-r from-blue-50 to-purple-50 border-b border-gray-200 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Katalog Reward</h2>
                    <p class="text-sm text-gray-600 mt-1">Tukarkan poin Anda dengan makanan atau minuman</p>
                </div>
            </div>

            <div class="p-6">
                <!-- Grid of Products -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($products as $product)
                        <div
                            class="bg-white border hover:border-blue-300 border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition">
                            <div class="p-5 flex flex-col items-center justify-center space-y-4">
                                @if($product->type == 'food')
                                    <div class="bg-orange-100 text-orange-600 p-4 rounded-full">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v1a2 2 0 01-2 2H5a2 2 0 01-2-2v-1a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                            </path>
                                        </svg>
                                    </div>
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-orange-100 text-orange-800">
                                        Makanan
                                    </span>
                                @else
                                    <div class="bg-blue-100 text-blue-600 p-4 rounded-full">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 12V8H6a2 2 0 01-2-2c0-1.1.9-2 2-2h12v4"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 6v12a2 2 0 002 2h12a2 2 0 002-2V8"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 12h4m-2-2v4"></path>
                                        </svg>
                                    </div>
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                        Minuman
                                    </span>
                                @endif

                                <h3 class="text-lg font-bold text-gray-900 text-center">{{ $product->name }}</h3>

                                <p class="text-2xl font-black text-purple-600">{{ number_format($product->points_cost) }}
                                    Poin</p>
                                <p class="text-xs text-gray-500">Sisa stok: {{ $product->stock }}</p>

                                @if($balance >= $product->points_cost)
                                    <form action="{{ route('employee-rewards.exchange', $product) }}" method="POST"
                                        class="w-full mt-4"
                                        onsubmit="return confirm('Tukar poin dengan {{ addslashes($product->name) }}?');">
                                        @csrf
                                        <button type="submit"
                                            class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-2.5 rounded-lg shadow-sm transition">
                                            Tukar Reward
                                        </button>
                                    </form>
                                @else
                                    <button disabled
                                        class="w-full mt-4 bg-gray-300 text-gray-500 font-bold py-2.5 rounded-lg cursor-not-allowed">
                                        Poin Tidak Cukup
                                    </button>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <p class="text-gray-500 font-medium">Belum ada katalog reward yang tersedia saat ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- History -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-bold text-gray-900">Riwayat Penukaran Anda</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Poin Dipotong
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($exchanges as $exchange)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $exchange->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ optional($exchange->rewardProduct)->name ?? 'Produk Dihapus' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-500">
                                    -{{ number_format($exchange->points_spent) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($exchange->status == 'pending')
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded bg-yellow-100 text-yellow-800">Menunggu</span>
                                    @elseif($exchange->status == 'approved')
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-800">Disetujui</span>
                                    @else
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded bg-red-100 text-red-800"
                                            title="{{ $exchange->reason }}">Ditolak</span>
                                        <span class="text-xs text-gray-500 block mt-1">Poin kembali</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500">
                                    Anda belum menukar reward apapun.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-employee-layout>