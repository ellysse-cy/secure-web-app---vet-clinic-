<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Appointments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Owner</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pet</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reason</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($appointments as $appointment)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $appointment->pet->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->appointment_date->format('M d, Y h:i A') }}</td>
                                    <td class="px-6 py-4">{{ Str::limit($appointment->reason, 40) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form action="{{ route('admin.appointments.update', $appointment) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" onchange="this.form.submit()"
                                                class="text-xs rounded-full px-2 py-1 border-0 
                                                @if($appointment->status === 'confirmed') bg-green-100 text-green-800
                                                @elseif($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($appointment->status === 'completed') bg-blue-100 text-blue-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                <option value="pending" {{ $appointment->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="confirmed" {{ $appointment->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                <option value="completed" {{ $appointment->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                                <option value="cancelled" {{ $appointment->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button onclick="toggleNotes('{{ $appointment->id }}')" class="text-blue-500 hover:underline text-sm">
                                            {{ $appointment->notes ? 'View Notes' : 'Add Notes' }}
                                        </button>
                                    </td>
                                </tr>
                                <tr id="notes-{{ $appointment->id }}" class="hidden bg-gray-50">
                                    <td colspan="6" class="px-6 py-4">
                                        <form action="{{ route('admin.appointments.update', $appointment) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="{{ $appointment->status }}">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Notes:</label>
                                            <textarea name="notes" rows="3" class="w-full rounded-md border-gray-300">{{ $appointment->notes }}</textarea>
                                            <button type="submit" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded text-sm">
                                                Save Notes
                                            </button>
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

    <script>
        function toggleNotes(id) {
            const notesRow = document.getElementById('notes-' + id);
            notesRow.classList.toggle('hidden');
        }
    </script>
</x-app-layout>