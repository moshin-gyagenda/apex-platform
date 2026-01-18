<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define permissions for Mubs Script Marking & Tracing System
        $permissions = [
            // Script Management
            'manage-scripts',
            'view-scripts',
            'create-scripts',
            'edit-scripts',
            'delete-scripts',
            
            // Script Marking
            'mark-scripts',
            'view-marked-scripts',
            'edit-marks',
            'approve-marks',
            
            // Script Tracing
            'trace-scripts',
            'view-script-history',
            'track-script-location',
            
            // Marker Management
            'manage-markers',
            'assign-markers',
            'view-marker-performance',
            
            // Reports
            'generate-reports',
            'view-reports',
            'export-reports',
            
            // System Administration
            'manage-users',
            'manage-roles',
            'manage-permissions',
            'view-system-logs',
            'manage-settings',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Define roles for Mubs Script Marking & Tracing System
        $roles = [
            'super-admin',
            'admin',
            'marker',
            'examiner',
            'student',
            'tracer',
            'department-head',
        ];

        // Create roles
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Assign permissions to roles
        
        // Super Admin - All permissions
        Role::findByName('super-admin')->givePermissionTo($permissions);

        // Admin - Most permissions except super admin specific
        Role::findByName('admin')->givePermissionTo([
            'manage-scripts',
            'view-scripts',
            'create-scripts',
            'edit-scripts',
            'view-marked-scripts',
            'trace-scripts',
            'view-script-history',
            'track-script-location',
            'manage-markers',
            'assign-markers',
            'view-marker-performance',
            'generate-reports',
            'view-reports',
            'export-reports',
            'manage-users',
            'view-system-logs',
        ]);

        // Marker - Script marking permissions
        Role::findByName('marker')->givePermissionTo([
            'view-scripts',
            'mark-scripts',
            'view-marked-scripts',
            'edit-marks',
            'trace-scripts',
            'view-script-history',
        ]);

        // Examiner - Script creation and management
        Role::findByName('examiner')->givePermissionTo([
            'manage-scripts',
            'view-scripts',
            'create-scripts',
            'edit-scripts',
            'view-marked-scripts',
            'assign-markers',
            'view-reports',
        ]);

        // Student - Limited view permissions
        Role::findByName('student')->givePermissionTo([
            'view-scripts',
            'trace-scripts',
            'view-script-history',
            'view-reports',
        ]);

        // Tracer - Script tracing permissions
        Role::findByName('tracer')->givePermissionTo([
            'view-scripts',
            'trace-scripts',
            'view-script-history',
            'track-script-location',
            'view-reports',
        ]);

        // Department Head - Department-level permissions
        Role::findByName('department-head')->givePermissionTo([
            'view-scripts',
            'view-marked-scripts',
            'approve-marks',
            'view-marker-performance',
            'generate-reports',
            'view-reports',
            'export-reports',
        ]);
    }
}

