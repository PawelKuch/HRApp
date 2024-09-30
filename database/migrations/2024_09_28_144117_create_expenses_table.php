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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table -> string('expense_id');
            $table -> foreignId('user_id') -> constrained() -> onDelete('cascade');
            $table -> string('invoice_no');
            $table -> string('expense_category');
            $table -> float('expense_value');
            $table -> date('expense_date');
            $table -> string('expense_description');
            $table -> boolean('expense_status') -> default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
