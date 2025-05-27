<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'username' => [trans('auth.failed')],
        ]);
    }

    public function username()
    {
        $login = request()->input('username');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$field => $login]);
        return $field;
    }

    public function authenticated(Request $request, $user)
    {
        if ($user->role == 'Owner' || $user->role == 'Op-Gudang') {
            $user->last_login_at = now();
            $user->save();
            Session::flash('confeti', true);
            return redirect()->intended($this->redirectTo)->with('success', 'Login Berhasil');
        } else {
            Auth::logout();
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk login ke sistem ini');
        }
    }

    protected function loggedOut(Request $request)
    {
        Alert::success('Logout Berhasil', 'Terimkasih, Sampai jumpa kembali!');
        return redirect('/login');
    }
}
