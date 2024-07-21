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
        Schema::table('kuisioner', function (Blueprint $table) {
            $table->unsignedBigInteger('id_detail_perwalian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kuisioner', function (Blueprint $table) {
            $table->dropColumn('id_detail_perwalian');
        });
    }
};
