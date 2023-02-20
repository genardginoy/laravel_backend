<?php

namespace App\Models\AuthModel;

use App\Models\Comment as BaseComment;

class Comment extends BaseComment
{
    protected $connection= 'mysql';
}
