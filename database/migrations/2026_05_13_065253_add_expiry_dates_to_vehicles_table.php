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
        Schema::table('vehicles', function (Blueprint $table) {
            if (!Schema::hasColumn('vehicles', 'insurance_expiry')) {
                $table->date('insurance_expiry')->nullable();
            }
            if (!Schema::hasColumn('vehicles', 'permit_expiry')) {
                $table->date('permit_expiry')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            if (Schema::hasColumn('vehicles', 'permit_expiry')) {
                $table->dropColumn('permit_expiry');
            }
        });
    }
};
