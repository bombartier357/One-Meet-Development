<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_schema', function($table){
			$table->increments('id');
			$table->string('email');
			$table->string('user');
			$table->string('sex');
			$table->string('password');
			$table->string('salt');
			$table->string('session_hash');
			$table->string('created_ip');
			$table->string('last_ip');
			$table->integer('chat_room');
			$table->integer('video_room');
			$table->integer('auto_mail');
			$table->integer('auto_chat');
			$table->integer('auto_video');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users_schema');
	}

}
