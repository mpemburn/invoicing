<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvoicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invoices', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('project', 25)->nullable();
			$table->integer('client_id')->nullable()->default(0)->index('client_id_fk');
			$table->date('invoice_date')->nullable();
			$table->date('billed_date')->nullable();
			$table->string('billed_via', 50)->nullable();
			$table->integer('billed_via_id')->index('billed_via_fk');
			$table->decimal('invoice_total', 19, 4)->nullable()->default(0.0000);
			$table->decimal('paid_amount', 19, 4)->nullable()->default(0.0000);
			$table->date('paid_date')->nullable();
			$table->float('total_hours', 10, 0)->nullable()->default(0);
			$table->integer('billing_rate')->nullable()->default(0);
			$table->boolean('written_off')->nullable()->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('invoices');
	}

}
