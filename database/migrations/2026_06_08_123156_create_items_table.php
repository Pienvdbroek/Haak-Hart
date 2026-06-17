<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    Schema::create('items', function (Blueprint $table) {
        $table->id();
    
        $table->string('item_name');
    
        $table->text('description')->nullable();
        $table->string('category')->nullable();
    
        $table->string('image')->nullable();
    
        // Inventory
        $table->unsignedInteger('quantity_total')->default(1);
        $table->unsignedInteger('quantity_available')->default(1);
    
        // Optional status field
        $table->string('status')->default('available');
    
        $table->string('video_link')->nullable();
    
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
