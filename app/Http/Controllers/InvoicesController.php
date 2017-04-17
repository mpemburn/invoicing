<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\TransactionType;
use Illuminate\Http\Request;

use App\Models\BillingRate;
use App\Http\Requests;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceLineItem;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\App;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::all()
            ->sortByDesc('id');

        return view('invoice_list', ['invoices' => $invoices]);
    }

    public function invoiceDetails($id = 0)
    {
        $invoice = Invoice::findOrNew($id);
        $client = new Client;
        // Get existing client data, or a blank client record if new invoice
        $client_data = ($id == 0) ? $client : $invoice->client_data;

        $transactions = TransactionType::orderBy('id')
            ->pluck('description', 'id')
            ->prepend('(select)', '');

        $services = Service::orderBy('description')
            ->pluck('description', 'id')
            ->prepend('(select)', '');

        return view('invoice_detail', [
            'invoice' => $invoice,
            'client' => $client_data,
            'line_items' => $invoice->line_items,
            'clients' => Client::all(),
            'form_action' => route('saveForm', $id),
            'services' => $services,
            'transactions' => $transactions
        ]);
    }

    public function invoicePdf($id)
    {
        $invoice = Invoice::find($id);
        $view = view('invoice_pdf', [
            'invoice' => $invoice,
            'client' => $invoice->client_data,
            'line_items' => $invoice->line_items
        ]);

        $html = $view->render();

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($html);
        return $pdf->stream();
    }

    /**
     * getLineitem
     */
    public function getLineitem($invoice_id, $lineitem_id)
    {
        $is_new = ($lineitem_id == 0);
        $lineitem = InvoiceLineItem::firstOrNew([
            'id' => $lineitem_id
        ]);

        if ($is_new) {
            return json_encode(['invoice_id' => $lineitem->id]);
        } else {
            return json_encode(['client_info' => $lineitem]);
        }
    }

    /**
     * setClient
     *
     * Update client or create new invoice with for this client
     * Designed to be called via AJAX
     *
     * @param $invoice_id
     * @param $client_id
     */
    public function setClient($invoice_id, $client_id)
    {
        $is_new = ($invoice_id == 0);

        $invoice = Invoice::firstOrNew([
            'id' => $invoice_id
        ]);
        // Set billed_via_id foriegn key.  Use default if this is a new record
        $billed_via_id = config('invoicing.default_billed_via_id');
        $invoice->billed_via_id = ($invoice_id == 0) ? $billed_via_id : $invoice->billed_via_id;
        $invoice->client_id = $client_id;
        $invoice->save();


        if ($is_new) {
            return json_encode(['invoice_id' => $invoice->id]);
        } else {
            $client_info = Client::getFullAddressInfo($client_id);
            return json_encode(['client_info' => $client_info]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($client_id)
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
    public function update(Request $request)
    {
        $invoice = Invoice::find($request->invoice_id);
        $invoice->saveInvoice($request);
        echo json_encode(['response' => "Bingo!"]);
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