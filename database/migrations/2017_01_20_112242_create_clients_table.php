<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clients', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->smallInteger('category')->nullable()->default(0);
			$table->string('last_name')->nullable()->index('LastName');
			$table->string('middle_name', 50)->nullable();
			$table->string('first_name')->nullable();
			$table->string('attn', 50)->nullable();
			$table->string('title', 30)->nullable();
			$table->string('suffix', 30)->nullable();
			$table->string('company')->nullable();
			$table->smallInteger('primary_phone')->nullable()->default(0);
			$table->string('work_phone')->nullable();
			$table->string('home_phone')->nullable();
			$table->string('mobile_phone', 50)->nullable();
			$table->string('other_phone')->nullable();
			$table->string('fax_phone')->nullable();
			$table->string('email_address')->nullable();
			$table->string('address_1')->nullable();
			$table->string('address_2', 50)->nullable();
			$table->string('city')->nullable();
			$table->string('state')->nullable();
			$table->string('zip')->nullable();
			$table->smallInteger('billing_rate')->nullable()->default(55);
			$table->boolean('use_contact_name')->nullable()->default(-1);
			$table->boolean('use_care_of')->nullable()->default(0);
			$table->boolean('use_attn')->nullable()->default(0);
			$table->boolean('use_attn_as_second_name')->nullable();
			$table->boolean('include_in_merge')->nullable();
			$table->integer('referral_id')->nullable()->default(0)->index('ReferralID');
			$table->string('referral_detail', 50)->nullable();
			$table->string('soundex', 5)->nullable();
			$table->text('notes')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('clients');
	}

}
