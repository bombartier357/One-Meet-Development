<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMail extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mail_schema', function($table){
			$table->increments('id');
			$table->integer('sender_id');
			$table->integer('receiver_id');
			$table->string('subject');
			$table->longText('text');
			$table->timestamps();
			$table->integer('has_seen');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('mail_schema');
	}

}
