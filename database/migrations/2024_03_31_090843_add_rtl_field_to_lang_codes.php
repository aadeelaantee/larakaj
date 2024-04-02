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
        Schema::table('lang_codes', function (Blueprint $table) {
            $table->boolean('rtl')->after('default')->default(0)->comment('Language is from right to left?');
        });

        DB::table('lang_codes')->insert([
            'name' => 'en',
            'rtl' => false,
            'default' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('lang_codes')->insert([
            'name' => 'fa',
            'rtl' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('lang_codes')->insert([
            'name' => 'es',
            'rtl' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lang_codes', function (Blueprint $table) {
            $table->dropColumn('rtl');
        });
    }
};
