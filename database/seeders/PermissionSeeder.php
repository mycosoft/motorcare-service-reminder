<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Customers
            ['name' => 'view_customers', 'description' => 'View customer list and details', 'group' => 'customers'],
            ['name' => 'create_customers', 'description' => 'Create new customers', 'group' => 'customers'],
            ['name' => 'edit_customers', 'description' => 'Edit customer information', 'group' => 'customers'],
            ['name' => 'delete_customers', 'description' => 'Delete customers', 'group' => 'customers'],
            ['name' => 'import_customers', 'description' => 'Import customers from CSV/Excel', 'group' => 'customers'],

            // Vehicles
            ['name' => 'view_vehicles', 'description' => 'View vehicle list and details', 'group' => 'vehicles'],
            ['name' => 'create_vehicles', 'description' => 'Create new vehicles', 'group' => 'vehicles'],
            ['name' => 'edit_vehicles', 'description' => 'Edit vehicle information', 'group' => 'vehicles'],
            ['name' => 'delete_vehicles', 'description' => 'Delete vehicles', 'group' => 'vehicles'],

            // Services
            ['name' => 'view_services', 'description' => 'View service records', 'group' => 'services'],
            ['name' => 'create_services', 'description' => 'Create new service records', 'group' => 'services'],
            ['name' => 'edit_services', 'description' => 'Edit service records', 'group' => 'services'],
            ['name' => 'delete_services', 'description' => 'Delete service records', 'group' => 'services'],

            // Service Types
            ['name' => 'view_service_types', 'description' => 'View service types', 'group' => 'service_types'],
            ['name' => 'create_service_types', 'description' => 'Create service types', 'group' => 'service_types'],
            ['name' => 'edit_service_types', 'description' => 'Edit service types', 'group' => 'service_types'],
            ['name' => 'delete_service_types', 'description' => 'Delete service types', 'group' => 'service_types'],

            // Service Schedules
            ['name' => 'view_service_schedules', 'description' => 'View service schedules', 'group' => 'service_schedules'],
            ['name' => 'create_service_schedules', 'description' => 'Create service schedules', 'group' => 'service_schedules'],
            ['name' => 'edit_service_schedules', 'description' => 'Edit service schedules', 'group' => 'service_schedules'],
            ['name' => 'delete_service_schedules', 'description' => 'Delete service schedules', 'group' => 'service_schedules'],
            ['name' => 'send_reminders', 'description' => 'Send service reminders', 'group' => 'service_schedules'],

            // Users
            ['name' => 'view_users', 'description' => 'View user list', 'group' => 'users'],
            ['name' => 'create_users', 'description' => 'Create new users', 'group' => 'users'],
            ['name' => 'edit_users', 'description' => 'Edit user information', 'group' => 'users'],
            ['name' => 'delete_users', 'description' => 'Delete users', 'group' => 'users'],

            // Roles & Permissions
            ['name' => 'view_roles', 'description' => 'View roles', 'group' => 'roles'],
            ['name' => 'create_roles', 'description' => 'Create new roles', 'group' => 'roles'],
            ['name' => 'edit_roles', 'description' => 'Edit roles', 'group' => 'roles'],
            ['name' => 'delete_roles', 'description' => 'Delete roles', 'group' => 'roles'],
            ['name' => 'view_permissions', 'description' => 'View permissions', 'group' => 'permissions'],
            ['name' => 'create_permissions', 'description' => 'Create new permissions', 'group' => 'permissions'],
            ['name' => 'edit_permissions', 'description' => 'Edit permissions', 'group' => 'permissions'],
            ['name' => 'delete_permissions', 'description' => 'Delete permissions', 'group' => 'permissions'],

            // Settings
            ['name' => 'view_settings', 'description' => 'View system settings', 'group' => 'settings'],
            ['name' => 'edit_settings', 'description' => 'Modify system settings', 'group' => 'settings'],

            // Reports
            ['name' => 'view_reports', 'description' => 'View reports and statistics', 'group' => 'reports'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission['name']], $permission);
        }

        // Create default Admin role with all permissions
        $adminRole = Role::firstOrCreate(['name' => 'Admin'], ['description' => 'Full system access with all permissions']);
        $adminRole->permissions()->sync(Permission::pluck('id'));

        // Create Staff role with basic permissions
        $staffRole = Role::firstOrCreate(['name' => 'Staff'], ['description' => 'Basic staff access for day-to-day operations']);
        $basicPermissions = Permission::whereIn('group', ['customers', 'vehicles', 'services', 'service_types', 'service_schedules'])->pluck('id');
        $staffRole->permissions()->sync($basicPermissions);
    }
}