<?php

use Illuminate\Database\Seeder;

class ControllerFunctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		
///////////////////////////////////////////	ADD  ADMINS FUNCTION////////////////////////////////////////////	
		$controller = App\ControllerName::where('name', 'UsersController')->firstOrFail();
		App\ControllerFunctionName::create([
				'name' => 'Show all Admins',
				'name_ar' => 'عرض كل الادمن',
				'func_name' => 'index',
				'controller_name_id'=> $controller->id
			]);
		App\ControllerFunctionName::create(	
			[
				'name' => 'Create Admin Page',
				'name_ar' => 'أضافة أدمن جديد',
				'func_name' => 'create',
				'controller_name_id' => $controller->id
			]);
		App\ControllerFunctionName::create(	
			[
				'name' => 'Edit Admin Page',
				'name_ar' => 'تعديل بيانات الادمن',
				'func_name' => 'edit',
				'controller_name_id' => $controller->id
				//'parent_function_id' =>App\ControllerFunctionName::where('name', 'Show all Admins')->firstOrFail()->id
			]);
		App\ControllerFunctionName::create(	
			[
				'name'=> 'Delete Admin',
				'name_ar' => 'حذف أدمن',
				'func_name' => 'destroy',
				'controller_name_id'=> $controller->id
				//'parent_function_id' =>App\ControllerFunctionName::where('name', 'Show all Admins')->firstOrFail()->id
			]
		);
		App\ControllerFunctionName::create([
				'name' => 'Save Admin',
				'func_name' => 'store',
				'controller_name_id' => $controller->id,
				'parent_function_id' =>App\ControllerFunctionName::where('name', 'Create Admin Page')->firstOrFail()->id
			]);
		App\ControllerFunctionName::create(	
			[
				'name' => 'update Admin',
				'func_name' => 'update',
				'controller_name_id' => $controller->id,
				'parent_function_id' =>App\ControllerFunctionName::where('name', 'Edit Admin Page')->firstOrFail()->id   
			]

		);
//////////////////////////////////////ADD TICKETS FUNCTIONs//////////////////////////////		
		$controller = App\ControllerName::where('name', 'TicketController')->firstOrFail();
		App\ControllerFunctionName::create([
				'name' => 'Show all Tickets',
				'name_ar' => 'عرض كل التيكتات',
				
				'func_name' => 'index',
				'controller_name_id'=> $controller->id
			]);
		App\ControllerFunctionName::create(	
			[
				'name' => 'Create Ticket Page',
				'name_ar' => 'أضافة تيكيت جديد',				
				'func_name' => 'create',
				'controller_name_id' => $controller->id
			]);
		App\ControllerFunctionName::create(	
			[
				'name' => 'Edit Ticket Page',
				'name_ar' => 'تعديل بيانات تيكيت',
				
				'func_name' => 'edit',
				'controller_name_id' => $controller->id
				// 'parent_function_id' =>App\ControllerFunctionName::where('name', 'Show all Tickets')->firstOrFail()->id
			]);
		App\ControllerFunctionName::create(	
			[
				'name'=> 'Delete Ticket',
				'name_ar' => 'حذف تيكيت',
				
				'func_name' => 'destroy',
				'controller_name_id'=> $controller->id
				//'parent_function_id' =>App\ControllerFunctionName::where('name', 'Show all Tickets')->firstOrFail()->id
			]
		);
		App\ControllerFunctionName::create([
				'name' => 'Save Ticket',
				'func_name' => 'store',
				'controller_name_id' => $controller->id,
				'parent_function_id' =>App\ControllerFunctionName::where('name', 'Create Ticket Page')->firstOrFail()->id
			]);
		App\ControllerFunctionName::create(	
			[
				'name' => 'update Ticket',
				'func_name' => 'update',
				'controller_name_id' => $controller->id,
				'parent_function_id' =>App\ControllerFunctionName::where('name', 'Edit Ticket Page')->firstOrFail()->id   
			]

		);
		App\ControllerFunctionName::create(	
			[
				'name'=> 'Close Ticket',
				'name_ar' => 'غلق تيكتات',				
				'func_name' => 'close',
				'controller_name_id'=> $controller->id
				//'parent_function_id' =>App\ControllerFunctionName::where('name', 'Show all Tickets')->firstOrFail()->id   				
			]
		);
		App\ControllerFunctionName::create(	
			[
				'name'=> 'Open Ticket',
				'name_ar' => 'فتح تيكتات',				
				'func_name' => 'open',
				'controller_name_id'=> $controller->id
				//'parent_function_id' =>App\ControllerFunctionName::where('name', 'Show all Tickets')->firstOrFail()->id   
			]
		);
		App\ControllerFunctionName::create(	
			[
				'name'=> 'Reopen Ticket',
				'name_ar' => 'أعادة فتح تيكتات',				
				'func_name' => 'reopen',
				'controller_name_id'=> $controller->id
				//'parent_function_id' =>App\ControllerFunctionName::where('name', 'Show all Tickets')->firstOrFail()->id   
			]
		);

//////////////////////////////////////ADD TICKETS FUNCTIONs//////////////////////////////		
		// $controller = App\ControllerName::where('name', 'FunctionSiteController')->firstOrFail();
		// App\ControllerFunctionName::create([
				// 'name' => 'show Functions',
				
				// 'func_name' => 'show',
				// 'controller_name_id'=> $controller->id
			// ]);
		// App\ControllerFunctionName::create(	
			// [
				// 'name' => 'Save Permission for  Functions',
				// 'func_name' => 'save',
				// 'controller_name_id' => $controller->id,
				// 'parent_function_id' =>App\ControllerFunctionName::where('name', 'show Functions')->firstOrFail()->id   
			// ]

		// );	

	
		
    }
}
