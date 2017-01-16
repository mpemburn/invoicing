<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class State
 */
class State extends Model
{
    protected $table = 'states';

    public $timestamps = false;

    protected $fillable = [
        'abbrev',
        'state',
        'local',
        'country'
    ];

    protected $guarded = [];

        
}