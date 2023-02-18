<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    /**
     *  Created at column
     */
    const CREATED_AT = 'cm_created_at';

    /**
     *  Updated at column
     */
    const UPDATED_AT = 'cm_updated_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cm_title',
        'cm_description'
    ];
}
