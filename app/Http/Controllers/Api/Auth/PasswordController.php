<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LinkEmailRequest;
use App\Http\Requests\Api\ResetPasswordRequest;
use App\Mail\ResetPasswordLink;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class PasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendResetLinkEmail(LinkEmailRequest $request)
    {
        $url = URL::temporarySignedRoute('password.reset.get', now()
            ->addMinute(30), ['email' => $request->email]);

        Mail::to($request->email)
            ->send(new ResetPasswordLink($url));

        return response()->json([
            'status' => true,
            'data' => $request->email,
            'message' => 'Reset password link sent on your email'
        ], 200);
    }

    public function getResetLink(Request $request)
    {
        return response()->json([
            'status' => true,
            'data' => $request->fullUrl(),
            'message' => 'Copy the URL and run it with POST method. Refer to the Postman Auth/Reset Password documentation.'
        ], 200);
    }

    public function reset(ResetPasswordRequest $request)
    {
        $user = User::whereEmail($request->email)->firstOrFail();
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'status' => true,
            'data' => $user,
            'message' => 'Password reset success'
        ], 200);
    }
}
