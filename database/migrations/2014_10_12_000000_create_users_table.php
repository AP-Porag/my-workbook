<?php

use App\Utils\GlobalConstant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->index()->nullable();
            $table->string('middle_name')->index()->nullable();
            $table->string('last_name')->index()->nullable();
            $table->string('email')->index()->unique();
            $table->string('phone', 25)->index()->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->string('user_type', 50)->index();
            $table->string('gender')->nullable();
            $table->string('company_name')->index()->nullable();
            $table->string('auth_google_id')->nullable();
            $table->string('auth_facebook_id')->nullable();
            $table->string('auth_linkedin_id')->nullable();
            $table->string('verification_token')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('agreed_terms');
            $table->rememberToken();
            $table->string('status', 50)->index()->default(GlobalConstant::STATUS_INACTIVE);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
