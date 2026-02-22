<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Task Approvals') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($submissions->isEmpty())
                        <p class="text-gray-500">No pending submissions.</p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Employee</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Task</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Points</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Submitted At</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($submissions as $submission)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $submission->employee->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $submission->task->title }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $submission->task->points }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $submission->created_at->diffForHumans() }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <form action="{{ route('submissions.approve', $submission) }}" method="POST"
                                                class="inline-block">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded mr-2">Setujui</button>
                                            </form>
                                            <form action="{{ route('submissions.reject', $submission) }}" method="POST"
                                                class="inline-block">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">Tolak</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>