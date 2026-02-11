<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Pets') }}
            </h2>
            <a href="{{ route('pets.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add New Pet
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if($pets->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-gray-500">You haven't added any pets yet. <a href="{{ route('pets.create') }}" class="text-blue-500 hover:underline">Add your first pet</a></p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($pets as $pet)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                            <h3 class="text-xl font-bold mb-2">{{ $pet->name }}</h3>
                            <div class="space-y-2 text-sm">
                                <p><span class="font-semibold">Species:</span> {{ ucfirst($pet->species) }}</p>
                                <p><span class="font-semibold">Age:</span> {{ $pet->age }} years</p>
                                @if($pet->medical_history)
                                    <p><span class="font-semibold">Medical History:</span> {{ Str::limit($pet->medical_history, 100) }}</p>
                                @endif
                            </div>
                            <div class="mt-4 flex gap-2">
                                <a href="{{ route('pets.edit', $pet) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-sm">
                                    Edit
                                </a>
                                <form action="{{ route('pets.destroy', $pet) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this pet?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>