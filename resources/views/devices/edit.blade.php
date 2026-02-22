<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Device') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('devices.update', $device->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="device_id" class="block text-sm font-medium text-gray-700">Device ID</label>
                            <input type="text" name="device_id" id="device_id" value="{{ $device->device_id }}" disabled
                                class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm sm:text-sm p-2 border cursor-not-allowed">
                            <p class="text-xs text-gray-500 mt-1">Device ID cannot be changed.</p>
                        </div>

                        <div class="mb-4">
                            <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                            <input type="text" name="location" id="location"
                                value="{{ old('location', $device->location) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 border">
                        </div>

                        <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-md">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="regenerate_secret" name="regenerate_secret" type="checkbox" value="1"
                                        class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="regenerate_secret" class="font-medium text-gray-700">Regenerate Secret
                                        Key</label>
                                    <p class="text-gray-500">Check this box to generate a NEW secret key. You will need
                                        to update the physical device with the new key immediately.</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('devices.index') }}"
                                class="text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                            <button type="submit"
                                class="bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition">
                                Update Device
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>