<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'hash' => 'required|string',
        ]);

        $user = $request->user();

        if (! $user->hasVerifiedEmail()) {
            if ($this->hasValidSignature($request)) {
                $user->markEmailAsVerified();
                event(new \Illuminate\Auth\Events\Verified($user));
            }

            return redirect('/home')->with('verified', true);
        }

        return redirect('/home')->with('verified', false);
    }

    public function resend(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = $request->user();

        $user->sendEmailVerificationNotification();

        return response()->json(['message' => 'Verification link sent!']);
    }

    protected function hasValidSignature(Request $request)
    {
        return URL::hasValidSignature($request);
    }
}
