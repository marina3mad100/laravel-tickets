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
		////////////////////////////////////Add Roles //////////////////////////////////////
		$controller = App\ControllerName::where('name', 'RoleController')->firstOrFail();
		App\ControllerFunctionName::create([
				'name' => 'Show all Roles',
				'func_name' => 'index',
				'controller_name_id'=> $controller->id,
				
			]);
		App\ControllerFunctionName::create(	
			[
				'name' => 'Create Role Page',
				'func_name' => 'create',
				'controller_name_id' => $controller->id,
				
			]);
		App\ControllerFunctionName::create(	
			[
				'name' => 'Edit Role Page',
				'func_name' => 'edit',
				'controller_name_id' => $controller->id,
				//'parent_function_id' =>App\ControllerFunctionName::where('name', 'Show all Roles')->firstOrFail()->id
			]);
		App\ControllerFunctionName::create(	
			[
				'name'=> 'Delete Role',
				'func_name' => 'destroy',
				'controller_name_id'=> $controller->id,
				//'parent_function_id' =>App\ControllerFunctionName::where('name', 'Show all Roles')->firstOrFail()->id
			]
		);
		App\ControllerFunctionName::create([
				'name' => 'Save Role',
				'func_name' => 'store',
				'controller_name_id' => $controller->id,
				'parent_function_id' =>App\ControllerFunctionName::where('name', 'Create Role Page')->firstOrFail()->id
			]);
		App\ControllerFunctionName::create(	
			[
				'name' => 'update Role',
				'func_name' => 'update',
				'controller_name_id' => $controller->id,
				'parent_function_id' =>App\ControllerFunctionName::where('name', 'Edit Role Page')->firstOrFail()->id   
			]

		);	




///////////////////////////////////////////////ADD PERMISSION FUNCTION////////////////////////////////////////////////////		
		$controller = App\ControllerName::where('name', 'PermissionController')->firstOrFail();
		App\ControllerFunctionName::create([
				'name' => 'Show all Permissions',
				'func_name' => 'index',
				'controller_name_id'=> $controller->id
			]);
		App\ControllerFunctionName::create(	
			[
				'name' => 'Create Permission Page',
				'func_name' => 'create',
				'controller_name_id' => $controller->id
			]);
		App\ControllerFunctionName::create(	
			[
				'name' => 'Edit Permission Page',
				'func_name' => 'edit',
				'controller_name_id' => $controller->id
				//'parent_function_id' =>App\ControllerFunctionName::where('name', 'Show all Permissions')->firstOrFail()->id
			]);
		App\ControllerFunctionName::create(	
			[
				'name'=> 'Delete Permission',
				'func_name' => 'destroy',
				'controller_name_id'=> $controller->id
				//'parent_function_id' =>App\ControllerFunctionName::where('name', 'Show all Permissions')->firstOrFail()->id
			]
		);
		App\ControllerFunctionName::create([
				'name' => 'Save Permission',
				'func_name' => 'store',
				'controller_name_id' => $controller->id,
				'parent_function_id' =>App\ControllerFunctionName::where('name', 'Create Permission Page')->firstOrFail()->id
			]);
		App\ControllerFunctionName::create(	
			[
				'name' => 'update Permission',
				'func_name' => 'update',
				'controller_name_id' => $controller->id,
				'parent_function_id' =>App\ControllerFunctionName::where('name', 'Edit Permission Page')->firstOrFail()->id   
			]

		);



///////////////////////////////////////////	ADD  ADMINS FUNCTION////////////////////////////////////////////	
		$controller = App\ControllerName::where('name', 'UsersController')->firstOrFail();
		App\ControllerFunctionName::create([
				'name' => 'Show all Admins',
				'func_name' => 'index',
				'controller_name_id'=> $controller->id
			]);
		App\ControllerFunctionName::create(	
			[
				'name' => 'Create Admin Page',
				'func_name' => 'create',
				'controller_name_id' => $controller->id
			]);
		App\ControllerFunctionName::create(	
			[
				'name' => 'Edit Admin Page',
				'func_name' => 'edit',
				'controller_name_id' => $controller->id
				//'parent_function_id' =>App\ControllerFunctionName::where('name', 'Show all Admins')->firstOrFail()->id
			]);
		App\ControllerFunctionName::create(	
			[
				'name'=> 'Delete Admin',
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
				'func_name' => 'index',
				'controller_name_id'=> $controller->id
			]);
		App\ControllerFunctionName::create(	
			[
				'name' => 'Create Ticket Page',
				'func_name' => 'create',
				'controller_name_id' => $controller->id
			]);
		App\ControllerFunctionName::create(	
			[
				'name' => 'Edit Ticket Page',
				'func_name' => 'edit',
				'controller_name_id' => $controller->id
				// 'parent_function_id' =>App\ControllerFunctionName::where('name', 'Show all Tickets')->firstOrFail()->id
			]);
		App\ControllerFunctionName::create(	
			[
				'name'=> 'Delete Ticket',
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
				'func_name' => 'close',
				'controller_name_id'=> $controller->id
				//'parent_function_id' =>App\ControllerFunctionName::where('name', 'Show all Tickets')->firstOrFail()->id   				
			]
		);
		App\ControllerFunctionName::create(	
			[
				'name'=> 'Open Ticket',
				'func_name' => 'open',
				'controller_name_id'=> $controller->id
				//'parent_function_id' =>App\ControllerFunctionName::where('name', 'Show all Tickets')->firstOrFail()->id   
			]
		);
		App\ControllerFunctionName::create(	
			[
				'name'=> 'Reopen Ticket',
				'func_name' => 'reopen',
				'controller_name_id'=> $controller->id
				//'parent_function_id' =>App\ControllerFunctionName::where('name', 'Show all Tickets')->firstOrFail()->id   
			]
		);
		App\ControllerFunctionName::create(	
			[
				'name'=> 'Assign Ticket',
				'func_name' => 'assign',
				'controller_name_id'=> $controller->id
				//'parent_function_id' =>App\ControllerFunctionName::where('name', 'Show all Tickets')->firstOrFail()->id   				
			]
		);	
//////////////////////////////////////ADD TICKETS FUNCTIONs//////////////////////////////		
		$controller = App\ControllerName::where('name', 'FunctionSiteController')->firstOrFail();
		App\ControllerFunctionName::create([
				'name' => 'show Functions',
				'func_name' => 'show',
				'controller_name_id'=> $controller->id
			]);
		App\ControllerFunctionName::create(	
			[
				'name' => 'Save Permission for  Functions',
				'func_name' => 'save',
				'controller_name_id' => $controller->id,
				'parent_function_id' =>App\ControllerFunctionName::where('name', 'show Functions')->firstOrFail()->id   
			]

		);	

	
		
    }
}
