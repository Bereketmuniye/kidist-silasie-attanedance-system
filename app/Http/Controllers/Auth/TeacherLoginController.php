<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Teacher;

class TeacherLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/teacher/dashboard';

    public function __construct()
    {
        // Middleware will be applied at route level
    }

    public function showLoginForm()
    {
        return view('auth.teacher-login');
    }

    protected function guard()
    {
        return Auth::guard('teacher');
    }

    public function username()
    {
        return 'email';
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string|email',
            'password' => 'required|string',
        ]);
    }

    protected function authenticated(Request $request, $user)
    {
        if (!$user->is_active) {
            Auth::guard('teacher')->logout();
            return redirect()->back()
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors([
                    $this->username() => 'Your account is inactive. Please contact the administrator.',
                ]);
        }

        return redirect()->intended($this->redirectPath());
    }

    public function logout(Request $request)
    {
        $this->guard('teacher')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/teacher/login');
    }
}
