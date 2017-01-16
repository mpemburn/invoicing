<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BillingRate
 */
class BillingRate extends Model
{
    protected $table = 'billing_rates';

    public $timestamps = false;

    protected $fillable = [
        'billing_rate',
        'description'
    ];

    protected $guarded = [];

        
}