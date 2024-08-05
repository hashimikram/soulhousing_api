<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\patient;
use App\Models\RoleUser;
use App\Models\User;
use App\Models\userDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['userDetail'])->whereNot('user_type',
            'super_admin')->orderBy('created_at', 'DESC')->get();
        return view('backend.pages.UserManagement.users.index')->with(compact('users'));
    }

    public function create()
    {
        return view('admin.pages.User.create');
    }

    public function store(UserStoreRequest $request)
    {
        Unauthorized();
        try {
            DB::beginTransaction();

            // Create and save user
            $user = new User();
            $user->name = $request->first_name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->user_type = $request->user_type;
            $user->save();

            // Create and save user detail
            $userDetail = new UserDetail();
            $userDetail->user_id = $user->id;
            $userDetail->title = $request->title;
            $userDetail->middle_name = $request->middle_name;
            $userDetail->last_name = $request->last_name;
            $userDetail->gender = $request->gender;
            $userDetail->city = $request->city;
            $userDetail->country = $request->country;
            $userDetail->date_of_birth = $request->date_of_birth;
            $userDetail->facilities = $request->facilities;
            $userDetail->speciality_id = $request->speciality_id;

            if ($request->file('image')) {
                $originalName = $request->file('image')->getClientOriginalName();
                $imagePath = pathinfo($originalName,
                        PATHINFO_FILENAME).'_'.time().'.'.$request->file('image')->getClientOriginalExtension();
                $destinationPath = public_path('uploads');
                $request->file('image')->move($destinationPath, $imagePath);
                $userDetail->image = $imagePath;
            } else {
                $userDetail->image = 'placeholder.jpg';
            }

            $userDetail->save();

            // Assign role to user
            if ($request->role_id != null) {
                $role_user = new RoleUser();
                $role_user->role_id = $request->role_id;
                $role_user->user_id = $user->id;
                $role_user->save();
            }

            DB::commit();
            return redirect()->route('user.index')->with('success', 'User Added Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function show($id)
    {
        $user = User::where('id', $id)
            ->with(['userDetail', 'roles.permissions'])
            ->orderBy('created_at', 'DESC')
            ->first();

        if (!isset($user)) {
            return redirect()->route('user.index')->with('error', 'User Not Found');
        }
        $nameParts = explode(' ', $user->name);
        $user->first_name = $nameParts[0];
        $user->last_name = isset($nameParts[1]) ? $nameParts[1] : '';
        $total_patients = patient::where('provider_id', $id)->count();
        return view('backend.pages.UserManagement.users.user_detail')->with(compact('user', 'total_patients'));
    }

    public function edit($id)
    {
        $user = User::where('id', $id)->with('userDetail')->orderBy('created_at',
            'DESC')->first();
        if (!isset($user)) {
            return redirect()->route('user.index')->with('error', 'User Not Found');
        }
        $nameParts = explode(' ', $user->name);
        $user->first_name = $nameParts[0];
        $user->last_name = isset($nameParts[1]) ? $nameParts[1] : '';
        return view('backend.pages.UserManagement.users.edit')->with(compact('user'));
    }

    public function update(UserUpdateRequest $request, $id)
    {
        Unauthorized();
        try {
            DB::beginTransaction();
            $user = User::find($id);
            if (!isset($user)) {
                return redirect()->route('user.index')->with('error', 'User Not Found');
            }
            $user->name = $request->first_name;
            $user->save();
            $userDetail = userDetail::where('user_id', $id)->first();
            if (!isset($userDetail)) {
                return redirect()->route('user.index')->with('error', 'User Not Found');
            }
            $userDetail->title = $request->title;
            $userDetail->middle_name = $request->middle_name;
            $userDetail->last_name = $request->last_name;
            $userDetail->gender = $request->gender;
            $userDetail->city = $request->city;
            $userDetail->country = $request->country;
            $userDetail->date_of_birth = $request->date_of_birth;
            $userDetail->home_phone = $request->home_phone;

            if ($request->file('image')) {
                if ($userDetail->image != 'placeholder.jpg') {
                    // Delete the old image if it exists
                    if ($userDetail->image && file_exists(public_path('uploads/'.$userDetail->image))) {
                        unlink(public_path('uploads/'.$allergy->banner_image));
                    }
                }
                $originalName = $request->file('image')->getClientOriginalName();
                $imagePath = pathinfo($originalName,
                        PATHINFO_FILENAME).'_'.time().'.'.$request->file('image')->getClientOriginalExtension();
                $destinationPath = public_path('uploads');
                $request->file('image')->move($destinationPath, $imagePath);
                $userDetail->image = $imagePath;
            }
            $userDetail->save();
            DB::commit();
            return redirect()->route('user.index')->with('success', 'Details Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = User::FindOrFail($id);
        if (!isset($user)) {
            return redirect()->route('user.index')->with('error', 'User Not Found');
        }
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User Deleted Successfully');
    }
}
