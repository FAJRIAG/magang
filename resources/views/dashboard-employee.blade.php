<x-employee-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">
                Dashboard
            </h2>
            <p class="text-sm text-gray-500">{{ now()->locale('id')->translatedFormat('l, d F Y') }}</p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

                <!-- Reward Balance Card -->
                <div class="bg-white rounded-lg shadow border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-medium text-gray-600">Saldo Reward Anda</h3>
                            <div class="bg-purple-50 rounded-lg p-2">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-gray-900">{{ number_format($employee->reward_balance) }}</p>
                        <p class="text-xs text-gray-500 mt-1">Poin tersedia</p>
                    </div>
                </div>

                <!-- Last Tap Card -->
                <div class="bg-white rounded-lg shadow border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-medium text-gray-600">Tap Terakhir</h3>
                            <div class="bg-green-50 rounded-lg p-2">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-gray-900">
                            @if($employee->last_tap_at)
                                {{ $employee->last_tap_at->diffForHumans() }}
                            @else
                                Belum pernah
                            @endif
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            @if($employee->last_tap_at)
                                {{ $employee->last_tap_at->format('d M Y, H:i') }}
                            @else
                                Silakan tap kartu RFID
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Total Tasks Card -->
                <div class="bg-white rounded-lg shadow border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-medium text-gray-600">Tugas Aktif</h3>
                            <div class="bg-blue-50 rounded-lg p-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-gray-900">{{ $myTasks->count() }}</p>
                        <p class="text-xs text-gray-500 mt-1">Tugas tersedia</p>
                    </div>
                </div>

            </div>

            <!-- My Tasks Section -->
            <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">Tugas Saya</h2>
                    <p class="text-sm text-gray-500 mt-1">Daftar tugas yang dapat Anda kerjakan</p>
                </div>

                <div class="p-6">
                    @forelse ($myTasks as $task)
                        <div
                            class="mb-4 last:mb-0 bg-gray-50 rounded-lg p-5 border border-gray-200 hover:border-blue-300 transition">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $task->task->title }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">{{ $task->task->description }}</p>
                                    <div class="flex items-center mt-3 space-x-4">
                                        <span
                                            class="inline-flex items-center px-2 py-1.5 rounded-md bg-purple-50 text-purple-700 text-sm font-medium border border-purple-100">
                                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z">
                                                </path>
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $task->task->points }} Poin
                                        </span>
                                        @if($task->status == 'assigned')
                                            <span
                                                class="inline-flex items-center px-2 py-1.5 rounded-md bg-yellow-50 border border-yellow-200 text-yellow-700 text-xs font-semibold">
                                                Sedang Dikerjakan
                                            </span>
                                        @elseif($task->status == 'pending_approval')
                                            <span
                                                class="inline-flex items-center px-2 py-1.5 rounded-md bg-blue-50 border border-blue-200 text-blue-700 text-xs font-semibold">
                                                Menunggu Persetujuan
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                @if($task->status == 'assigned')
                                    <form action="{{ route('tasks.submit', $task) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="ml-4 bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded shadow-sm transition">
                                            Selesai ✓
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                </path>
                            </svg>
                            <p class="text-gray-500 font-medium">Tidak ada tugas tersedia saat ini</p>
                            <p class="text-sm text-gray-400 mt-1">Tugas baru akan muncul di sini</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Activity History Section -->
            <div class="bg-white rounded-lg shadow border border-gray-200 mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">Riwayat Aktivitas</h2>
                    <p class="text-sm text-gray-500 mt-1">10 entri terakhir log aktivitas tap RFID Anda</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Waktu</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($recentLogs as $log)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $log->created_at->format('d M Y, H:i:s') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($log->status == 'ALLOW')
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-800 text-xs font-semibold">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                BERHASIL
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-800 text-xs font-semibold">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                DITOLAK
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $log->reason ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center">
                                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        <p class="text-gray-500 font-medium">Belum ada aktivitas</p>
                                        <p class="text-sm text-gray-400 mt-1">Riwayat tap Anda akan muncul di sini</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
</x-employee-layout>