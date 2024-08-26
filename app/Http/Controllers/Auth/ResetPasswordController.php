<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\PasswordReset;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(Request $request)
    {
        $this->validator($request->all())->validate();

        $response = $this->resetPassword(
            $request->only('email', 'password', 'password_confirmation', 'token')
        );

        return $response
            ? redirect($this->redirectPath())->with('status', __($response))
            : back()->withErrors(['email' => [__('Failed to reset password.')]]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);
    }

    protected function resetPassword(array $data)
    {
        $response = Password::reset($data, function ($user, $password) {
            $user->password = Hash::make($password);
            $user->setRememberToken(Str::random(60));
            $user->save();

            event(new PasswordReset($user));
        });

        return $response;
    }

    protected function redirectPath()
    {
        return route('login');
    }
}
