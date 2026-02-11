<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Appointment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            $totalUsers = \App\Models\User::where('role', 'user')->count();
            $totalPets = Pet::count();
            $totalAppointments = Appointment::count();
            $pendingAppointments = Appointment::where('status', 'pending')->count();
            
            return view('admin.dashboard', compact('totalUsers', 'totalPets', 'totalAppointments', 'pendingAppointments'));
        }
        
        $pets = Pet::where('user_id', $user->id)->get();
        $appointments = Appointment::where('user_id', $user->id)
            ->orderBy('appointment_date', 'desc')
            ->get();
        
        return view('dashboard', compact('pets', 'appointments'));
    }
}