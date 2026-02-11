<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-2">My Pets</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $pets->count() }}</p>
                    <a href="{{ route('pets.index') }}" class="text-sm text-blue-500 hover:underline">View all pets →</a>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-2">My Appointments</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $appointments->count() }}</p>
                    <a href="{{ route('appointments.index') }}" class="text-sm text-green-500 hover:underline">View all appointments →</a>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                <div class="flex gap-4">
                    <a href="{{ route('pets.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Add New Pet
                    </a>
                    <a href="{{ route('appointments.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Book Appointment
                    </a>
                </div>
            </div>

            <!-- Recent Appointments -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Recent Appointments</h3>
                @if($appointments->isEmpty())
                    <p class="text-gray-500">No appointments yet. <a href="{{ route('appointments.create') }}" class="text-blue-500 hover:underline">Book your first appointment</a></p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pet</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reason</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($appointments->take(5) as $appointment)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->pet->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->appointment_date->format('M d, Y h:i A') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($appointment->status === 'confirmed') bg-green-100 text-green-800
                                                @elseif($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($appointment->status === 'completed') bg-blue-100 text-blue-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                {{ ucfirst($appointment->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">{{ Str::limit($appointment->reason, 50) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>