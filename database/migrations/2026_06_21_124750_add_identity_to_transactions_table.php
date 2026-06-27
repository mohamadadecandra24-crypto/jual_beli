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
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('cashier_name')->nullable()->after('user_id');
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('cashier_nip')->nullable()->after('cashier_name');
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('supervisor_name')->nullable()->after('cashier_nip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['cashier_name', 'cashier_nip', 'supervisor_name']);
        });
    }
};
