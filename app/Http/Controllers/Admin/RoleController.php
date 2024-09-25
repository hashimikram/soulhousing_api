<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PermissionController;
use App\Models\Permission;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('backend.pages.Role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.Role.create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $role = Role::with('permissions')->where('id', $id)->first();

        // First decode to get the array if not already an array
        $permissionsArray = json_decode($role->permissions, true);

        // Check if the decoded data contains the permissions
        if (isset($permissionsArray[0]['permissions'])) {
            // The permissions are already in array format
            $permissions = json_decode($permissionsArray[0]['permissions'], true);
        } else {
            $permissions = [];
        }

        return view('backend.pages.Role.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $role = Role::FindOrFail($id);
        if ($role) {
            try {
                $role->role_name = $request->role_name;
                $role->save();
                $permissions = Permission::where('role_id', $id)->first();
                $permissions->permissions = json_encode($request->permissions);
                $permissions->save();
                return redirect()->route('roles.index')->with('success', 'Role Updated Successfully');
            } catch (Exception $e) {
                return redirect()->back()->with('error', 'Something Went Wrong');
            }
        } else {
            return redirect()->back()->with('error', 'Data Not Found');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required',
        ]);
        $role = new Role();
        $role->role_name = $request->role_name;
        $role->save();
        $permissionController = new PermissionController();
        $newRequest = new Request([
            'role_id' => $role->id,
            'permissions' => $request->permissions,
        ]);
        return $permissionController->store($newRequest);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //
    }
}
