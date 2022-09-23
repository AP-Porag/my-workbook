<?php

namespace Database\Seeders;

use App\Models\User;
use App\Utils\GlobalConstant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'first_name'        => 'Super',
                'last_name'         => 'Admin',
                'email'             => 'admin@app.com',
                'email_verified_at' => now(),
                'password'          => '$2y$10$mmv2lR.uMmhG.EC9FQEirO4YrLtjqATfmzDPwIPKLIDLSCNhPtVqu',   // 12345678
                'user_type'         => User::USER_TYPE_ADMIN,
                'gender'            => 'male',
                'status'            => GlobalConstant::STATUS_ACTIVE,
                'remember_token'    => Str::random(60),
                'phone'             => '012345678910',
                'date_of_birth'     => '2000-10-21',
                'agreed_terms'      => 1,
            ],
            [
                'first_name'        => 'Customer',
                'last_name'         => 'Last',
                'email'             => 'customer@app.com',
                'email_verified_at' => now(),
                'password'          => '$2y$10$mmv2lR.uMmhG.EC9FQEirO4YrLtjqATfmzDPwIPKLIDLSCNhPtVqu',   // 12345678
                'user_type'         => User::USER_TYPE_CUSTOMER,
                'gender'            => 'male',
                'status'            => GlobalConstant::STATUS_ACTIVE,
                'remember_token'    => Str::random(60),
                'phone'             => '012345678910',
                'date_of_birth'     => '2000-10-21',
                'agreed_terms'      => 1,
            ],
        ];


        foreach ($users as $user) {
            User:: create($user);
        }
    }
}
