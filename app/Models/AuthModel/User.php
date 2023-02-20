<?php

namespace App\Models\AuthModel;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\User as BaseUser;

class User extends BaseUser
{
    protected $connection= 'mysql';
}
