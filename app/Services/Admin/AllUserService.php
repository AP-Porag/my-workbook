<?php

namespace App\Services\Admin;

use App\Models\User;
use App\Services\BaseService; 
use Illuminate\Support\Facades\Hash;

class AllUserService extends BaseService
{

    protected $model;

    public function __construct()
    {
        $this->model = User::class;
    }

    public function storeOrUpdate($data, $id = null, $user_type = "student")
    {
        try {
            $data['user_type'] = $user_type;
            $data['password'] = Hash::make($data['password']); 
            
            if($id == null){                
                $data['email_verified_at'] = now();
                $data['created_by'] = auth()->id();                
            } else {
                $data['updated_by'] = auth()->id();
            } 
            return parent::storeOrUpdate($data, $id);
        } catch (\Exception $e) {
            $this->logFlashThrow($e);
        }
    }
}
