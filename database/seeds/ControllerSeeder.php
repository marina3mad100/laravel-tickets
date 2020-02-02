<?php

use Illuminate\Database\Seeder;

class ControllerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		\App\ControllerName::create(   
		   [
			'name'=> 'UsersController'
		   ]);
		\App\ControllerName::create(   
		   [
			'name'=> 'TicketController'
		   ]
	   );
	   
    }
}
