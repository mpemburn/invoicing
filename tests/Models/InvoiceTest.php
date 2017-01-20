<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Client;
use App\Models\InvoiceLineItem;

class InvoiceTest extends TestCase
{
    use DatabaseMigrations;


    /**
     * @test
     */
    public function lineItemCanBeCreated()
    {
        $client = $this->createClient();
        if (!is_null($client)) {
            $invoice = $this->createInvoiceForClient($client);
            if (!is_null($invoice)) {
                InvoiceLineItem::create([
                    'invoice_id' => $invoice->id,
                    'item_number' => 1,
                    'billing_rate_id' => 1,
                    'transaction_type' => 1,
                    'service' => 'Software Development'
                ]);
            }
        }
        $this->seeInDatabase('invoice_line_items', ['service' => 'Software Development']);
    }

    /**
     * @test
     */
    public function invoiceCanBeCreated()
    {
        $client = $this->createClient();
        if (!is_null($client)) {
            $this->createInvoiceForClient($client);
        }
        $this->seeInDatabase('invoices', ['id' => 1, 'billed_via_id' => 1, 'total_hours' => 30]);
    }

    private function createClient()
    {
        return factory(App\Models\Client::class)->create();

    }
    private function createInvoiceForClient($client)
    {
        return $client->invoices()->create([
            'total_hours' => 30,
            'billed_via_id' => 1
        ]);
    }
}
