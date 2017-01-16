<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\BillingRate;
use App\Http\Requests;
use App\Models\Invoice;
use App\Models\InvoiceLineItem;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Temporary method used to make mods to various tables.
     */
    public function migrate()
    {
        $invoices = Invoice::all();

        $rates = [];
        foreach ($invoices as $invoice) {
            $invoice_id = $invoice->id;
            $line_items = InvoiceLineItem::where('invoice_id', $invoice_id)
                ->get();
            foreach ($line_items as $line_item) {
                if (!is_null($line_item)) {
                    if ($line_item->id != 4 && $line_item->id != 10) {
                        $hours = floatval($line_item->hours);
                        $amount = floatval($line_item->amount);
                        if ($hours > 0 && !is_null($hours)) {
                            $amount = ($amount == 87.50) ? 82.50 : $amount;
                            //if (($amount / $hours) == 0) {
                               // echo $invoice_id . ' ' . round($amount / $hours) . '<br>'; //floatval($line_item->amount) / floatval($line_item->hours) . '<br>';
                            //}

                            $rate = round($amount / $hours);
                            $billing_rate = BillingRate::where('billing_rate', floatval($rate))
                                ->get()
                                ->first();
                            if (!is_null($billing_rate)) {
                                echo $invoice_id . ' ' . $billing_rate->id . '<br>';
                                $line_item->billing_rate_id = $billing_rate->id;
                                $saved = $line_item->save();
                                var_dump($saved);
                            }
                            if (!in_array($rate, $rates)) {
                                $rates[] = $rate;
                            }
                        }
                    }
                }
            }
        }
//        sort($rates);
//        foreach ($rates as $rate) {
//            $billing_rate = new BillingRate();
//            $billing_rate->billing_rate = $rate;
//            $billing_rate->save();
//        }
    }
}