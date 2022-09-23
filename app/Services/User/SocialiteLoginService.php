<?php

namespace App\Services\User;

use App\Models\User;
use App\Services\BaseService;
use App\Utils\GlobalConstant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class SocialiteLoginService extends BaseService
{
    use AuthenticatesUsers;
    protected $model;

    public function __construct()
    {
        $this->model = User::class;
    }

    public function SocialiteLogin($driver = null)
    {
        try {  
            $user            = Socialite::driver($driver)->stateless()->user();
            $full_name_array = explode(" ", $user->name); 

            $find_user = User::whereEmail($user->email)->first();

            if ($find_user) {
                Auth::login($find_user);
                return true;
            } else { 
                if(session()->has('user_type')){

                    $data = [
                        'first_name'        => $full_name_array[0],
                        'last_name'         => $full_name_array[1] ?? $full_name_array[0],
                        'email'             => $user->email,
                        'password'          => Hash::make(random_number()),
                        // TODO: Add user type dynamic
                        'user_type'         => session('user_type'),
                        'agreed_terms'      => 1,
                        'status'            => GlobalConstant::STATUS_ACTIVE,
                        'email_verified_at' => now(),
                    ];

                    if ($driver == 'google') {
                        $data['auth_google_id'] = $user->id;
                    } elseif ($driver == 'linkedin') {
                        $data['auth_linkedin_id'] = $user->id;
                    } else {
                        $data['auth_facebook_id'] = $user->id;
                    }  
                    $newUser = User::create($data);
                    Auth::login($newUser);
                    session()->forget('user_type'); 
                    return true;

                } else {                    
                    $data = [
                        'first_name'        => $full_name_array[0],
                        'last_name'         => $full_name_array[1] ?? $full_name_array[0],
                        'email'             => $user->email,
                        'password'          => Hash::make(random_number()), 
                        'agreed_terms'      => 1,
                        'status'            => GlobalConstant::STATUS_ACTIVE,
                        'email_verified_at' => now(),
                    ];

                    if ($driver == 'google') {
                        $data['auth_google_id'] = $user->id;
                    } elseif ($driver == 'linkedin') {
                        $data['auth_linkedin_id'] = $user->id;
                    } else {
                        $data['auth_facebook_id'] = $user->id;
                    } 
                    session(['auth_data' => $data]);  
                    return true;
                } 
            }
        } catch (\Exception $e) {
            $this->logFlashThrow($e);
        }
    }
}
