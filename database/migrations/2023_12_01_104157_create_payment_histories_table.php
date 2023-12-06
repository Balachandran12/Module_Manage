<?php

use App\Models\PaymentHistory;
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
        Schema::create('payment_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('module_management_id')->constrained('module_management')->cascadeOnDelete();
            $table->string('payment_id');
            $table->date('payment_date');
            $table->decimal('amount', 10, 2);
            $table->string('provider');
            $table->enum('method', PaymentHistory::PAYMENT_METHOD);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_histories');
    }
};
