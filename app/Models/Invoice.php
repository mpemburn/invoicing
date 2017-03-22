<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BilledVia;
use App\Models\Client;
use App\Facades\Transactions;
use App\Helpers\Utility;
/**
 * Class Invoice
 */
class Invoice extends Model
{
    protected $table = 'invoices';
    protected $positive_transactions;

    public $timestamps = false;

    protected $fillable = [
        'project',
        'client_id',
        'invoice_date',
        'billed_date',
        'billed_via_id',
        'invoice_total',
        'outstanding_amount',
        'paid_amount',
        'paid_date',
        'total_hours',
        'billing_rate',
        'written_off',
        'billing_rate_calc'
    ];

    protected $guarded = [];

    /* Relationships ************************************************/
    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function billed_via_id()
    {
        return $this->hasOne('App\BilledVia');
    }

    /* Invoice Accessors ********************************************/

    /**
     * getClientDataAttribute
     * Usage:
     * $invoice->client_data
     *
     * @param $value
     * @return Client object
     */
    public function getClientDataAttribute($value)
    {
        $client = Client::find($this->client_id);
        return $client;
    }

    public function getBilledAmountAttribute($value)
    {
        $billed = InvoiceLineItem::where('invoice_id', $this->id)
            ->where('amount', '>', 0)
            ->select('amount')
            ->sum('amount');

        return $billed;
    }

    public function getBilledDollarAmountAttribute($value)
    {
        $billed = InvoiceLineItem::where('invoice_id', $this->id)
            ->where('amount', '>', 0)
            ->select('amount')
            ->sum('amount');

        return Utility::formatDollars($billed);
    }

    public function getPaidAmountAttribute($value)
    {
        $paid = InvoiceLineItem::where('invoice_id', $this->id)
            ->where('amount', '<', 0)
            ->select('amount')
            ->sum('amount');

        return $paid;
    }

    public function getPaidDollarAmountAttribute($value)
    {
        $paid = InvoiceLineItem::where('invoice_id', $this->id)
            ->where('amount', '<', 0)
            ->select('amount')
            ->sum('amount');

        return Utility::formatDollars($paid);
    }

    public function getBilledDateAttribute($value)
    {
        return $this->getShortDate($value);
    }

    public function getInvoiceDateAttribute($value)
    {
        return $this->getShortDate($value);
    }

    public function getPaidDateAttribute($value)
    {
        return $this->getShortDate($value);
    }

    /**
     * getLineItemsAttribute
     * Usage:
     * $invoice->line_items
     *
     * @param $value
     * @return InvoiceLineItem result set
     */
    public function getLineItemsAttribute($value)
    {
        $items = InvoiceLineItem::where('invoice_id', $this->id)->get();
        $counter = 0;
        // Add counter and odd/even attributes to each item
        $revised_items = $items->map(function ($item) use (&$counter) {
            $counter++;
            $line_item = InvoiceLineItem::find($item->id);
            $line_item->setCounter($counter);
            $line_item->setParity($counter);
            return $line_item;
        });

        return $revised_items;
    }

    /**
     * getTotalHoursAttribute
     * Usage:
     * $invoice->total_hours
     *
     * @param $value
     * @return float
     */
    public function getTotalHoursAttribute($value)
    {
        $valid_trans = Transactions::getPositiveTransactions();
        $total_hours = InvoiceLineItem::where('invoice_id', $this->id)
            ->whereIn('transaction_type', $valid_trans)
            ->select('hours')
            ->sum('hours');

        return $total_hours;
    }

    /**
     * getOutstandingTotalAttribute
     * Usage:
     * $invoice->outstanding_total
     *
     * @param $value
     * @return float
     */
    public function getOutstandingTotalAttribute($value)
    {
        return ($this->outstanding_amount != 0) ? $this->getDollarFormat($this->outstanding_amount) : 'PAID';
    }

    public function getPaidCssAttribute($value)
    {
        return ($this->outstanding_amount != 0) ? 'unpaid' : 'paid';
    }

    /* Invoice Mutators *********************************************/

    public function setOutstandingAmountAttribute($value)
    {
        $this->attributes['outstanding_amount'] = $value;
    }
    /* Private Methods **********************************************/

    private function getDollarFormat($dollars)
    {
        $dollars = (is_null($dollars)) ? 0 : $dollars;
        $formatted = number_format(abs($dollars), ...config('invoicing.dollar_format'));
        return ($dollars > 0) ? '$' . $formatted : '($' . $formatted . ')';
    }

    private function getShortDate($date)
    {
        return (is_null($date)) ? '' : date(config('invoicing.short_date') , strtotime($date));
    }
}