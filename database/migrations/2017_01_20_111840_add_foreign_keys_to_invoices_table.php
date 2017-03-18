<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToInvoicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('invoices', function(Blueprint $table)
		{
			$table->foreign('billed_via_id', 'fk_invoices_billed_via_id')->references('id')->on('billed_via')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('client_id', 'fk_invoices_client_id')->references('id')->on('clients')->onUpdate('CASCADE')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('invoices', function(Blueprint $table)
		{
			$table->dropForeign('fk_invoices_billed_via_id');
			$table->dropForeign('fk_invoices_client_id');
		});
	}

}
