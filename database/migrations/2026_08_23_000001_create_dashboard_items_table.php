<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dashboard_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category')->default('General');
            $table->string('status')->default('Pending'); // Pending, In Progress, Completed, Operational
            $table->integer('metric_value')->default(100);
            $table->text('description')->nullable();
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
        Schema::dropIfExists('dashboard_items');
    }
};
