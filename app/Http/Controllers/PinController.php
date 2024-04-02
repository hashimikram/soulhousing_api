<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\pin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PinController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'pin' => 'required|digits:6',
            'confirm_pin' => 'required|same:pin',
        ]);
        $user = Auth::user();
        $base = new BaseController();
        if (!Hash::check($request->password, $user->password)) {
            return $base->sendError('The provided password does not match your current password.');
        }
        $pin = pin::firstOrNew(['provider_id' => $user->id]);
        $pin->pin = $request->pin;
        $pin->save();
        return $base->sendResponse(null, 'Pin Set Successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(pin $pin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(pin $pin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, pin $pin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(pin $pin)
    {
        //
    }
}
