<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pet;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::where('role', 'user')->with('pets')->get();
        return view('admin.users', compact('users'));
    }

    public function appointments()
    {
        $appointments = Appointment::with(['user', 'pet'])
            ->orderBy('appointment_date', 'desc')
            ->get();
        
        return view('admin.appointments', compact('appointments'));
    }

    public function updateAppointment(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'notes' => 'nullable|string|max:1000',
        ]);

        $appointment->update($validated);

        return back()->with('success', 'Appointment updated successfully!');
    }
}