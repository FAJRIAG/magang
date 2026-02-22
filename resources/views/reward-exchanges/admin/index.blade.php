<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">
                Persetujuan Penukaran Reward
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded shadow-sm">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded shadow-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Waktu</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Karyawan</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Produk</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Poin</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($exchanges as $exchange)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $exchange->created_at->format('d M Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $exchange->employee ? $exchange->employee->name : 'Unknown' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ optional($exchange->rewardProduct)->name ?? 'Produk Dihapus' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-600">
                                        {{ number_format($exchange->points_spent) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($exchange->status == 'pending')
                                            <span
                                                class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Menunggu
                                            </span>
                                        @elseif($exchange->status == 'approved')
                                            <span
                                                class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                Disetujui
                                            </span>
                                        @elseif($exchange->status == 'rejected')
                                            <span
                                                class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800"
                                                title="{{ $exchange->reason }}">
                                                Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        @if($exchange->status == 'pending')
                                            <div class="flex justify-end space-x-2">
                                                <!-- Tombol Approve -->
                                                <form action="{{ route('reward-exchanges.admin.approve', $exchange) }}"
                                                    method="POST" onsubmit="return confirm('Setujui penukaran ini?');">
                                                    @csrf
                                                    <button type="submit"
                                                        class="bg-green-50 text-green-600 hover:bg-green-100 px-3 py-1 rounded border border-green-200 transition">
                                                        Setujui
                                                    </button>
                                                </form>

                                                <!-- Form Reject dengan Alasan -->
                                                <div x-data="{ open: false }" class="relative inline-block text-left">
                                                    <button @click="open = !open" type="button"
                                                        class="bg-red-50 text-red-600 hover:bg-red-100 px-3 py-1 rounded border border-red-200 transition">
                                                        Tolak
                                                    </button>

                                                    <div x-show="open" @click.away="open = false" style="display: none;"
                                                        class="origin-top-right absolute right-0 mt-2 w-64 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10 p-4">
                                                        <form action="{{ route('reward-exchanges.admin.reject', $exchange) }}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="mb-3 text-left">
                                                                <label
                                                                    class="block text-sm font-medium text-gray-700 mb-1">Alasan
                                                                    Penolakan</label>
                                                                <input type="text" name="reason" required
                                                                    class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500"
                                                                    placeholder="Stok habis...">
                                                            </div>
                                                            <div class="flex justify-end space-x-2">
                                                                <button type="button" @click="open = false"
                                                                    class="text-xs text-gray-500 hover:text-gray-700">Batal</button>
                                                                <button type="submit"
                                                                    class="text-xs bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">Submit</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        <p class="text-gray-500 font-medium">Belum ada pengajuan penukaran</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                @if($exchanges->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $exchanges->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>