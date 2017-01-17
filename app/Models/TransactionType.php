<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TransactionType
 */
class TransactionType extends Model
{
    protected $table = 'transaction_types';

    public $timestamps = false;

    protected $fillable = [
        'description',
        'is_expense',
        'is_invoice',
        'is_positive',
        'js_function',
        'required_controls'
    ];

    protected $guarded = [];

        
}