<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $baseController = new BaseController();
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken(config('app.name'))->plainTextToken;
            $success['token'] =  $token;
            $success['user'] =  $user;
            return $baseController->sendResponse($success, 'User login successfully.');
        } else {
            return  $baseController->sendError('Credentials Wrong');
        }
        return $baseController->sendError('Unauthorised.', ['error'=>'Unauthorised']);
    }

    public function forgot_password(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user=User::where('email',$request->email)->first();

        if($user != NULL)
        {
            $status = Password::sendResetLink(
                $request->only('email')
            );

            return $status === Password::RESET_LINK_SENT
                ? response()->json(['message' => 'Password reset link sent to your email'])
                : response()->json(['message' => 'Unable to send reset link'], 422);
        }else{
            return response()->json(['message' => 'We cant find a user with that email address.'], 404);

        }


    }

    public function reset_password(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['message' => 'Password reset successfully'])
            : response()->json(['message' => 'Unable to reset password'], 422);
    }

    public function destroy(Request $request)
    {
        Auth::user()->tokens()->delete();
        $baseController = new BaseController();
        $result = [];
        return $baseController->sendResponse($result,'Logout Successfully');
    }
}
