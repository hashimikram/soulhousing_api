<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Roles
        $admin = Role::create(['name' => 'admin']);
        $editor = Role::create(['name' => 'editor']);
        $author = Role::create(['name' => 'author']);

        // Create Permissions
        $editArticles = Permission::create(['name' => 'edit articles']);
        $deleteArticles = Permission::create(['name' => 'delete articles']);
        $viewArticles = Permission::create(['name' => 'view articles']);

        // Assign Permissions to Roles
        $admin->givePermissionTo($editArticles);
        $admin->givePermissionTo($deleteArticles);
        $admin->givePermissionTo($viewArticles);

        $editor->givePermissionTo($editArticles);
        $editor->givePermissionTo($viewArticles);

        $author->givePermissionTo($viewArticles);
    }
}
