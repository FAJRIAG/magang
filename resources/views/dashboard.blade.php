<x-admin-layout>
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

                <!-- Total Employees Card -->
                <div class="bg-white rounded-lg shadow border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-medium text-gray-600">Total Karyawan</h3>
                            <div class="bg-blue-50 rounded-lg p-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalEmployees }}</p>
                        <p class="text-xs text-gray-500 mt-1">Terdaftar di sistem</p>
                    </div>
                </div>

                <!-- Present Today Card -->
                <div class="bg-white rounded-lg shadow border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-medium text-gray-600">Hadir Hari Ini</h3>
                            <div class="bg-green-50 rounded-lg p-2">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-green-600">{{ $presentToday }}</p>
                        <p class="text-xs text-gray-500 mt-1">
                            @if($totalEmployees > 0)
                                {{ round(($presentToday / $totalEmployees) * 100) }}% tingkat kehadiran
                            @else
                                Belum ada karyawan
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Total Rewards Card -->
                <div class="bg-white rounded-lg shadow border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-medium text-gray-600">Saldo Reward</h3>
                            <div class="bg-purple-50 rounded-lg p-2">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-purple-600">{{ number_format($totalRewards) }}</p>
                        <p class="text-xs text-gray-500 mt-1">Poin tersedia</p>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Section -->
            <div class="bg-white rounded-lg shadow border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">Aktivitas Terkini</h2>
                    <p class="text-sm text-gray-500 mt-1">10 entri terakhir</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Karyawan
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">RFID UID
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Alasan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($recentLogs as $log)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $log->created_at->format('d M H:i:s') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $log->employee ? $log->employee->name : 'Unknown' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <code class="text-xs bg-gray-100 px-2 py-1 rounded text-gray-700 font-mono">
                                                {{ $log->rfid_uid }}
                                            </code>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($log->status == 'ALLOW')
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-800">
                                                IZINKAN
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded bg-red-100 text-red-800">
                                                TOLAK
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $log->reason }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        <p class="text-gray-500 font-medium">Belum ada aktivitas</p>
                                        <p class="text-sm text-gray-400 mt-1">Log aktivitas akan muncul di sini</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>