<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = '/dashboard';

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

    public function login(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'username' => ['required', 'numeric', 'min:6'],
            'password' => ['required', 'string', 'min:8'],
            // 'g-recaptcha-response' => ['required', 'captcha']
        ], [
            'username.required' => 'NIP/NIM wajib diisi!',
            'username.min' => 'NIP/NIM harus terdiri minimal 6 karakter!',
            'username.numeric' => 'NIP/NIM harus angka',
            'password.required' => 'Password wajib diisi!',
            'password.min' => 'Password minimal 8 karakter!',
        ]);

        if ($validator->fails()) {
            $fieldsWithErrorMessagesArray = $validator->messages()->get('*');
            return redirect()->back()->withErrors($fieldsWithErrorMessagesArray)->withInput();
        }


        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'username' : 'username';

        $user = User::where('username', $request->username)->latest()->first();
        if (empty($user)) {
            return redirect()->route('login')
                ->with('error', 'Username atau password salah');
        }
        $status_pass = Hash::check('INPUT PASSWORD', $user->password);
        if (empty(@$user) && $status_pass == false) {
            return redirect()->route('login')
                ->with('error', 'Username atau password salah');
        } else {
            if (auth()->attempt(array($fieldType => $input['username'], 'password' => $input['password']))) {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('login')
                    ->with('error', 'Username atau password salah');
            }
        }
    }
}
