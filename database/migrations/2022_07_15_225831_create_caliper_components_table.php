<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaliperComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caliper_components', function (Blueprint $table) {
            $table->foreignid('caliper_id')->constrained();
            $table->foreignId('component_id')->constrained();
            $table->integer('quantity');
            $table->timestamps();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('update_by')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('caliper_components');
    }
}
