<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Title
 */
class Title extends Model
{
    protected $table = 'titles';

    public $timestamps = false;

    protected $fillable = [
        'title'
    ];

    protected $guarded = [];

        
}