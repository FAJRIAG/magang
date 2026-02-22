<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Assign Task') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">{{ $task->title }}</h3>
                    <p class="text-gray-600 mb-2">{{ $task->description }}</p>
                    <span
                        class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full font-semibold uppercase tracking-wide mb-6">
                        {{ $task->points }} Points
                    </span>

                    <hr class="mb-6">

                    <form action="{{ route('tasks.assign.store', $task) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="employee_id" class="block text-sm font-medium text-gray-700 mb-2">Select
                                Employee</label>
                            <select name="employee_id" id="employee_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border">
                                <option value="">-- Choose Employee --</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }} (Balance:
                                        {{ $employee->reward_balance }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex gap-3">
                            <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Assign Task
                            </button>
                            <a href="{{ route('tasks.index') }}"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>