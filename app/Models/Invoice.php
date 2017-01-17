<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
/**
 * Class Invoice
 */
class Invoice extends Model
{
    protected $table = 'invoices';

    public $timestamps = false;

    protected $fillable = [
        'project',
        'client_id',
        'invoice_date',
        'billed_date',
        'billed_via_id',
        'invoice_total',
        'paid_amount',
        'paid_date',
        'total_hours',
        'billing_rate',
        'written_off',
        'billing_rate_calc'
    ];

    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }}