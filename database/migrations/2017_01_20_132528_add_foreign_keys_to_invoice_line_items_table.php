<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToInvoiceLineItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('invoice_line_items', function(Blueprint $table)
		{
			$table->foreign('invoice_id', 'fk_invoices_invoice_id')->references('id')->on('invoices')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('transaction_type', 'fk_transaction_types_transaction_type')->references('id')->on('transaction_types')->onUpdate('CASCADE')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('invoice_line_items', function(Blueprint $table)
		{
			$table->dropForeign('fk_invoices_invoice_id');
			$table->dropForeign('fk_transaction_types_transaction_type');
		});
	}

}
