<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateControllerFunctionNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('controller_function_names', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('name')->unique();
			$table->string('name_ar')->unique()->nullable();
			$table->string('func_name');
			$table->integer('controller_name_id');
			$table->integer('parent_function_id')->default(0);
            $table->timestamps();
        });
	////////////////////////////add Admins Functions ////////////////////////////////////		
		$user_controller = DB::table('controller_names')->where('name', 'UsersController')->first();
		DB::table('controller_function_names')->insert([
			'name' => 'Show all Admins',
			'name_ar' => 'عرض كل الادمن',
			'func_name' => 'index',
			'controller_name_id'=> $user_controller->id
		]);
		DB::table('controller_function_names')->insert([	
			'name' => 'Create Admin Page',
			'name_ar' => 'أضافة أدمن جديد',
			'func_name' => 'create',
			'controller_name_id' => $user_controller->id
		]);
		DB::table('controller_function_names')->insert([
			'name' => 'Edit Admin Page',
			'name_ar' => 'تعديل بيانات الادمن',
			'func_name' => 'edit',
			'controller_name_id' => $user_controller->id
		]);
		DB::table('controller_function_names')->insert([
			'name'=> 'Delete Admin',
			'name_ar' => 'حذف أدمن',
			'func_name' => 'destroy',
			'controller_name_id'=> $user_controller->id
		]);		
		DB::table('controller_function_names')->insert([
		'name' => 'Save Admin',
			'func_name' => 'store',
			'controller_name_id' => $user_controller->id,
			'parent_function_id' =>DB::table('controller_function_names')->where('name', 'Create Admin Page')->first()->id
		]);	
		DB::table('controller_function_names')->insert([
			'name' => 'update Admin',
			'func_name' => 'update',
			'controller_name_id' => $user_controller->id,
			'parent_function_id' =>DB::table('controller_function_names')->where('name', 'Edit Admin Page')->first()->id   
		]);				
	////////////////////////////add Ticket Functions ////////////////////////////////////
	$ticket_controller = DB::table('controller_names')->where('name', 'TicketController')->first();
		DB::table('controller_function_names')->insert([
			'name' => 'Show all Tickets',
			'name_ar' => 'عرض كل التيكتات',
			'func_name' => 'index',
			'controller_name_id'=> $ticket_controller->id
		]);
		DB::table('controller_function_names')->insert([	
			'name' => 'Create Ticket Page',
			'name_ar' => 'أضافة تيكيت جديد',
			'func_name' => 'create',
			'controller_name_id' => $ticket_controller->id
		]);
		DB::table('controller_function_names')->insert([
			'name' => 'Edit Ticket Page',
			'name_ar' => 'تعديل بيانات تيكيت',
			'func_name' => 'edit',
			'controller_name_id' => $ticket_controller->id
		]);
		DB::table('controller_function_names')->insert([
			'name'=> 'Delete Ticket',
			'name_ar' => 'حذف تيكيت',
			'func_name' => 'destroy',
			'controller_name_id'=> $ticket_controller->id
		]);		
		DB::table('controller_function_names')->insert([
			'name'=> 'Close Ticket',
			'name_ar' => 'غلق تيكتات',				
			'func_name' => 'close',
			'controller_name_id'=> $ticket_controller->id
		]);	
		DB::table('controller_function_names')->insert([
			'name'=> 'Open Ticket',
			'name_ar' => 'فتح تيكتات',				
			'func_name' => 'open',
			'controller_name_id'=> $ticket_controller->id
		]);	
		DB::table('controller_function_names')->insert([
			'name'=> 'Reopen Ticket',
			'name_ar' => 'أعادة فتح تيكتات',				
			'func_name' => 'reopen',
			'controller_name_id'=> $ticket_controller->id
		]);			
		DB::table('controller_function_names')->insert([
			'name' => 'Save Ticket',
			'func_name' => 'store',
			'controller_name_id' => $ticket_controller->id,
			'parent_function_id' =>DB::table('controller_function_names')->where('name', 'Create Ticket Page')->first()->id
		]);	
		DB::table('controller_function_names')->insert([
			'name' => 'update Ticket',
			'func_name' => 'update',
			'controller_name_id' => $ticket_controller->id,
			'parent_function_id' =>DB::table('controller_function_names')->where('name', 'Edit Ticket Page')->first()->id   
		]);	


	
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('controller_function_names');
    }
}
