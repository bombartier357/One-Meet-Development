<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::table('users_schema')->insert(array(
			'user'=>'Kyle_Austin',
			'email'=>'kyle.emmet.austin@gmail.com',
			'sex'=>'Male',
			'password'=>'$2y$10$d8FPAHuD8EyNQNHWoHvatOwmOw/U.GD1rThRxHEA7OqgYhpK6KKJ.',
			'created_at'=>date('Y-m-d H:m:s'),
			'updated_at'=>date('Y-m-d H:m:s')
			
		));
		
		DB::table('users_schema')->insert(array(
			'user'=>'Tom_Hanks',
			'email'=>'thanks@gmail.com',
			'sex'=>'Male',
			'password'=>'$2y$10$oNzDEANjpdvn6MejoJo1VeIBeTHVG0QJ8LJgIkB/AUdU4T.Y6dyWu',
			'created_at'=>date('Y-m-d H:m:s'),
			'updated_at'=>date('Y-m-d H:m:s')
			
		));
		
		DB::table('users_schema')->insert(array(
			'user'=>'Brittany_Spears',
			'email'=>'bspears@gmail.com',
			'sex'=>'Female',
			'password'=>'$2y$10$PJrcvWUZGZ3Cxu.NE126EO5D3rfY6temVY3jeK2imX9AywvpeDEku',
			'created_at'=>date('Y-m-d H:m:s'),
			'updated_at'=>date('Y-m-d H:m:s')
			
		));
		
		DB::table('users_schema')->insert(array(
			'user'=>'Hillary_Clinton',
			'email'=>'hclint@gmail.com',
			'sex'=>'Female',
			'password'=>'$2y$10$aJxulygjQfT.cmNQnM/x2uuPmvuThhqD3fROn19QR5p46a5fKldhG',
			'created_at'=>date('Y-m-d H:m:s'),
			'updated_at'=>date('Y-m-d H:m:s')
			
		));
		
		DB::table('users_schema')->insert(array(
			'user'=>'gazelleboy',
			'email'=>'gazelleboy@gmail.com',
			'sex'=>'Male',
			'password'=>'$2y$10$jWJK6NOFakNmZSE1z5Thl.O6WWhbIRMZFI1GXgEon0/oMamMoN.Ga',
			'created_at'=>date('Y-m-d H:m:s'),
			'updated_at'=>date('Y-m-d H:m:s')
			
		));
		
		DB::table('users_schema')->insert(array(
			'user'=>'brown23',
			'email'=>'peshplaya@yahoo.com',
			'sex'=>'Male',
			'password'=>'$2y$10$MKxyrQkIqTerHduL7nzeAu0k3FfuxKAb7F/KQ7TEa7SS.tf0h.gEy',
			'created_at'=>date('Y-m-d H:m:s'),
			'updated_at'=>date('Y-m-d H:m:s')
			
		));
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::table('users_schema')->where('user', '=', 'Nihithilak')->delete();
		DB::table('users_schema')->where('user', '=', 'Tom_Hanks')->delete();
		DB::table('users_schema')->where('user', '=', 'Brittany_Spears')->delete();
		DB::table('users_schema')->where('user', '=', 'Hillary_Clinton')->delete();
		DB::table('users_schema')->where('user', '=', 'gazelleboy')->delete();
		DB::table('users_schema')->where('user', '=', 'brown23')->delete();
	}

}
