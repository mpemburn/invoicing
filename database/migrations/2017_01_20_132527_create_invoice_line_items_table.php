<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvoiceLineItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invoice_line_items', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('invoice_id')->nullable()->default(0)->index('InvoiceID');
			$table->smallInteger('item_number')->nullable()->default(0);
			$table->string('service')->nullable();
			$table->integer('service_type')->nullable();
			$table->integer('billing_rate_id');
			$table->text('description')->nullable();
			$table->float('hours', 10, 0)->nullable()->default(0);
			$table->decimal('amount', 19, 4)->nullable()->default(0.0000);
			$table->string('check_number', 10)->nullable();
			$table->decimal('check_amount', 10)->nullable();
			$table->date('payment_date')->nullable();
			$table->decimal('balance_forward', 10)->nullable();
			$table->integer('forward_to_invoice')->nullable();
			$table->integer('transaction_type')->nullable()->default(0)->index('fk_transaction_types_transaction_type');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('invoice_line_items');
	}

}
