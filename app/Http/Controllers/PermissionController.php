<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\AddPermissionRequest;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('permission.index');
    }
    public function created(AddPermissionRequest $request)
    {
        $l = Permission::orderBy('id', 'desc')->first(['id']);

        if ($request->validated()) {
            $postData = $request->all();
            if (array_key_exists('id', $postData)) {
                // Edit
                $permission = Permission::find($postData['id']);
                $permission->update($postData);
            } else {
                if (!empty($l)) {
                    $postData['id'] = $l->id + 1;
                } else {
                    $postData['id'] = 1;
                }
                
                $permission = Permission::create($postData);
            }
        }

        $response = [
            'success' => true,
            'message' => ['Permission data added successfully!'],
            'msgtype' => 'success'
        ];

        echo json_encode($response);
    }

    public function create(AddPermissionRequest $request, Permission $permission)
    {

        if ($request->validated()) {
            $postData = $request->all();
            $permission->save($postData);
        }

        $response = [
            'success' => true,
            'message' => ['Permission data added successfully!'],
            'msgtype' => 'success'
        ];

        echo json_encode($response);
    }

    public function get(Request $request)
    {
        // umer
        // $user = Auth::user();
        // if ($user->type == "superadmin")
        //     $permissions = Permission::where('name', '<>', 'superadmin')->get();
        // else
        //     $permissions = Permission::where('is_active', 1)->get();
        $permissions = Permission::where('is_active', 1)->get();
        echo json_encode(['success' => true, 'payload' => $permissions], JSON_NUMERIC_CHECK);
    }

    public function getall(Request $request)
    {

        $permissions = Permission::where('name', '<>', 'superadmin')->get();
        echo json_encode(['success' => true, 'payload' => $permissions], JSON_NUMERIC_CHECK);
    }
    public function delete(Request $request)
    {

        $request = $request->all();
        $permission = Permission::findOrFail($request['id']);
        $permission->delete();
        $response = [
            'success' => true,
            'message' => ['Permission removed successfully!'],
            'msgtype' => 'danger'
        ];
        echo json_encode($response);
    }

    public function generate()
    {

        // $insert = [
        //     ['url'=> 'dashboard/operational_performance', 'view_name' => 'Operational_performance','is_active' => 1, 'group' => 'Operational_performance', 'name' => 'can-view-operational_performance', 'display_name' => 'Can View Operational_performance'],
        //     ['url'=> 'dashboard/member', 'view_name' => 'Member_dashboard','is_active' => 1, 'group' => 'Member_dashboard', 'name' => 'can-view-member_dashboard', 'display_name' => 'Can View Member_dashboard'],
        //     ['url'=> 'dashboard/campaigns', 'view_name' => 'Campaigns_dashboard','is_active' => 1, 'group' => 'Campaigns_dashboard', 'name' => 'can-view-campaigns_dashboard', 'display_name' => 'Can View Campaigns_dashboard'],
        //     ['url'=> 'dashboard/volunteers', 'view_name' => 'Volunteers_dashboard','is_active' => 1, 'group' => 'Volunteers_dashboard', 'name' => 'can-view-volunteers_dashboard', 'display_name' => 'Can View Volunteers_dashboard'],
        //     ['url'=> 'dashboard/tours', 'view_name' => 'Tours_dashboard','is_active' => 1, 'group' => 'Tours_dashboard', 'name' => 'can-view-tours_dashboard', 'display_name' => 'Can View Tours_dashboard'],
        //     ['url'=> 'dashboard/admin', 'view_name' => 'Admin','is_active' => 1, 'group' => 'Admin', 'name' => 'can-view-admin_dashboard', 'display_name' => 'Can View Admin Dashboard'],
        //     ['url'=> 'admin/default', 'view_name' => 'Default','is_active' => 1, 'group' => 'Default', 'name' => 'can-view-default', 'display_name' => 'Can View Default'],
        //     ['url'=> 'admin/slots', 'view_name' => 'Slot','is_active' => 1, 'group' => 'Slot', 'name' => 'can-view-slot', 'display_name' => 'Can View Slot'],
        //     ['url'=> 'admin/roles', 'view_name' => 'Role','is_active' => 1, 'group' => 'Role', 'name' => 'can-view-role', 'display_name' => 'Can View Role'],
        //     ['url'=> 'admin/staff', 'view_name' => 'Staff','is_active' => 1, 'group' => 'Staff', 'name' => 'can-view-staff', 'display_name' => 'Can View Staff'],
        //     ['url'=> 'admin/activity', 'view_name' => 'Activity','is_active' => 1, 'group' => 'Activity', 'name' => 'can-view-activity', 'display_name' => 'Can View Activity'],
        //     ['url'=> 'admin/annual_calendar', 'view_name' => 'Annual','is_active' => 1, 'group' => 'Annual Calendar', 'name' => 'can-view-annualcalendar', 'display_name' => 'Can View Annual Calendar'],
        //     ['url'=> 'patron-levels', 'view_name' => 'Membership_level','is_active' => 1, 'group' => 'Membership_level', 'name' => 'can-view-membership_level', 'display_name' => 'Can View Membership_level'],
        //     ['url'=> 'admin/templates', 'view_name' => 'Email_templates','is_active' => 1, 'group' => 'Email_templates', 'name' => 'can-view-email_templates', 'display_name' => 'Can View Email_templates'],
        //     ['url'=> 'admin/settings', 'view_name' => 'Super','is_active' => 1, 'group' => 'Super Admin', 'name' => 'superadmin', 'display_name' => 'Super Admin'],
        //     ['url'=> 'incomingcall', 'view_name' => 'Incoming_call','is_active' => 1, 'group' => 'Incoming_call', 'name' => 'can-view-incomingcall', 'display_name' => 'Can View Incoming Call'],
        //     ['url'=> 'member/management?type=member', 'view_name' => 'Member','is_active' => 1, 'group' => 'Member', 'name' => 'can-view-membermanagement', 'display_name' => 'Can View Member Management'],
        //     ['url'=> 'donor/management?type=donor', 'view_name' => 'Donor','is_active' => 1, 'group' => 'Donor', 'name' => 'can-view-donormanagement', 'display_name' => 'Can View Donor Management'],
        //     ['url'=> 'tour', 'view_name' => 'Tour','is_active' => 1, 'group' => 'Tour', 'name' => 'can-view-tour', 'display_name' => 'Can View Tour'],
        //     ['url'=> 'admin/volunteers', 'view_name' => 'Volunteer','is_active' => 1, 'group' => 'Volunteer', 'name' => 'can-view-volunteer', 'display_name' => 'Can View Volunteer'],
        //     ['url'=> 'admin/campaigns', 'view_name' => 'Campaign','is_active' => 1, 'group' => 'Campaign', 'name' => 'can-view-campaign', 'display_name' => 'Can View Campaign'],
        //     ['url'=> 'donations', 'view_name' => 'Donation','is_active' => 1, 'group' => 'Donation', 'name' => 'can-view-donation', 'display_name' => 'Can View Donation'],
        //     ['url'=> 'reports', 'view_name' => 'Report','is_active' => 1, 'group' => 'Report', 'name' => 'can-view-report', 'display_name' => 'Can View Report'],
        //     // ******views end********

        //     ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Slot', 'name' => 'can-add-slot', 'display_name' => 'Can Add Slot'],
        //     ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Slot', 'name' => 'can-delete-slot', 'display_name' => 'Can Delete Slot'],
        //     ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Member', 'name' => 'can-view-member', 'display_name' => 'Can View Member'],
        //     ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Default', 'name' => 'can-add-default', 'display_name' => 'Can Add Default'],
        //     ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Role', 'name' => 'can-add-role', 'display_name' => 'Can Add Role'],
        //     ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Role', 'name' => 'can-delete-role', 'display_name' => 'Can Delete Role'],
        //     ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Tour', 'name' => 'can-add-tour', 'display_name' => 'Can Add Tour'],
            
        //     ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Tour', 'name' => 'can-delete-tour', 'display_name' => 'Can Delete Tour'],
        //     ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Member', 'name' => 'can-add-member', 'display_name' => 'Can Add Member'],
        //     ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Member', 'name' => 'can-delete-member', 'display_name' => 'Can Delete Member'],
        //     ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Membership_level', 'name' => 'can-add-membership_level', 'display_name' => 'Can Add Membership_level'],
        //     ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Membership_level', 'name' => 'can-delete-membership_level', 'display_name' => 'Can Delete Membership_level'],
            
        //     ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Volunteer', 'name' => 'can-add-volunteer', 'display_name' => 'Can Add Volunteer'],
        //     ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Volunteer_availability', 'name' => 'can-add-volunteer_availability', 'display_name' => 'Can Add Volunteer_availability'],
        //     ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Volunteer', 'name' => 'can-delete-volunteer', 'display_name' => 'Can Delete Volunteer'],
        //     ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Volunteer_availability', 'name' => 'can-delete-volunteer_availability', 'display_name' => 'Can Delete Volunteer_availability'],
        //     // ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Volunteer_schedule', 'name' => 'can-add-volunteer_schedule', 'display_name' => 'Can Add Volunteer_schedule'],
            
        //     ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Email_template', 'name' => 'can-add-email_template', 'display_name' => 'Can Add Email_template'],
            
        //     ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Criteria', 'name' => 'can-view-criteria', 'display_name' => 'Can View Criteria'],
        //     ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Campaign', 'name' => 'can-add-campaign', 'display_name' => 'Can Add Campaign'],
        //     ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Campaign_response', 'name' => 'can-add-campaign_response', 'display_name' => 'Can Add Campaign_response'],
        //     ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Email_template', 'name' => 'can-delete-email_template', 'display_name' => 'Can Delete Email_template'],            
        //     ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Campaign', 'name' => 'can-delete-campaign', 'display_name' => 'Can Delete Campaign'],
        //     ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Donation', 'name' => 'can-add-donation', 'display_name' => 'Can Add Donation'],
            
        //     ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Report_config', 'name' => 'can-add-report_config', 'display_name' => 'Can Add Report_config'],
        //     ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Staff', 'name' => 'can-add-staff', 'display_name' => 'Can Add Staff'],
        //     ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Staff', 'name' => 'can-delete-staff', 'display_name' => 'Can Delete Staff'],
        //     ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Incoming_call', 'name' => 'can-add-incomingcall-user', 'display_name' => 'Can Add Incoming Call User'],
        //     ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Incoming_call', 'name' => 'can-delete-incomingcall-user', 'display_name' => 'Can Delete Incoming Call User'],
        //     ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Member', 'name' => 'can-add-membermanagement', 'display_name' => 'Can Add Member Management'],
        //     ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Member', 'name' => 'can-delete-membermanagement', 'display_name' => 'Can Delete Member Management'],
        //     ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Donor', 'name' => 'can-add-donormanagement', 'display_name' => 'Can Add Donor Management'],
        //     ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Donor', 'name' => 'can-delete-donormanagement', 'display_name' => 'Can Delete Donor Management'],
            
        //     ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Annual Calendar', 'name' => 'can-add-annualcalendar', 'display_name' => 'Can Add Annual Calendar'],
        //     ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Annual Calendar', 'name' => 'can-delete-annualcalendar', 'display_name' => 'Can Delete Annual Calendar'],
        // ];

        $insert = [
            ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Users', 'name' => 'can-view-user', 'display_name' => 'Can View User'],
            ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Users', 'name' => 'can-delete-user', 'display_name' => 'Can Delete User'],
            ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Users', 'name' => 'can-edit-user', 'display_name' => 'Can Edit User'],
            ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Users', 'name' => 'can-add-user', 'display_name' => 'Can Create User'],
            ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Permissions', 'name' => 'can-view-permission', 'display_name' => 'Can View Permission'],
            ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Permissions', 'name' => 'can-edit-permission', 'display_name' => 'Can Edit Permission'],
            ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Permissions', 'name' => 'can-delete-permission', 'display_name' => 'Can Delete Permission'],
            ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Permissions', 'name' => 'can-add-permission', 'display_name' => 'Can Create Permission'],
            ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Roles', 'name' => 'can-add-role', 'display_name' => 'Can Create Role'],
            ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Roles', 'name' => 'can-edit-role', 'display_name' => 'Can Edit Role'],
            ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Roles', 'name' => 'can-view-role', 'display_name' => 'Can View Role'],
            ['url'=> '', 'view_name' => '','is_active' => 1, 'group' => 'Roles', 'name' => 'can-delete-role', 'display_name' => 'Can Delete Role']
        ];

        Permission::insert($insert);
    }
}
