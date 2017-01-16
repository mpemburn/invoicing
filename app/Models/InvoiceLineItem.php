<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class InvoiceLineItem
 */
class InvoiceLineItem extends Model
{
    protected $table = 'invoice_line_items';

    public $timestamps = false;

    protected $fillable = [
        'invoice_id',
        'item_number',
        'service',
        'service_type',
        'description',
        'billing_rate_id',
        'hours',
        'amount',
        'check_number',
        'check_amount',
        'payment_date',
        'balance_forward',
        'forward_to_invoice',
        'transaction_type'
    ];

    protected $guarded = [];

        
}