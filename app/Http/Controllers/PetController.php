<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function index()
    {
        $pets = Pet::where('user_id', auth()->id())->get();
        return view('pets.index', compact('pets'));
    }

    public function create()
    {
        return view('pets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'species' => 'required|in:dog,cat,bird,rabbit,other',
            'age' => 'required|integer|min:0|max:50',
            'medical_history' => 'nullable|string|max:1000',
        ]);

        $validated['user_id'] = auth()->id();
        Pet::create($validated);

        return redirect()->route('pets.index')->with('success', 'Pet added successfully!');
    }

    public function edit(Pet $pet)
    {
        // Ensure user owns this pet
        if ($pet->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('pets.edit', compact('pet'));
    }

    public function update(Request $request, Pet $pet)
    {
        if ($pet->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'species' => 'required|in:dog,cat,bird,rabbit,other',
            'age' => 'required|integer|min:0|max:50',
            'medical_history' => 'nullable|string|max:1000',
        ]);

        $pet->update($validated);

        return redirect()->route('pets.index')->with('success', 'Pet updated successfully!');
    }

    public function destroy(Pet $pet)
    {
        if ($pet->user_id !== auth()->id()) {
            abort(403);
        }

        $pet->delete();
        return redirect()->route('pets.index')->with('success', 'Pet deleted successfully!');
    }
}