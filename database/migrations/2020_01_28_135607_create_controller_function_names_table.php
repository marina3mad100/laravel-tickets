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
			$table->integer('controller_name_id');
			$table->integer('parent_function_id')->default(0);
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
        Schema::dropIfExists('controller_function_names');
    }
}
