<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTransactionTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transaction_types', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('description', 50)->nullable();
			$table->boolean('is_expense')->nullable();
			$table->boolean('is_invoice')->nullable();
			$table->boolean('is_positive')->nullable();
			$table->string('js_function', 100)->nullable();
			$table->string('required_controls', 100)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('transaction_types');
	}

}
