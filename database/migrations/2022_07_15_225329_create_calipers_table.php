<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalipersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calipers', function (Blueprint $table) {
            $table->id();
            $table->string('part_number');
            $table->string('family');
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
        Schema::dropIfExists('calipers');
    }
}
