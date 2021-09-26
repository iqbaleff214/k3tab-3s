<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tools', function (Blueprint $table) {
            $table->id();
            $table->integer('equipment_number')->unique();
            $table->integer('tech_ident_number')->nullable();
            $table->string('business_area')->nullable();
            $table->string('maintenance_plant')->nullable();
            $table->string('material')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('description')->nullable();
            $table->string('additional_description')->nullable();
            $table->string('size')->nullable();
            $table->string('manufacture_serial_number')->nullable();
            $table->string('asset')->nullable();
            $table->string('location')->nullable();
            $table->string('license_number')->nullable();
            $table->string('system_status')->nullable()->default('AVLB');
            $table->string('user_status')->nullable();
            $table->string('sort_field')->nullable();
            $table->string('equipment_category')->nullable()->default('T');
            $table->string('currency')->nullable()->default('USD');
            $table->float('acquisition_value')->nullable()->default(0.0);
            $table->dateTime('startup_date')->nullable()->useCurrent();
            $table->string('changed_by')->nullable();
            $table->string('created_by')->nullable();
            $table->char('abc_indicator')->nullable();
            $table->dateTime('acquisition_date')->nullable()->useCurrent();
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
        Schema::dropIfExists('tools');
    }
}
