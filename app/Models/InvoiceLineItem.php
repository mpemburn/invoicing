<?php

namespace App\Models;

use App\Helpers\Utility;
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
    protected $counter;
    protected $parity;

    public function getDescriptionHtmlAttribute($value)
    {
        return '<p>' . str_replace("\n", '</p><p>', $this->description) . '</p>';
    }

    public function getDollarAmountAttribute($value)
    {
        return Utility::formatDollars($this->amount);
    }

    public function getItemHoursAttribute($value)
    {
        return ($this->hours != 0) ? $this->hours : '';
    }

    public function getCounterAttribute($value)
    {
        return $this->counter;
    }

    public function getPaidAttribute($value)
    {
        return ($this->amount < 0) ? 'paid' : '';
    }

    public function getParityAttribute($value)
    {
        return $this->parity;
    }

    public function setCounter($counter)
    {
        $this->counter = $counter;
    }

    public function setParity($counter)
    {
        $this->parity = ($counter % 2) ? 'odd' : 'even';
    }
}