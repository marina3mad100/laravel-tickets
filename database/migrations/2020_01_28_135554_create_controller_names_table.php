<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateControllerNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('controller_names', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('name')->unique();
            $table->timestamps();
        });
        DB::table('controller_names')->insert([
            ['name' => 'UsersController'],
			['name' => 'TicketController']
        ]);						
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('controller_names');
    }
}
