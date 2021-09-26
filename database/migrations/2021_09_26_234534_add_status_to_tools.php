<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToTools extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tools', function (Blueprint $table) {
            $table->boolean('equipment_status')->default(1);
            // 0: Not Available (Broken, Maintenance, Someone has brought it, etc.)
            // 1: Available
            // 2: Someone has requested it
            $table->string('equipment_note')->nullable();
            // What
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tools', function (Blueprint $table) {
            $table->dropColumn(['equipment_status', 'equipment_note']);
        });
    }
}
