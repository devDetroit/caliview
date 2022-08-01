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
            $table->string('jh_part_number')->unique();
            $table->string('cardone_part_number')->unique();
            $table->string('centric_part_number')->unique();
            $table->foreignId('family_id')->nullOnDelete()->constrained('caliper_families');
            $table->string('casting1');
            $table->string('casting2');
            $table->string('bracket_casting');
            $table->timestamps();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');
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
