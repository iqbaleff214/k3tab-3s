<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestToolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_tools', function (Blueprint $table) {
            $table->id();
            $table->integer('service_order')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('tool_id')->constrained('tools');
            $table->boolean('request_status')->default(0);
            // 0: Requested
            // 1: Borrowed
            // 2: Returned
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
        Schema::dropIfExists('request_tools');
    }
}
