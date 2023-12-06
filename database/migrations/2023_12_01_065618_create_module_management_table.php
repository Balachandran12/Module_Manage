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
        Schema::create('module_management', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modules_id')->constrained('modules')->cascadeOnDelete();
            $table->string('version');
            $table->foreignId('base_versions_id')->constrained('base_versions')->cascadeOnDelete();
            $table->date('released_date');
            $table->text('change_log');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_management');
    }
};
