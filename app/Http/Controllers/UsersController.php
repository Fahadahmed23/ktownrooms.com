<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\City;
use App\Models\Hotel;
use App\Models\UserExperience;
use App\Models\Department;
use App\Models\Designation;
use App\Models\UserAddress;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AddUserRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;
use App\Mail\PasswordReset;
use App\Models\Role;
use App\Models\State;
use App\Models\UserHotel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use PhpParser\Node\Stmt\Foreach_;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view ('users.index',['breadcrumb' => 'Users']);
    }

    public function getUsers()
    {
        $filters = json_decode(request()->filters);
        $users = User::with(['addresses', 'addresses.city:id,CityName,state_id', 'addresses.state:id,StateName', 'experiences', 'roles'])
                        ->whereDoesntHave('roles', function($q){
                        $q->whereIn('name', ['Admin']);
        })->where('id', '!=', Auth::user()->id);

        $cities = City::get(['id', 'CityName', 'state_id']);
        $hotels = auth()->user()->user_hotels();
        $departments = Department::all();
        $designations = Designation::all();
        $states = State::get(['id', 'StateName']);
        $roles = Role::all();

        if (auth()->user()->hasRole('Admin')) {
            $is_admin = true;
        }
        else{
            $is_admin = false;
            $c_ids= $hotels->get()->pluck(['city_id']);
            $city_ids= $c_ids->unique();
            $cities =  $cities->whereIn('id',$city_ids);
        }

        if ($filters->name != "") {
            $users = $users->where('name', 'LIKE', '%' . $filters->name . '%');
        }

        if ($filters->email != "") {
            $users = $users->where('email', 'LIKE', '%' . $filters->email . '%');
        }

        if ($filters->phone != "") {
            $users = $users->where('phone_no', 'LIKE', '%' . \str_replace('-', '', $filters->phone) . '%');
        }

        if ($filters->hotel_id != "") {
              $user_ids =  UserHotel::where('hotel_id', $filters->hotel_id)->get(['user_id']);
              $users = $users->whereIn('id', $user_ids->toArray());
        }

        if(!auth()->user()->hasRole('Admin')) {
            $user_ids = $users->pluck('id');
            
            $users = collect([]);
            $user = auth()->user();
            
            foreach ($user->hotels->toArray() as $hotel) {
                $h = Hotel::find($hotel['hotel_id']);
                $u = $h->allUsers;
                
                if ($u) {
                    $users = $users->concat($u);
                }
                
            }
            
            $users = $users->whereIn('id', $user_ids)->unique('id');
            
            $users = User::with(['addresses', 'addresses.city:id,CityName,state_id', 'addresses.state:id,StateName', 'experiences', 'roles'])
                        ->whereDoesntHave('roles', function($q){
                        $q->whereIn('name', ['Admin']);
                    })->where('id', '!=', Auth::user()->id)->whereIn('id', $users->map(function($u) {
                        return $u->id;
                    }))->get();
            
            // $userss = auth()->user()->hotel->allUsers()->where('users.id', '!=', auth()->id());
        } else {
            $users = $users->get();
        }

        return  response()->json([
            'users'=> $users,
            'cities'=> $cities,
            'states' => $states,
            'hotels'=> $hotels->get(),
            'departments'=> $departments,
            'designations'=> $designations,
            'roles' => $roles,
            'is_admin' => $is_admin
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddUserRequest $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try
        {
            $user = new User();
            $user->name = $request->first_name.' '.$request->last_name; 
            $password = Str::random(10);
            $user->password = Hash::make($password);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->picture = $request->picture;
            $user->phone_no = $request->phone_no;
            $user->city_id = $request->city_id;
            // $user->hotel_id = $request->hotel_id;
            // $user->department_id = $request->department_id;

            if($request->all_department == '1'){
                $user->department_id = Null;
            }
            else{
                $user->department_id = $request->department_id;
            }

            $user->designation_id = $request->designation_id;
            $user->reference_name = $request->reference_name;
            $user->reference_department = $request->reference_department;
            $user->reference_designation = $request->reference_designation;
            $user->max_allowed_discount = empty($request->max_allowed_discount) ? 0 : $request->max_allowed_discount;
            $user->save();

            if (!empty($request->hotel_id))
            {
                foreach ($request->hotel_id as $key => $h_id) {
                $userHotel = new UserHotel();
                $userHotel->user_id = $user->id;
                $userHotel->hotel_id = $h_id;
                $userHotel->save();
                }
            }

            
            
            if (!empty($request->experiences)){
                foreach ($request->experiences as $exp) {
                    $userExp = new UserExperience();
                    $userExp->user_id = $user->id;
                    $userExp->no_of_years = $exp['no_of_years'];
                    $userExp->organization_name = $exp['organization_name'];
                    $userExp->role = $exp['role'];
                    $userExp->save();
                }
            }

            if (!empty($request->addresses)){
                foreach($request->addresses as $address){
                    $userAddress = new UserAddress();
                    $userAddress->user_id = $user->id;
                    $userAddress->type = $address['type'];
                    $userAddress->address = $address['address'];
                    if (!empty($address['city'])) {
                        $userAddress->city_id = $address['city']['id'];
                    }
                    if (!empty($address['state'])){
                        $userAddress->state_id = $address['state']['id'];
                    }
                    if (!empty($address['zip'])) {
                        $userAddress->zip = $address['zip'];
                    }

                    if ($address['primary'] == "true") {
                        $userAddress->primary = 1;
                    } else {
                        $userAddress->primary = 0;
                    }

                    $userAddress->save();
                }
            }

            if (!empty($request->roles)) {
                foreach ($request->roles as $role) {
                    $user->roles()->attach($role);
                }
            }
            DB::commit(); 

            // Send Email
            Mail::to($user->email)->send(new WelcomeEmail($user, $password));
        }
        catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'errors' => [['exception' => $e->getMessage()]],
                'msgtype' => 'error',
                // 'id' => $user->id
            ]);
        }   
        $user = User::with(['addresses', 'addresses.city', 'addresses.state', 'experiences', 'roles'])->where('id', '=', $user->id)->first();


        return response()->json([
            'success' => true,
            'message' => ["User '$user->first_name' Created successfully."],
            'msgtype' => 'success',
            'user'=> $user
        ]);
    
    }

    public function resendPassword(Request $request) {
        $user = User::findOrFail($request->id);

        $credentials = ['email' => $user->email];

        $response = Password::sendResetLink($credentials, function(Message $message) {
            $message->subject($this->getEmailSubject);
        });

        switch ($response) {
            case Password::RESET_LINK_SENT:
                return response()->json([
                    'success' => true,
                    'message' => ["Email sent successfully."],
                    'msgtype' => 'success',
                ]);
            case Password::INVALID_USER:
                return response()->json([
                    'success' => false,
                    'message' => ["User Invalid"],
                    'msgtype' => 'danger',
                ]);
        }
        // generate new password
        // $password = Str::random(10);

        // $user->password = Hash::make($password);
        // $user->save();

        // // send email
        // Mail::to($user->email)->send(new PasswordReset($user, $password));

        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddUserRequest $request, $id)
    {
        //  dd($request->hotel_id);   
        DB::beginTransaction();
        try{        
        $user = User::find($request->id);
        // dd($request->first_name.' '.$request->last_name);
        $user->name = $request->first_name.' '.$request->last_name; 
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone_no = $request->phone_no;
        $user->city_id = $request->city_id;
        // $user->hotel_id = $request->hotel_id;
        // $user->department_id = $request->department_id;
        
        if($request->all_department == '1'){
            $user->department_id = Null;
        }
        else{
            $user->department_id = $request->department_id;
        }

        $user->designation_id = $request->designation_id;
        $user->reference_name = $request->reference_name;
        $user->reference_department = $request->reference_department;
        $user->reference_designation = $request->reference_designation;
        $user->picture = $request->picture;
        $user->max_allowed_discount = empty($request->max_allowed_discount) ? 0 : $request->max_allowed_discount;
        $user->save();

        UserHotel::where('user_id',$request->id)->delete();

        if (!empty($request->hotel_id))
        {
            foreach ($request->hotel_id as $key => $h_id) {
                $userHotel = new UserHotel();
                $userHotel->user_id = $user->id;
                $userHotel->hotel_id = $h_id;
                $userHotel->save();
            }
        }

        UserExperience::where('user_id','=',$request->id)->delete();
        if (!empty($request->experiences)){
            foreach ($request->experiences as $exp) {
                $userExp = new UserExperience();
                $userExp->user_id = $user->id;
                $userExp->no_of_years = $exp['no_of_years'];
                $userExp->organization_name = $exp['organization_name'];
                $userExp->role = $exp['role'];
                $userExp->save();
            }
        }
        // UserAddress::where('user_id','=',$request->id)->delete();
        // if (!empty($request->addresses)){
    
        //     foreach($request->addresses as $address){
        //         $userAddress = new UserAddress();
        //         $userAddress->user_id = $user->id;
        //         $userAddress->type = $address['type'];
        //         $userAddress->address = $address['address'];
        //         if (!empty($address['city'])) {
        //             $userAddress->city = $address['city'];
        //         }
        //         if (!empty($address['state'])){
        //             $userAddress->state = $address['state'];
        //         }
        //         if (!empty($address['zip'])) {
        //             $userAddress->zip = $address['zip'];
        //         }

        //         if ($address->primary) {
        //             $userAddress->is_primary = 1;
        //         } else {
        //             $userAddress->is_primary = 0;
        //         }

        //         $userAddress->save();
        //     }
        // }
        
        

        $roles = DB::table('role_user')->where('user_id', '=', $user->id)->delete();
        // dd($roles);

        // foreach ($roles as $role) {
        //     $user->roles()->detach($role->id);
        // }

        if (!empty($request->roles)) {
            foreach ($request->roles as $role) {
                $user->roles()->attach($role);
            }
        }
        
        DB::commit();
    }
    catch(\Exception $e){
        DB::rollBack();
        return response()->json([
            'success' => false,
            'errors' => [['exception' => $e->getMessage()]],
            'msgtype' => 'error',
            // 'id' => $user->id
        ]);
    }

        $user = User::with(['addresses', 'experiences', 'roles'])->where('id', '=', $user->id)->first();
        return response()->json([
            'success' => true,
            'message' => ["User '$user->first_name' Updated successfully."],
            'msgtype' => 'success',
            'user' => $user
        ]);

    }

    public function saveAddress(Request $request)
    {
        // dd($request->all());
        if ($request['frmType'] == "save") {
            $userAddress = new UserAddress();
        } else {
            $userAddress = UserAddress::find($request['address']['id']);
        }

        $userAddress->user_id = $request['user_id'];

        $userAddress->type = $request['address']['type'];
        $userAddress->address = $request['address']['address'];
        if (!empty($request['address']['city'])) {
            $userAddress->city_id = $request['address']['city']['id'];
        }
        if (!empty($request['address']['state'])){
            $userAddress->state_id = $request['address']['state']['id'];
        }
        if (!empty($request['address']['zip'])) {
            $userAddress->zip = $request['address']['zip'];
        }

        if ($request['address']['primary'] == "true") {
            // echo "primary";
            // make other addresses not primary
            UserAddress::where('user_id', '=', $request['user_id'])->update(['primary' => 0]);

            $userAddress->primary = 1;
        } else {
            $userAddress->primary = 0;
        }

        $userAddress->save();

        $address = UserAddress::with(['city:id,CityName,state_id', 'state:id,StateName'])->where('id', '=', $userAddress->id)->first();

        return response()->json([
            'success' => true,
            'message' => ['Address Saved Successfully'],
            'msgtype' => 'success',
            'address' => $address
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        User::find($request->id)->delete();  
        return response()->json([
            'success' => true,
            'message' => ["User '$request->first_name' deleted successfully."],
            'msgtype' => 'success',
            'id' => $request->id
        ]);

    }

    public function saveProfilePicture(Request $request)
    {
        $this->validate(
            $request,
            [
                'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:10240',
            ],
            [
                'image.mimes' => 'The image must be file of type jpeg,png,jpg,gif,svg'
            ]
        );

        $image = $request->file('image');
        $name = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('/images');
        $image->move($destinationPath, $name);

        echo json_encode(['success' => true, 'payload' => url('images/' . $name)]);
    }

    public function removeAddress(Request $request) {
        UserAddress::find($request->id)->delete();

        return response()->json([
            'success' => true,
            'message' => ['Address deleted successfully'],
            'msgtype' => 'success'
        ]);
    }
}
