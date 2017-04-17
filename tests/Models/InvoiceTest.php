<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Client;
use App\Models\InvoiceLineItem;

class InvoiceTest extends TestCase
{
    use DatabaseMigrations;

    protected $dummy_item = [
        'item_number' => 1,
        'billing_rate_id' => 1,
        'transaction_type' => 1,
        'hours' => 33,
        'amount' => 0,
        'service' => 'Software Development'
    ];

    /**
     * @test
     */
    public function lineItemCanBeCreated()
    {
        $client = $this->getClient(4);
        $this->createInvoiceWithLineItem($client, $this->dummy_item);

        $this->seeInDatabase('invoice_line_items', ['service' => 'Software Development']);
    }

    /**
     * @test
     */
    public function totalHoursCanBeCalculated()
    {
        $client = $this->getClient(6);
        $this->dummy_item['hours'] = 22.5;
        $invoice = $this->createInvoiceWithLineItem($client, $this->dummy_item);

        $this->assertTrue($invoice->total_hours == 22.5);
    }

    /**
     * @test
     */
    public function outStandingTotalCanBeCalculated()
    {
        $amount = (22.5 * 75);
        $output = number_format($amount, 2, '.', ',');
        $client = $this->getClient(6);
        $this->dummy_item['hours'] = 22.5;
        $this->dummy_item['amount'] = $amount;
        $invoice = $this->createInvoiceForClient($client);
        if (!is_null($invoice)) {
            $this->dummy_item['invoice_id'] = $invoice->id;
            // Create line item with billable amount;
            InvoiceLineItem::create($this->dummy_item);
            //$this->assertTrue($invoice->outstanding_total == $output);
            $this->dummy_item['amount'] = $amount * -1;
            // Create line item with payment;
            InvoiceLineItem::create($this->dummy_item);
            $this->assertTrue($invoice->outstanding_total == 0);
        }
    }

    /**
     * @test
     */
    public function invoiceCanBeCreated()
    {
        $client = $this->getClient(7);
        if (!is_null($client)) {
            $this->createInvoiceForClient($client);
        }

        $this->seeInDatabase('invoices', ['id' => 1, 'billed_via_id' => 1, 'project' => 'CRM']);
    }


    /** PRIVATE METHODS **/

    private function createNewClient()
    {
        return factory(App\Models\Client::class)->create();

    }
    private function createInvoiceForClient($client)
    {
        $now = date('Y-m-d', time());
        return $client->invoices()->create([
            'project' => 'CRM',
            'invoice_date' => $now,
            'billed_date' => $now,
            'billed_via_id' => 1,
            'paid_date' => $now,
        ]);
    }

    private function createInvoiceWithLineItem($client, $dummy)
    {
        $invoice = $this->createInvoiceForClient($client);
        if (!is_null($invoice)) {
            $dummy['invoice_id'] = $invoice->id;
            InvoiceLineItem::create($dummy);
        }
        return $invoice;
    }

    private function getClient($client_id)
    {
        return Client::find($client_id)->get()->first();
    }
}
