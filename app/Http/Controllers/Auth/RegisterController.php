<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth; // Importa la facciata Auth

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        // Validazione dei dati
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        // Creazione dell'utente
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => false, // Default è false, lo cambiamo solo per l'admin
        ]);

        // Login automatico
        Auth::login($user); // Usando Auth per il login

        return redirect()->route('home');
    }
}
