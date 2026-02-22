<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Device') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('devices.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="device_id" class="block text-sm font-medium text-gray-700">Device ID</label>
                            <input type="text" name="device_id" id="device_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 border">
                            <p class="text-xs text-gray-500 mt-1">Unique identifier for the ESP32 (e.g., VM01).</p>
                        </div>
                        <div class="mb-4">
                            <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                            <input type="text" name="location" id="location" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 border">
                            <p class="text-xs text-gray-500 mt-1">Physical location of the machine (e.g., Lobby,
                                Cafeteria).</p>
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('devices.index') }}"
                                class="text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                            <button type="submit"
                                class="bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition">
                                Register Device
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>