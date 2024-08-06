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
        Schema::create('selling_goods', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->integer('item_category_id');
            $table->integer('tenant_id');
            $table->integer('photo_id')->nullable();
            $table->string('name');
            $table->string('code')->nullable();
            $table->double('price');
            $table->integer('available_stock');
            $table->text('description')->nullable();
            $table->integer('is_active')->default(1);
            $table->integer('version')->default(0);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->integer('created_at')->nullable();
            $table->integer('updated_at')->nullable();
            $table->integer('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selling_goods');
    }
};
