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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('external_invoice_id')->nullable();

            // Customer (after NFC claim)
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->foreignId('store_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->string('store_name')->nullable();
            $table->foreignId('branch_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->timestamp('pos_timestamp')->nullable();
            $table->decimal('subtotal', 12, 2);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('total', 12, 2);
            $table->string('payment_method')->nullable();
            $table->string('currency', 3)->nullable()->default('EUR');
            $table->enum('status', ['pending', 'send', 'registered', 'cancelled'])
                ->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
