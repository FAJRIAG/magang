<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('System Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        @foreach($configurations as $key => $config)
                            <div class="mb-4">
                                <label for="{{ $key }}"
                                    class="block text-sm font-medium text-gray-700 capitalize">{{ str_replace('_', ' ', $key) }}</label>
                                <input type="text" name="{{ $key }}" id="{{ $key }}" value="{{ $config->value }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 border">
                                @if($config->description)
                                    <p class="text-xs text-gray-500 mt-1">{{ $config->description }}</p>
                                @endif
                            </div>
                        @endforeach

                        <div class="flex items-center justify-end mt-6">
                            <button type="submit"
                                class="bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition">
                                Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>