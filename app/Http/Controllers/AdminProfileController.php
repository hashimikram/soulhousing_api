<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminProfileController extends Controller
{
    public function index()
    {
        return view('admin.profile.editProfile');
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Check if the provided current password matches the stored password
        if (!Hash::check($request->current_password, $user->password)) {
            // Log the failed attempt
            Log::warning('Password change attempt failed for user ID: '.$user->id);

            return redirect()->route('admin.index')->with('error', 'The provided password does not match our records.');
        }

        // Update the user's password
        $user->password = Hash::make($request->password);
        $user->save();

        // Invalidate all other sessions to enhance security
        Auth::logoutOtherDevices($request->password);

        // Log the successful password change
        Log::info('Password changed successfully for user ID: '.$user->id);

        return redirect()->route('admin.index')->with('success', 'Password successfully changed!');
    }
}
