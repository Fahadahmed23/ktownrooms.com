<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\AddRoleRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
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
        return view('roles.index',['breadcrumb' => 'Roles']);
    }

    public function create(AddRoleRequest $request, Role $role)
    {

        
        $postData = $request->all();
        $i = 0;
        $count = 0;
        $exists = array_key_exists('permissions',$postData);
        if($exists){

            foreach ($postData['permissions'] as  $value) {

                if ($value == 'false')
                    $count++;
                if ($value != NULL) {
                    $i++;
                }
            }

            $permissions = $postData['permissions'];

            unset($postData['permissions']);
        } 

        $role->save($postData);
        if($exists){
            $permissionData = [];
            foreach ($permissions as $key => $value) {
                if (filter_var($value, FILTER_VALIDATE_BOOLEAN)) {
                    $permissionData[] = ['role_id' => $role->id, 'permission_id' => $key];
                }
            }

            \DB::table('permission_role')->where('role_id', $role->id)->delete();

            if (count($permissionData) > 0) {
                \DB::table('permission_role')->insert($permissionData);
            }
        }
        $response = [
            'success' => true,
            'message' => [$postData['display_name'].' ' .(isset($postData['id'])? 'updated': 'added').' successfully!'],
            'msgtype' => 'success',
            'id' => $role->id
        ];

        echo json_encode($response);
    }

    public function created(AddRoleRequest $request)
    {
        $postData = $request->all();
        // dd($postData);
        $i = 0;
        $count = 0;
        // dd($postData['permissions']);
        $exists = array_key_exists('permissions',$postData);
        // dd($exists);
        if($exists){
            foreach ($postData['permissions'] as  $value) {
                if ($value == 'false')
                    $count++;
                if ($value != NULL) {
                    $i++;
                }
            }

            $permissions = $postData['permissions'];

            unset($postData['permissions']);
        } 

        if (array_key_exists('id', $postData)) {
            // dd('edit');
            // $role_id = $postData['id'];
            // unset($postData['id']);
            // dd(Role::find($role_id));
            // Edit
            $role = Role::find($postData['id']);
            $role->update($postData);
        } else {
            $role = Role::create($postData);
        }

        

        // $role->save($postData);
        if($exists){
            $permissionData = [];
            foreach ($permissions as $key => $value) {
                if (filter_var($value, FILTER_VALIDATE_BOOLEAN)) {
                    $permissionData[] = ['role_id' => $role->id, 'permission_id' => $key];
                }
            }
            // dd($permissionData);

            //delete previous records
            \DB::table('permission_role')->where('role_id', $role->id)->delete();

            if (count($permissionData) > 0) {
                \DB::table('permission_role')->insert($permissionData);
            }
        }
        $response = [
            'success' => true,
            'message' => [$postData['display_name'].' ' .(isset($postData['id'])? 'updated': 'added').' successfully!'],
            'msgtype' => 'success',
            'id' => $role->id
        ];

        echo json_encode($response);
    }

    public function get(Request $request)
    {

        $data = $request->all();

        $roles ="";

        if (isset($data['name'])) {
            $roles=Role::where('name', 'like', '%' . $data['name'] . '%')->withCount('users')->get();
            // ->whereNotIn('name',['superadmin','guest', 'Admin'])->get();
        }
        else{
            $roles=Role::withCount('users')->get();
            // whereNotIn('name',['superadmin','guest', 'Admin'])->get();
            // dd($roles);
        }

        $data = [];
        foreach ($roles->toArray() as $role) {
            $rolePermissions = \DB::table('permission_role')->where('role_id', $role['id'])->get();
           

            if (count($rolePermissions) > 0) {
                foreach ($rolePermissions as $rolePermission) {
                    $role['permissions'][$rolePermission->permission_id] = true;
                }

            } else {
                $role['permissions'] = [];
            }

            // $roleUsers = \DB::table('role_user')->where('role_id', $role['id'])->get();

            // if (count($roleUsers) > 0) {
            //     foreach ($roleUsers as $roleUser) {
            //         $role['users'][$roleUser->user_id] = true;
            //         // $role['userscount'] = count($role['users']);
            //     }

            // } else {
            //     $role['users'] = [];
            // }
            
            $data[] = $role;
            
        }

        echo json_encode(['success' => true, 'payload' => $data], JSON_NUMERIC_CHECK);
    }

    public function getRolesData(Request $request)
    {
        // dd($request);
        $data = $request->all();
        $roleName = $data['id'];
        $role = [];
        // $role['availableusers'] = User::with(['roles'])->whereDoesntHave('roles', function ($q) use ($roleName) {
        //     $q->where('id', $roleName);
        // })->get();
        
        $role['assignedusers'] = User::with(['roles'])->whereHas('roles', function ($q) use ($roleName) {
            $q->where('id', $roleName);
        })->get();

        $data = [];
        foreach ($role['assignedusers'] as $value) {
            $data[] = $value->id;
        }


        $role['availableusers'] = User::with(['roles'])->whereRaw("NOT EXISTS 
            (SELECT 
            * 
            FROM
            role_user 
            WHERE role_id = ? 
          AND user_id = users.id)"
        , [$roleName])->get();

        $role['availableusers'] = User::whereDoesntHave('roles')->get();

        // dd($role['availableusers']);
// dd(\DB::getQueryLog()); // Show results of log

        //dd(json_encode($role['availableusers']));
        echo json_encode(['success' => true, 'payload' => $role]);
    }

    public function delete(Request $request)
    {
        $request = $request->all();

        // dd($request);

        $roleId = $request['id'];
        $count =  User::with(['roles'])->whereHas('roles', function ($q) use ($roleId) {
            $q->where('id', $roleId);
        })->get()->count();

        // dd($count);

        $role = Role::findOrFail($request['id']);

        // dd($role);

        $role_display_name = $role->display_name;
        if ($count == 0) {
            // dd($role);
            $role->delete();
            // dd('deleted');
            $response = [
                'success' => true,
                'message' => [$role_display_name .' removed successfully!'],
                'msgtype' => 'success'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => ['You can\'t delete '.$role_display_name.', this role has already been assigned to ' . $count . ' user(s)'],
                'msgtype' => 'danger'
            ];
        }
        echo json_encode($response);
    }

    public function removeUserRole(Request $request)
    {

        $request = $request->all();
        $user = User::where('id',  $request["id"])->first();
        $user_name = $user->name;
        $user->roles()->detach($request['role']);

        $response = [
            'success' => true,
            'message' => [$user_name.' role removed successfully!'],
            'msgtype' => 'success'
        ];
        echo json_encode($response);
    }

    public function assignUserRole(Request $request)
    {

        $request = $request->all();
        $userData = [];

        // umer
        foreach ($request['users'] as $key => $value) {
            if (filter_var($value, FILTER_VALIDATE_BOOLEAN) == true) {
                $user = User::findOrFail($key);
                $user->roles()->attach($request['role']);
                $userData[] = ['user_id' => $key, 'role_id' => $request['role']];
            }
        }
        // Role::where('id', $request['role'])->update(['is_system'=>1]);
        if (count($userData) > 0) {
            $response = [
                'success' => true,
                'message' => ['Role assigned to user(s) successfully!'],
                'msgtype' => 'success'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => ['There is no user to be assigned for role'],
                'msgtype' => 'danger'
            ];
        }
        echo json_encode($response);
    }
}
