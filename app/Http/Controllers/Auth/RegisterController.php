<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Students;
use App\Models\Departments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $departments = Departments::all();
        return view('auth.register', compact('departments'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:students',
            'password' => 'required|string|min:8|confirmed',
            'department_id' => 'required|exists:departments,id',
            'level' => 'required|in:beginner,intermediate,advanced',
            'batch' => 'required|string|max:255',
        ]);

        $student = Students::create([
            'reg_no' => 'STU' . date('Y') . rand(1000, 9999),
            'name' => $request->name,
            'email' => $request->email,
            'department_id' => $request->department_id,
            'password' => Hash::make($request->password),
            'level' => $request->level,
            'batch' => $request->batch,
        ]);

        Auth::guard('student')->login($student);

        return redirect('/dashboard');
    }
}
