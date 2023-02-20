<?php

namespace App\Models\AuthModel;

use App\Models\Todo as BaseTodo;

class Todo extends BaseTodo
{
    protected $connection= 'mysql';
}
