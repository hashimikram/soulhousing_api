<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Staff;
use App\Models\User;
use App\Models\userDetail;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staff = Staff::join('users', 'users.id', '=', 'staff.user_id')->join('roles', 'roles.id', '=',
            'staff.role_id')->join('user_details', 'user_details.user_id', '=',
            'users.id')->select('staff.id as staff_id', 'users.*', 'roles.role_name as role_name',
            'user_details.home_phone')->get();
        return view('backend.pages.Role.staff.index', compact('staff'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('backend.pages.Role.staff.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStaffRequest $request)
    {

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->user_type = 'staff';
        $user->save();

        $user_detail = new UserDetail();
        $user_detail->user_id = $user->id;
        $user_detail->home_phone = $request->phone;
        $user_detail->save();

        $staff = new RoleUser();
        $staff->user_id = $user->id;
        $staff->role_id = $request->role_id;
        $staff->save();

        return redirect()->route('sub-admin.index')->with('success', 'Staff Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staff $staff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStaffRequest $request, Staff $staff)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        //
    }
}
