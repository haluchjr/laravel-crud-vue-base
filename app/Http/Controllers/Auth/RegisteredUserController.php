<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuarios;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use App\Mail\CadastroEmail;
use Illuminate\Support\Facades\Mail;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:tb_usuarios,email'],
            'password'  => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = Usuarios::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'status'    => 1, // 1=Ativo / 0=Inativo / 2=Analise
            'nivel'     => 1, // Cliente (automaticamente todo cadastro é cliente ) // tb_acl define qual nivel dele.
        ]);
        
        //Mail::to('seu-email@teste.com')->send(new CadastroEmail($request->name));
        //event(new Registered($user));


        Auth::login($user);
        return redirect()->route('crud.index')->with('success', 'Registrado.'); 
    }
}
