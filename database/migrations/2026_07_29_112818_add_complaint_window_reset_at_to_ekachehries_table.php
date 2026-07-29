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
        Schema::table('ekachehris', function (Blueprint $table) {
             $table->timestamp('complaint_window_reset_at')->nullable()->after('dfp_ids');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ekachehris', function (Blueprint $table) {
            //
        });
    }
};
