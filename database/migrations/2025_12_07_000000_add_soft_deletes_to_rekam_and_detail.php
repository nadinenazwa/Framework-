<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('rekam_medis', 'deleted_at')) {
            Schema::table('rekam_medis', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        if (!Schema::hasColumn('detail_rekam_medis', 'deleted_at')) {
            Schema::table('detail_rekam_medis', function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('rekam_medis', 'deleted_at')) {
            Schema::table('rekam_medis', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }

        if (Schema::hasColumn('detail_rekam_medis', 'deleted_at')) {
            Schema::table('detail_rekam_medis', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
    }
};
