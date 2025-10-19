<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // IF there is no permission
        if (Permission::count() <=0) {
            // Permission list in array
            $permissions = [
                'admin-dash',
                // User permissions
                'user-list', 'user-create', 'user-edit', 'user-delete',
                // Permission permissions
                'permission-list', 'permission-create', 'permission-edit', 'permission-delete',
                // Role permissions
                'role-list', 'role-create', 'role-edit', 'role-delete',
                // Agent permissions
                'agent-list', 'agent-create', 'agent-edit', 'agent-delete',
                // Bank related permissions
                'bank-list', 'bank-create', 'bank-edit', 'bank-delete', 'bank-show',
                // Bank Account permissions
                'bank-account-list', 'bank-account-create', 'bank-account-edit', 'bank-account-delete', 'bank-account-show',
                // Bank Transaction permissions
                'transaction-list', 'transaction-create', 'transaction-edit', 'transaction-delete', 'transaction-show',
                // Donation permissions
                'donation-list', 'donation-create', 'donation-edit', 'donation-delete', 'donation-show',
                // ITC Report permissions
                'itc-report-list', 'itc-report-create', 'itc-report-edit', 'itc-report-delete', 'itc-report-show',
                // Notice permissions
                'notice-list', 'notice-create', 'notice-edit', 'notice-delete', 'notice-show',
                // Gallery permissions
                'gallery-list', 'gallery-create', 'gallery-edit', 'gallery-delete', 'gallery-show',
                // File Data permissions
                'file-data-list', 'file-data-create', 'file-data-edit', 'file-data-delete', 'file-data-show',
                // Custom File permissions
                'custom-file-list', 'custom-file-create', 'custom-file-edit', 'custom-file-delete', 'custom-file-show',
                // IE Data permissions
                'ie-data-list', 'ie-data-create', 'ie-data-edit', 'ie-data-delete', 'ie-data-show',
                // Profile permissions
                'profile-view', 'profile-edit',
                // Dashboard permissions
                'dashboard-view', 'dashboard-manage',
                // Report permissions
                'report-view', 'report-generate', 'report-export',
                // SMS permissions
                'sms-send', 'sms-view', 'sms-manage'
            ];

            // Creating permissions
            foreach ($permissions as $permission) {
                Permission::create(['name' => $permission]);
            }
        }
    }
}
