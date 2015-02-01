<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('images_schema', function($table){
			$table->increments('id');
			$table->integer('owner');
			$table->string('filename');
			$table->timestamps();
			$table->integer('x_coords');
			$table->integer('y_coords');
			$table->integer('w_coords');
			$table->integer('h_coords');
			$table->integer('init_height');
			$table->integer('init_width');
			$table->integer('order_img');
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('images_schema');
	}

}
