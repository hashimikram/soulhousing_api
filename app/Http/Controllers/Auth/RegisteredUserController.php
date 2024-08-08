<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\User;
use App\Models\userDetail;
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
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $detail = new userDetail();
        $detail->user_id = $user->id;
        $detail->save();

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
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
            $success['token'] = $token;
            $success['user'] = $user;

            //  Getting User Facilities
            $user_Facilities = json_decode($user->details->facilities, true);
            $transformed_Facilities = [];
            if (is_array($user_Facilities)) {
                foreach ($user_Facilities as $facility_id) {
                    $facilities_table = Facility::where('id', $facility_id)->first();
                    if ($facilities_table) {
                        $transformed_Facilities[] = [
                            'id' => $facilities_table->id,
                            'facility_name' => $facilities_table->name
                        ];
                    }
                }
            }
            $success['user_facilities'] = $transformed_Facilities;

            return $baseController->sendResponse($success, 'User login successfully.');

        } else {
            return $baseController->sendError('Credentials Wrong');
        }
        return $baseController->sendError('Unauthorised.', ['error' => 'Unauthorised']);
    }

    public function forgot_password(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user != null) {
            $status = Password::sendResetLink(
                $request->only('email')
            );

            return $status === Password::RESET_LINK_SENT
                ? response()->json(['message' => 'Password reset link sent to your email'])
                : response()->json(['message' => 'Unable to send reset link'], 422);
        } else {
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
        return $baseController->sendResponse($result, 'Logout Successfully');
    }

    public function change_password(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $user = Auth::user();
        $base = new BaseController();
        if (!Hash::check($request->old_password, $user->password)) {
            return $base->sendError('The provided password does not match your current password.');
        }
        $user->password = Hash::make($request->password);
        $user->save();
        Auth::user()->tokens()->delete();
        return $base->sendResponse($user, 'Password Changed Successfully');
    }

    public function login_user_details()
    {
        $user = User::join('user_details', 'user_details.user_id', '=', 'users.id')
            ->select('users.id as userId', 'users.name as provider_name', 'users.email', 'users.email_verified_at',
                'users.user_type', 'users.created_at', 'users.updated_at', 'user_details.*')
            ->where('user_details.user_id', auth()->user()->id)->first();
        $user->image = env('APP_URL').'public/uploads/'.$user->image;
        $user->provider_full_name = $user->title.' '.$user->last_name;
        if ($user != null) {
            return response()->json($user);
        } else {
            return response()->json([
                'code' => false,
                'message' => 'No User Found',
            ], 404);
        }
    }

    public function update_profile(Request $request)
    {

        $user = User::find(auth()->user()->id);
        $user->name = $request->first_name;
        $user->save();
        $userDetail = userDetail::where('user_id', auth()->user()->id)->first();
        $userDetail->title = $request->title;
        $userDetail->middle_name = $request->middle_name;
        $userDetail->last_name = $request->last_name;
        $userDetail->suffix = $request->suffix;
        $userDetail->gender = $request->gender;
        $userDetail->date_of_birth = $request->date_of_birth;
        $userDetail->country = $request->country;
        $userDetail->city = $request->city;
        $userDetail->zip_code = $request->zip_code;
        $userDetail->home_phone = $request->home_phone;
        $userDetail->npi = $request->npi;
        $userDetail->tax_type = $request->tax_type;
        $userDetail->snn = $request->snn;
        $userDetail->ein = $request->ein;
        $userDetail->epcs_status = $request->epcs_status;
        $userDetail->dea_number = $request->dea_number;
        $userDetail->nadean = $request->nadean;
        if ($request->media) {
            $fileData = $request->input('media');
            if (preg_match('/^data:(\w+)\/(\w+);base64,/', $fileData, $type)) {
                $fileData = substr($fileData, strpos($fileData, ',') + 1);
                $fileData = base64_decode($fileData);
                if ($fileData === false) {
                    return response()->json(['error' => 'Base64 decode failed'], 400);
                }
                $mimeType = strtolower($type[1]);
                $extension = strtolower($type[2]);
                $fileName = uniqid().'.'.$extension;
                Log::info('File Mime: '.$mimeType);
                Log::info('File Extension: '.$extension);

                // Ensure the 'public/uploads' directory exists
                $directory = public_path('uploads');
                if (!file_exists($directory)) {
                    mkdir($directory, 0777, true);
                }

                // Save the file to the public/uploads directory
                $filePath = $directory.'/'.$fileName;
                file_put_contents($filePath, $fileData);

                $publicPath = asset('uploads/'.$fileName);
            } else {
                return response()->json(['error' => 'Invalid media data'], 400);
            }
        }
        $userDetail->image = $fileName;
        $userDetail->save();


        return response()->json('Profile Updated');
    }
}
