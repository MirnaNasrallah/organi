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
        Schema::table('plan_days', function (Blueprint $table) {
            $table->decimal('total_carbs', 8, 2)->default(0)->after('total_protein');
            $table->decimal('total_fat', 8, 2)->default(0)->after('total_carbs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plan_days', function (Blueprint $table) {
            $table->dropColumn(['total_carbs', 'total_fat']);
        });
    }
};
