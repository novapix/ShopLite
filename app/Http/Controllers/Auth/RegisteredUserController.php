<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Models\Customer;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/register');
    }

    /**
     * Handle an incoming registration request.
     *
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'address' => 'required|string|max:255',
            'dob' => 'required|date',
        ]);
        $customerRole = \App\Models\Roles::where('role', 'customer')->first();


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make(Str::random(16)), // random fake pass
            'role_id' => $customerRole ? $customerRole->id : null,
        ]);

        $customer = Customer::create([
            'name' => $request->name,
            'contact' => $request->contact,
            'email' => $request->email,
            'address' => $request->address,
            'dob' => $request->dob,
            'user_id' => $user->id,
        ]);

        event(new Registered($user));

        // Send password reset email
        Password::sendResetLink(['email' => $user->email]);

        // Do not log in user
        return redirect()->route('login')->with('status', 'Registration successful! Please check your email to set your password.');
    }
}
