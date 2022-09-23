<?php

namespace App\Models;

use App\Utils\GlobalConstant;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    public const FILE_STORE_PATH = 'users_avatar';
    // User type
    public const USER_TYPE_ADMIN   = 'admin';
    public const USER_TYPE_CUSTOMER = 'customer';

    public const FILE_STORE_THUMB_PATH = 'content_images/thumb';
    public const THUMB_WIDTH = 300;
    public const THUMB_HEIGHT = 170;


    protected $appends = ['full_name', 'avatar_url'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'gender',
        'phone',
        'status',
        'user_type',
        'date_of_birth',
        'password',
        'created_by',
        'updated_by',
        'verification_token',
        'email_verified_at',
        'agreed_terms',
        'company_name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //get active data
    public function scopeActive($query)
    {
        return $query->where('status', GlobalConstant::STATUS_ACTIVE);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getAvatarUrlAttribute()
    {
        return get_storage_image(self::FILE_STORE_PATH, $this->avatar, 'user');
    }

}
