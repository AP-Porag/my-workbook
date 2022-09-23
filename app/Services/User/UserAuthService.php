<?php

namespace App\Services\User;

use App\Models\User;
use App\Mail\ResetPassword;
use Illuminate\Support\Str;
use App\Utils\GlobalConstant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class UserAuthService
{

    protected $model;
    /**
     * Call the constructor by using the Model
     */
    public function __construct()
    {
        $this->model = User::class; 
    }

    /**
     * User Registration
     */
    public function userRegistration($data)
    { 
        DB::beginTransaction();
        try { 
            $token = Str::random(64); 
            $data['status'] = GlobalConstant::STATUS_ACTIVE;
            $data['password'] = Hash::make($data['password']);
            $data['verification_token'] = $token; 
            $user = User::create($data); 

            try {
                // Sent the user email verification email
                Mail::send('email.auth.email_verification_register', ['token' => $token, 'first_name' => $data['first_name']], function ($message) use ($data) {
                    $message->to($data['email']);
                    $message->subject('Talentable: Please Confirm Your Account Email');
                });
            } catch (\Exception $e) {
                log_error($e);
            } 
            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            log_error($e);
        }
    }

    /**
     * User verify email
     * @return response
     */
    public function verifyEmail($token)
    {
        try {
            $user = User::where('verification_token', $token)->first();
            if (!$user) {
                throw new \Exception('Invalid token');
            }

            if ($user->email_verified_at) {
                record_updated_flash('This account already verified');
            } else { 
                $user->email_verified_at  = now();
                $user->verification_token = null;
                $user->save(); 
                if ($user->user_type == User::USER_TYPE_STUDENT) {
                    Auth::login($user);
                    record_created_flash('Successfully verified your account');
                    return redirect()->route('student.dashboard'); 
                } else if ($user->user_type == User::USER_TYPE_MENTOR) {
                    Auth::login($user);
                    record_created_flash('Successfully verified your account'); 
                    return redirect()->route('mentor.dashboard');
                } else if ($user->user_type == User::USER_TYPE_COMPANY) {
                    Auth::login($user);
                    record_created_flash('Successfully verified your account');
                    return redirect()->route('company.dashboard'); 
                } 
            }

        } catch (\Exception $e) {
            something_wrong_flash('Invalid token or expired');
            return redirect('/');
        }
    }

 
    /**
     * User reset password submit 
     * @return response
     */
    public function sentResetPasswordEmail($email)
    {
        $token = Str::random(64);
        $user = User::where('email', $email)->first();
        if (!$user) {
            something_wrong_flash('Email not found!');
            return back();
        } 
        $user['verification_token'] = $token; 
        $user->save();

        $username = $user->first_name .' '.$user->last_name;
        Mail::to($email)->send(new ResetPassword($username, $token));

        if(Mail::failures() != 0) { 
            return redirect()->route('reset.password.message');
        } else {
            something_wrong_flash('Failed! there is some issue with email provider');
            return back();
        }
    }

    /**
     * User reset password submit 
     * @return response
     */
    public function resetPasswordSubmitUpdate($data)
    {
        $updatePassword = User::where('verification_token', $data->token)->first();

        if (!$updatePassword) {
            something_wrong_flash('Invalid token');
            return back();
        } else { 
            $updatePassword->update(['password' => Hash::make($data->password), 'verification_token' => null]);
            
            if ($updatePassword->user_type == User::USER_TYPE_ADMIN) {
                record_updated_flash('Password Reset Successfully.');
                return redirect('/admin/login');
            } else if ($updatePassword->user_type == User::USER_TYPE_STUDENT || $updatePassword->user_type == User::USER_TYPE_COMPANY || $updatePassword->user_type == User::USER_TYPE_MENTOR) {
                record_updated_flash('Password Reset Successfully.');
                return redirect()->route('user.auth.login');
            } else {
                something_wrong_flash('Something is wrong');
                return redirect('/');
            }
        }
    }

    
}