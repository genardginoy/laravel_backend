<?php

namespace App\Models\AuthModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Article as BaseArticle;

class Article extends BaseArticle
{
    protected $connection= 'mysql';
}
