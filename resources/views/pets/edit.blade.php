<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pet') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('pets.update', $pet) }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Pet Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $pet->name) }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="species" class="block text-sm font-medium text-gray-700">Species</label>
                        <select name="species" id="species" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="dog" {{ old('species', $pet->species) === 'dog' ? 'selected' : '' }}>Dog</option>
                            <option value="cat" {{ old('species', $pet->species) === 'cat' ? 'selected' : '' }}>Cat</option>
                            <option value="bird" {{ old('species', $pet->species) === 'bird' ? 'selected' : '' }}>Bird</option>
                            <option value="rabbit" {{ old('species', $pet->species) === 'rabbit' ? 'selected' : '' }}>Rabbit</option>
                            <option value="other" {{ old('species', $pet->species) === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('species')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="age" class="block text-sm font-medium text-gray-700">Age (years)</label>
                        <input type="number" name="age" id="age" value="{{ old('age', $pet->age) }}" min="0" max="50" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('age')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="medical_history" class="block text-sm font-medium text-gray-700">Medical History</label>
                        <textarea name="medical_history" id="medical_history" rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('medical_history', $pet->medical_history) }}</textarea>
                        @error('medical_history')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Update Pet
                        </button>
                        <a href="{{ route('pets.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>