<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\UserDetail;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use jeremykenedy\LaravelRoles\Models\Role;
use Mockery\Exception;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        $validator = Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile_no' => ['required', 'digits:8'],
            'gender' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'accept_all_terms' => ['required'],
        ]);
        if($validator->fails()){
            Session::flash('flash_contact', 'show_register_error');
            if($data['register-button'] == 'ambassador-button'){
                Session::flash('show_ambassador_register_modal', true);
            }
            if($data['register-button'] == 'sponsor-button'){
                Session::flash('show_sponsor_register_modal', true);
            }
        }
        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        if($data['register-button'] == 'ambassador-button' || $data['register-button'] == 'sponsor-button'){
            $user =  User::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'mobile_no' => $data['mobile_no'],
            ]);
            if($user) {
                UserDetail::create([
                    'user_id' => $user->id,
                    'gender' => $data['gender'],
                    'zip_code' => $data['zip_code'],
                    'zip_city' => $data['zip_city'],
                    'address' => $data['address'],
                ]);
            }
            if($data['register-button'] == 'ambassador-button'){
                $role = Role::where('slug','ambassador')->first();
                $user->attachRole($role->id);
            }

            if($data['register-button'] == 'sponsor-button'){
                $role = Role::where('slug','sponsor')->first();
                $user->attachRole($role->id);
            }
            $setting_obj = new Setting();
            //Send email to new user registered users
            $email = $user->email;
            Mail::send('mail.new-user-register',compact('user','setting_obj'), function ($message) use ($email) {
                $message->to($email)->subject('Konto opprettet');
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });
            Session::flash('show_success_register_modal', true);
            return $user;
        }
    }
}
