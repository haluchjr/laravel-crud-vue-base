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
use Illuminate\Support\Facades\Cache;
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
        $request->authenticate();
        $user = Auth::user();
        $request->session()->regenerate();

        $rotaPadrao = ($user->nivel == 1) ? 'usuario.index' : 'pedido.index';
        return redirect()
            ->intended(route($rotaPadrao))
            ->with('success', "Olá, {$user->name}");
        
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        if ($request->user()){
            $nivelUsuario = (int) $request->user()->nivel;
            $sessionId = $request->session()->getId();
            $cacheKey = "sistema:menu:sessao:{$sessionId}:nivel:{$nivelUsuario}";
            Cache::forget($cacheKey);
        }



        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        //return redirect('/login');
        // ou
        return redirect()->route('login');
    }
}
