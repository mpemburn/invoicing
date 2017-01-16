<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BilledVium
 */
class BilledVia extends Model
{
    protected $table = 'billed_via';

    public $timestamps = false;

    protected $fillable = [
        'billed_via'
    ];

    protected $guarded = [];

        
}