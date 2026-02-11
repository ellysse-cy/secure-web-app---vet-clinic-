<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Pet;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::where('user_id', auth()->id())
            ->with('pet')
            ->orderBy('appointment_date', 'desc')
            ->get();
        
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $pets = Pet::where('user_id', auth()->id())->get();
        
        if ($pets->isEmpty()) {
            return redirect()->route('pets.create')
                ->with('error', 'Please add a pet before booking an appointment.');
        }
        
        return view('appointments.create', compact('pets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'appointment_date' => 'required|date|after:now',
            'reason' => 'required|string|max:500',
        ]);

        // Verify pet belongs to user
        $pet = Pet::findOrFail($validated['pet_id']);
        if ($pet->user_id !== auth()->id()) {
            abort(403);
        }

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';
        
        Appointment::create($validated);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment booked successfully!');
    }

    public function destroy(Appointment $appointment)
    {
        if ($appointment->user_id !== auth()->id()) {
            abort(403);
        }

        $appointment->delete();
        return redirect()->route('appointments.index')
            ->with('success', 'Appointment cancelled successfully!');
    }
}