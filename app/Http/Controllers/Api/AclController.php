<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RoleUser;

class AclController extends Controller
{
    public function index()
    {
        $login_user = auth()->user()->id;
        $role_user = RoleUser::with('role')->where('user_id', $login_user)->first();
        $decodedPermissions = [];

        if ($role_user) {
            $permissionsData = $role_user->role->permissions->first();
            if ($permissionsData && !empty($permissionsData->permissions)) {
                $permissionsArray = json_decode($permissionsData->permissions, true);
                // Convert to associative array with key and value as the same permission name
                foreach ($permissionsArray as $permission) {
                    if (!is_numeric($permission)) {
                        $decodedPermissions[$permission] = $permission;
                    }
                }
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'user_id' => $login_user,
                    'role' => $role_user->role->role_name,
                    'permissions' => $decodedPermissions
                ]
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Role not found',
            ], 404);
        }
    }


}
