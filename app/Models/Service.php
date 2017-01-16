<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Service
 */
class Service extends Model
{
    protected $table = 'services';

    public $timestamps = false;

    protected $fillable = [
        'description',
        'rate'
    ];

    protected $guarded = [];

        
}