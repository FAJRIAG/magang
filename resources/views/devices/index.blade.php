<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Perangkat
            </h2>
            <a href="{{ route('devices.create') }}"
                class="bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition">
                Tambah Perangkat Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Device ID</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Location</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Secret Key</th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($devices as $device)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $device->device_id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $device->location }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono break-all max-w-xs truncate"
                                        title="{{ $device->secret_key }}">
                                        {{ substr($device->secret_key, 0, 10) }}...{{ substr($device->secret_key, -10) }}
                                        <button
                                            onclick="navigator.clipboard.writeText('{{ $device->secret_key }}'); alert('Secret copied to clipboard!');"
                                            class="ml-2 text-blue-600 hover:text-blue-900 text-xs uppercase font-bold">
                                            Copy
                                        </button>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('devices.edit', $device->id) }}"
                                            class="text-indigo-600 hover:text-indigo-900 mr-4">Ubah</a>
                                        <form action="{{ route('devices.destroy', $device->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>