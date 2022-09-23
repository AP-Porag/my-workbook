<?php

namespace App\Services\User;

use App\Models\User;
use App\Mail\ResetPassword;
use App\Services\BaseService;
use Illuminate\Support\Str;
use App\Utils\GlobalConstant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class UserService extends BaseService
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
     * Get paginated active user according user type
     */
    public function getPaginatedActiveUserByType(int $limit = GlobalConstant::DEFAULT_PER_PAGE, array $with = [], bool $own_data = false, string $sort = null, string $sort_by = 'DESC',string $user_type)
    {
        try {
            $query = $this->model::query()->where('user_type',$user_type)->with($with);
            // Check data belongs to provided user
            if ($own_data) {
                $query->where('user_id', Auth::id());
            }
            // Sort data
            if ($sort) {
                $query->orderBy($sort, $sort_by);
            }
            return $query->active()->paginate($limit);
        } catch (\Exception $e) {
            $this->logFlashThrow($e);
        }
    }

    public function getRecentActiveUserByType(int $limit = GlobalConstant::DEFAULT_RECENT_LIMIT,string $user_type, array $with = [], bool $own_data = false)
    {
        try {
            $query = $this->model::query()->where('user_type',$user_type)->with($with);
            // Check data belongs to provided user
            if ($own_data) {
                $query->where('user_id', Auth::id());
            }
            return $query->active()->latest()->take($limit)->get();
        } catch (\Exception $e) {
            $this->logFlashThrow($e);
        }
    }

    /**
     * Get all active comapnies
     */
    public function getAllCompanies()
    {
        return $this->model::Where('user_type', User::USER_TYPE_COMPANY)->where('status', GlobalConstant::STATUS_ACTIVE)->select('id', 'first_name', 'last_name', 'company_name')->get();
    }

}
