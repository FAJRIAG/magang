<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Tasks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if($myTasks->isEmpty())
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-gray-500">No tasks assigned yet.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($myTasks as $taskSubmission)
                        <div
                            class="bg-white rounded-lg shadow p-6 {{ $taskSubmission->status === 'pending_approval' ? 'border-2 border-yellow-400' : '' }}">
                            <h4 class="text-xl font-bold text-gray-800">{{ $taskSubmission->task->title }}</h4>
                            <span
                                class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full font-semibold uppercase tracking-wide mt-2">
                                {{ $taskSubmission->task->points }} Points
                            </span>
                            <p class="text-gray-600 mt-2">{{ $taskSubmission->task->description }}</p>

                            <div class="mt-4">
                                @if($taskSubmission->status === 'assigned')
                                    <form action="{{ route('tasks.submit', $taskSubmission) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                            Mark as Done
                                        </button>
                                    </form>
                                @elseif($taskSubmission->status === 'pending_approval')
                                    <div class="text-center">
                                        <span
                                            class="inline-block bg-yellow-100 text-yellow-800 text-sm px-3 py-2 rounded font-semibold">
                                            ⏳ Waiting for Approval
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>