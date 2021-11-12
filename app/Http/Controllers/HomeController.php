<?php

namespace App\Http\Controllers;

use App\Models\DefaultRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class HomeController extends Controller
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function default_setting()
    {
        return view ('default_setting.index', [
            'breadcrumb' => 'Default Setting'
        ]);
    }

    public function getDefaultSetting()
    {
        $default_setting = DefaultRule::first(); 

      
        return response()->json([
            'default_setting'=> $default_setting,
        ]);
    }

    public function saveDefaultSetting(Request $request)
    {
        $postData = $request->all(); 
        // dd($postData);
        // DefaultRule::truncate();
        // $default_setting = DefaultRule::create($postData);
        $default_setting = DefaultRule::updateOrCreate(
            ['id' => '1'],
            [
                "name" => $postData['name'],
                "email" => $postData['email'],
                "phone" => $postData['phone'],
                "address" => $postData['address'],
                "website" => $postData['website'],
                "picture" => $postData['picture']??null,
                "checkin_time" => $postData['checkin_time'],
                "checkout_time" => $postData['checkout_time'],
                "confirm_message" => $postData['confirm_message'],
                "cancel_message" => $postData['cancel_message'],
                "amendment_message" => $postData['amendment_message'],
                "checkin_message" => $postData['checkin_message'],
                "checkout_message" => $postData['checkout_message'],
                "reminder_message" => $postData['reminder_message'],
                "reminder_before" => $postData['reminder_before'],
            ]
        );

      
        return response()->json([
            'success'=> true,
        ]);
    }

    public function saveDefaultKeys(Request $request)
    {
        $postData = $request->all(); 
        // dd($postData);
        $default_rule = DefaultRule::first();
        if($default_rule){ 
            $default_rule->update(['client_key'=> Crypt::encrypt($request->client_key), 'secret_key'=> Crypt::encrypt($request->secret_key)]);
            return response()->json([
                'success'=> true,
                'default_rule' => $default_rule
            ]);
        } else {
            return response()->json([
                'success'=> false,
                'message' => 'Default rule is missing'
            ]);
        } 

      
        
    }


}
