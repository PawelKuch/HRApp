<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if(DB::table('users')->count() == 0){
            DB::table('users')->insert([
                'name' => 'admin',
                'surname' => 'admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin'),
                'role' => 'admin',
                'userId' => Str::uuid() -> toString(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users') -> where('email', '=', 'admin@admin.com') -> delete();
    }
};
