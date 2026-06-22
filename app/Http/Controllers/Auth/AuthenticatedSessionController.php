<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. O Laravel tenta autenticar (vê se e-mail e senha dão match)
        $request->authenticate();

        // 2. 💡 Pegamos o usuário que acabou de tentar logar
        $user = Auth::user();

        // 3. 💡 Verificamos se ele está com o status de análise 
        // (Ajuste o nome da coluna/status conforme você criou na sua tabela users)
        if ($user->status === '2') {
            
            // Desloga o usuário na hora para ele não ter acesso a nada
            Auth::guard('web')->logout();
            
            // Invalida a sessão que o 'authenticate' tentou abrir
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Lança uma exceção de validação que o Inertia/Breeze joga direto no campo de erro da tela de login
            throw ValidationException::withMessages([
                'email' => __('Sua conta ainda está em análise pela administração. Por favor, aguarde.'),
            ]);
        }

        // 4. Se ele NÃO estiver em análise, o fluxo padrão do Breeze continua normalmente:
        $request->session()->regenerate();

        /* 

        */
        return redirect()->intended(route('crud.index'))->with('success', "Olá, {$user->name}"); // Sua rota padrão pós-login
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        //return redirect('/login');
        // ou
        return redirect()->route('crud.index');
    }
}
