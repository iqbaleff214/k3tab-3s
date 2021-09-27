<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestConsumablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_consumables', function (Blueprint $table) {
            $table->id();
            $table->integer('service_order')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('consumable_id')->constrained('consumables');
            $table->integer('requested_quantity');
            $table->integer('accepted_quantity')->nullable();
            $table->boolean('request_status')->default(0);
            // 0: Requested
            // 1: Accepted
            // 2: -
            // 3: Rejected
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
        Schema::dropIfExists('request_consumables');
    }
}
