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
        Schema::create('credit_cards', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name');
            $table->string('card_number', 8)->unique();
            $table->enum('card_type', ['Visa', 'AMEX']);
            $table->decimal('limit', 15, 2);
            $table->string('holder_dni');
            $table->string('holder_first_name');
            $table->string('holder_last_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_cards');
    }
};
