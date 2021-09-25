<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission_data = [
            ['name' => 'can-add-permission', 'display_name' => 'Can Create Permission', 'url'=> null, 'view_name'=> null, 'group' => 'Permissions',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-delete-permission', 'display_name' => 'Can Delete Permission', 'url'=> null, 'view_name'=> null, 'group' => 'Permissions',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-add-user', 'display_name' => 'Can Create User', 'url'=> null, 'view_name'=> null, 'group' => 'Users',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-edit-user', 'display_name' => 'Can Edit User', 'url'=> null, 'view_name'=> null, 'group' => 'Users',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-delete-user', 'display_name' => 'Can Delete User', 'url'=> null, 'view_name'=> null, 'group' => 'Users',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-edit-permission', 'display_name' => 'Can Edit Permission', 'url'=> null, 'view_name'=> null, 'group' => 'Permissions',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-permission', 'display_name' => 'Can View Permission', 'url'=> '/permissions', 'view_name'=> 'Permissions', 'group' => 'Permissions',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-user', 'display_name' => 'Can View User', 'url'=> '/users', 'view_name'=> 'Users', 'group' => 'Users',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-add-role', 'display_name' => 'Can Create Role', 'url'=> null, 'view_name'=> null, 'group' => 'Roles',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-edit-role', 'display_name' => 'Can Edit Role', 'url'=> null, 'view_name'=> null, 'group' => 'Roles',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-role', 'display_name' => 'Can View Role', 'url'=> '/roles', 'view_name'=> 'Roles', 'group' => 'Roles',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-delete-role', 'display_name' => 'Can Delete Role', 'url'=> null, 'view_name'=> null, 'group' => 'Roles',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-booking', 'display_name' => 'Booking View', 'url'=> '/bookings', 'view_name'=> 'Bookings', 'group' => 'Booking',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-add-booking', 'display_name' => 'Booking Creation', 'url'=> null, 'view_name'=> null, 'group' => 'Booking',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-edit-permissions', 'display_name' => 'Can Edit permissions', 'url'=> null, 'view_name'=> null, 'group' => 'Permissions',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-city', 'display_name' => 'Can View City', 'url'=> null, 'view_name'=> null, 'group' => 'Setup',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-room', 'display_name' => 'Can View Room', 'url'=> null, 'view_name'=> null, 'group' => 'Setup',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-report', 'display_name' => 'View Reports', 'url'=> '/reports', 'view_name'=> 'reports', 'group' => 'Reports',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-complain', 'display_name' => 'Complain View', 'url'=> '/complains', 'view_name'=> 'Complains', 'group' => 'Complain',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-room', 'display_name' => 'Can View Room', 'url'=> '/nrooms', 'view_name'=> 'Rooms', 'group' => 'Rooms',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-edit-room', 'display_name' => 'Can Edit Room', 'url'=> null, 'view_name'=> null, 'group' => 'Rooms',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-add-room', 'display_name' => 'Can Add Room', 'url'=> null, 'view_name'=> null, 'group' => 'Rooms',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-delete-room', 'display_name' => 'Can Delete Room', 'url'=> null, 'view_name'=> null, 'group' => 'Rooms',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-hotel', 'display_name' => 'Can View Hotel', 'url'=> '/hotel', 'view_name'=> 'Hotels', 'group' => 'Hotels',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-add-hotel', 'display_name' => 'Can Add Hotel', 'url'=> null, 'view_name'=> null, 'group' => 'Hotels',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-edit-hotel', 'display_name' => 'Can Edit Hotel', 'url'=> null, 'view_name'=> null, 'group' => 'Hotels',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-delete-hotel', 'display_name' => 'Can Delete Hotel', 'url'=> null, 'view_name'=> null, 'group' => 'Hotels',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-edit-complain', 'display_name' => 'Complain Editing', 'url'=> '/complains', 'view_name'=> 'Complains', 'group' => 'Complain',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-department', 'display_name' => 'View Departments', 'url'=> '/ndepartments', 'view_name'=> 'Departments', 'group' => 'Department',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-edit-department', 'display_name' => 'Edit Department', 'url'=> null, 'view_name'=> null, 'group' => 'Department',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-add-department', 'display_name' => 'Create Department', 'url'=> null, 'view_name'=> null, 'group' => 'Department',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-delete-department', 'display_name' => 'Delete Department', 'url'=> null, 'view_name'=> null, 'group' => 'Department',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-add-company', 'display_name' => 'Create Company', 'url'=> '/companies', 'view_name'=> 'Companies', 'group' => 'Companies',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-edit-company', 'display_name' => 'Edit Company', 'url'=> null, 'view_name'=> null, 'group' => 'Companies',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-company', 'display_name' => 'View Company', 'url'=> null, 'view_name'=> null, 'group' => 'Companies',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-delete-company', 'display_name' => 'Delete Company', 'url'=> null, 'view_name'=> null, 'group' => 'Companies',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-add-facility', 'display_name' => 'Create Facility', 'url'=> '/facilities', 'view_name'=> 'Facilities', 'group' => 'Facilities',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-edit-facility', 'display_name' => 'Edit Facility', 'url'=> null, 'view_name'=> null, 'group' => 'Facilities',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-facility', 'display_name' => 'View Facility', 'url'=> null, 'view_name'=> null, 'group' => 'Facilities',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-delete-facility', 'display_name' => 'Delete Facility', 'url'=> null, 'view_name'=> null, 'group' => 'Facilities',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-add-service', 'display_name' => 'Create Service', 'url'=> '/services', 'view_name'=> 'Services', 'group' => 'Services',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-edit-service', 'display_name' => 'Edit Service', 'url'=> null, 'view_name'=> null, 'group' => 'Services',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-service', 'display_name' => 'View Services', 'url'=> null, 'view_name'=> null, 'group' => 'Services',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-delete-service', 'display_name' => 'Delete Services', 'url'=> null, 'view_name'=> null, 'group' => 'Services',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-add-locale', 'display_name' => 'Create Locales', 'url'=> '/locale', 'view_name'=> 'Locales', 'group' => 'Locales',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-edit-locale', 'display_name' => 'Edit Locale', 'url'=> null, 'view_name'=> null, 'group' => 'Locales',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-locale', 'display_name' => 'View Locales', 'url'=> null, 'view_name'=> null, 'group' => 'Locales',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-delete-locale', 'display_name' => 'Delete Locale', 'url'=> null, 'view_name'=> null, 'group' => 'Locales',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-add-lookup', 'display_name' => 'Create Lookup', 'url'=> '/types', 'view_name'=> 'Lookups', 'group' => 'Lookups',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-edit-lookup', 'display_name' => 'Edit Lookup', 'url'=> null, 'view_name'=> null, 'group' => 'Lookups',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-lookup', 'display_name' => 'View Lookups', 'url'=> null, 'view_name'=> null, 'group' => 'Lookups',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-delete-lookup', 'display_name' => 'Delete Lookup', 'url'=> null, 'view_name'=> null, 'group' => 'Lookups',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-add-promotion', 'display_name' => 'Create Promotion', 'url'=> '/promotions', 'view_name'=> 'Promotions', 'group' => 'Promotions',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-edit-promotion', 'display_name' => 'Edit Promotion', 'url'=> null, 'view_name'=> null, 'group' => 'Promotions',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-promotion', 'display_name' => 'View Promotions', 'url'=> null, 'view_name'=> null, 'group' => 'Promotions',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-delete-promotion', 'display_name' => 'Delete Promotion', 'url'=> null, 'view_name'=> null, 'group' => 'Promotions',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-add-partner', 'display_name' => 'Create Partner', 'url'=> '/partners', 'view_name'=> 'Partners', 'group' => 'Partners',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-edit-partner', 'display_name' => 'Edit Partners', 'url'=> null, 'view_name'=> null, 'group' => 'Partners',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-partner', 'display_name' => 'View Partners', 'url'=> null, 'view_name'=> null, 'group' => 'Partners',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-delete-partner', 'display_name' => 'Delete Partner', 'url'=> null, 'view_name'=> null, 'group' => 'Partners',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-edit-booking', 'display_name' => 'Edit Booking', 'url'=> null, 'view_name'=> null, 'group' => 'Booking',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-cancel-booking', 'display_name' => 'Cancel Booking', 'url'=> null, 'view_name'=> null, 'group' => 'Booking',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-booking', 'display_name' => 'View Booking', 'url'=> '/frontdesk', 'view_name'=> 'Frontdesk', 'group' => 'Frontdesk',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-add-booking', 'display_name' => 'Create Booking', 'url'=> null, 'view_name'=> null, 'group' => 'Frontdesk',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-edit-booking', 'display_name' => 'Edit Booking', 'url'=> null, 'view_name'=> null, 'group' => 'Frontdesk',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-cancel-booking', 'display_name' => 'Cancel Booking', 'url'=> null, 'view_name'=> null, 'group' => 'Frontdesk',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-discount-request', 'display_name' => 'Can View Discount Request', 'url'=> '/discountrequests', 'view_name'=> 'Discount Request', 'group' => 'Discount Request',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-edit-discount-request', 'display_name' => 'Can Approve/Decline Discount', 'url'=> null, 'view_name'=> null, 'group' => 'Discount Request',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-only-view-request', 'display_name' => 'View Discount Requests', 'url'=> null, 'view_name'=> null, 'group' => 'Frontdesk',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-add-inventory', 'display_name' => 'Create Inventory', 'url'=> null, 'view_name'=> null, 'group' => 'Inventories',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-edit-inventory', 'display_name' => 'Edit Inventory', 'url'=> null, 'view_name'=> null, 'group' => 'Inventories',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-inventory', 'display_name' => 'View Inventory', 'url'=> '/inventory', 'view_name'=> 'Inventories', 'group' => 'Inventories',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-delete-inventory', 'display_name' => 'Delete Inventory', 'url'=> null, 'view_name'=> null, 'group' => 'Inventories',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-create-purchase-order', 'display_name' => 'Create Purchase Order', 'url'=> null, 'view_name'=> null, 'group' => 'Purchase Order',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-edit-purchase-order', 'display_name' => 'Edit Purchase Order', 'url'=> null, 'view_name'=> null, 'group' => 'Purchase Order',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-purchase-order', 'display_name' => 'View Purchase Order', 'url'=> '/purchase_orders', 'view_name'=> 'Purchase Order', 'group' => 'Purchase Order',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-add-vendor', 'display_name' => 'Create Vendor', 'url'=> '/vendors', 'view_name'=> 'Vendors', 'group' => 'Vendors',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-edit-vendor', 'display_name' => 'Edit Vendor', 'url'=> null, 'view_name'=> null, 'group' => 'Vendors',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-vendor', 'display_name' => 'View Vendor', 'url'=> null, 'view_name'=> null, 'group' => 'Vendors',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-add-goods_receive_note', 'display_name' => 'Create Goods Receive', 'url'=> '/goods_receive_notes', 'view_name'=> 'Goods Receive Notes', 'group' => 'Goods Receive Notes',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-edit-goods_receive_note', 'display_name' => 'Edit Goods Receive', 'url'=> null, 'view_name'=> null, 'group' => 'Goods Receive Notes',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-goods_receive_note', 'display_name' => 'View Goods Receive', 'url'=> null, 'view_name'=> null, 'group' => 'Goods Receive Notes',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-add-corporate-client', 'display_name' => 'Create Corporate Client', 'url'=> '/corporate_clients', 'view_name'=> 'Corporate Clients', 'group' => 'Corporate Clients',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-edit-corporate-client', 'display_name' => 'Edit Corporate', 'url'=> null, 'view_name'=> null, 'group' => 'Corporate Clients',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-corporate-client', 'display_name' => 'View Corporate Clients', 'url'=> null, 'view_name'=> null, 'group' => 'Corporate Clients',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-delete-corporate-client', 'display_name' => 'Corporate Clients', 'url'=> null, 'view_name'=> null, 'group' => 'Corporate Clients',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-room-dashboard', 'display_name' => 'Can View Room Dashboard', 'url'=> '/room_dashboard', 'view_name'=> 'Room Dashboard', 'group' => 'Room Dashboard',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-accounts', 'display_name' => 'Can View Accounts', 'url'=> '/account_lookups', 'view_name'=> 'Accounts', 'group' => 'Accounts',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-add-accounts', 'display_name' => 'Can Add Accounts', 'url'=> '/account_lookups', 'view_name'=> 'Accounts', 'group' => 'Accounts',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-delete-accounts', 'display_name' => 'Can Delete Accounts', 'url'=> '/account_lookups', 'view_name'=> 'Accounts', 'group' => 'Accounts',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-task', 'display_name' => 'Can View Task', 'url'=> '/tasks', 'view_name'=> 'Tasks', 'group' => 'Tasks',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-edit-task', 'display_name' => 'Can Edit Task', 'url'=> null, 'view_name'=> null, 'group' => 'Tasks',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-booking-calendar', 'display_name' => 'Can View Booking Calendar', 'url'=> '/bookings_calendar', 'view_name'=> null, 'group' => 'Bookings Calendar',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-auto-posting', 'display_name' => 'Can View Auto Posting', 'url'=> '/auto_postings', 'view_name'=> 'Auto Posting', 'group' => 'Accounts',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-add-auto-posting', 'display_name' => 'Can Add Auto Posting', 'url'=> null, 'view_name'=> null, 'group' => 'Accounts',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-edit-auto-posting', 'display_name' => 'Can Edit Auto Posting', 'url'=> null, 'view_name'=> null, 'group' => 'Accounts',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-leaves-calendar', 'display_name' => 'Can View Leaves Calendar', 'url'=> '/all_leaves', 'view_name'=> 'Leaves Calendar', 'group' => 'Leaves Calendar',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-trial-balance-sheet', 'display_name' => 'Can View Trial Balance Sheet', 'url'=> '/trialbalancesheet', 'view_name'=> 'Trial Balance Sheet', 'group' => 'Trial Balance Sheet',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-general-ledger', 'display_name' => 'Can View General Ledger', 'url'=> '/ledger', 'view_name'=> 'General Ledger', 'group' => 'General Ledger',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-income-statement', 'display_name' => 'Can View Income Statement', 'url'=> '/income_statement', 'view_name'=> 'Income Statement', 'group' => 'Income Statement',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-balance-sheet', 'display_name' => 'Can View Balance Sheet', 'url'=> '/balance_sheet', 'view_name'=> 'Balance Sheet', 'group' => 'Balance Sheet',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-hotel-dashboard', 'display_name' => 'Can View Hotel Dashboard', 'url'=> '/hotel_dashboard', 'view_name'=> 'Hotel Dashboard', 'group' => 'Hotel Dashboard',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-view-customers', 'display_name' => 'Can View Customers', 'url'=> '/customers', 'view_name'=> 'Customers', 'group' => 'Customers',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-add-customers', 'display_name' => 'Can Add Customers', 'url'=> '', 'view_name'=> 'Customers', 'group' => 'Customers',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-edit-customers', 'display_name' => 'Can Edit Customers', 'url'=> '', 'view_name'=> 'Customers', 'group' => 'Customers',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder'],
            ['name' => 'can-delete-customers', 'display_name' => 'Can Delete Customers', 'url'=> '', 'view_name'=> 'Customers', 'group' => 'Customers',  'is_active' => '1', 'created_by' => '1', 'updated_by' => '1', 'created_by_module' => 'Permission Seeder']
        ];

        foreach ($permission_data as $data) {
            // Permission::create($data);
            $permission = new Permission();

            $permission->fill($data);
            
            $permission->save($data);
        }
    }
}
