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
        Schema::table('property_listings', function (Blueprint $table) {
            $table->boolean('relevant')->after('uri');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_listings', function (Blueprint $table) {
            $table->dropColumn('relevant');
        });
    }
};
