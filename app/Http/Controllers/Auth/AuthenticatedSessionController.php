<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login', [
            'pageTitle' => 'Login - Penjadwalan',
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $user = User::where('email', $request->email)->first();
        
        if ($user) {
            if (!in_array($user->status, ['Disetujui'])) {
                if ($user->status === 'Menunggu') {
                    return redirect()->route('login')->withErrors([
                        'email' => 'Your account is still pending approval.',
                    ]);
                }
                
                if ($user->status === 'Ditolak') {
                    return redirect()->route('login')->withErrors([
                        'email' => 'Your account has been declined.',
                    ]);
                }
            }
        }
        
        $request->authenticate();
        $request->session()->regenerate();

        // Arahkan berdasarkan role
        if (auth()->user()->role === 'Admin') {
            return redirect()->route('admin.jadwals');
        }
    
        return redirect()->route('user.jadwals');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
