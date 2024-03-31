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
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('password_hash', 'password');
            $table->timestamp('date_created')->change();
            
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();

            $table->renameColumn('date_created', 'created_at');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
            $table->renameColumn('created_at', 'date_created');
            $table->renameColumn('password', 'password_hash');

        });
    }
};
