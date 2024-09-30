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
        Schema::table('expenses', function (Blueprint $table) {
            $table -> renameColumn('expense_date', 'date');
            $table -> renameColumn('expense_category', 'category');
            $table -> renameColumn('expense_value', 'value');
            $table -> renameColumn('expense_description', 'description');
            $table -> renameColumn('expense_status', 'status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table -> renameColumn('date', 'expense_date');
            $table -> renameColumn('category', 'expense_category');
            $table -> renameColumn('value', 'expense_value');
            $table -> renameColumn('description', 'expense_description');
            $table -> renameColumn('status', 'expense_status');
        });
    }
};
