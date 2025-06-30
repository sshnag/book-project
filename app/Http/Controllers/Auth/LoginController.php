<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash as HashFacade;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::where('email', $request->email)->first();

        if (! $user || ! HashFacade::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'Invalid credentials',
            ])->withInput();
        }

        Auth::login($user, $request->filled('remember'));

        $request->session()->regenerate();

        return $this->redirectBasedOnRole($user);
    }

    protected function redirectBasedOnRole(User $user)
    {
        if ($user->hasRole('superadmin|bookadmin')) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended(route('user.home'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
