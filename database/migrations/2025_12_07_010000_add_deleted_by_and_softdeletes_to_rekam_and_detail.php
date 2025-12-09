<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Rekam Medis: add deleted_at (soft deletes) and deleted_by if missing
        if (!Schema::hasColumn('rekam_medis', 'deleted_at') || !Schema::hasColumn('rekam_medis', 'deleted_by')) {
            Schema::table('rekam_medis', function (Blueprint $table) {
                if (!Schema::hasColumn('rekam_medis', 'deleted_at')) {
                    $table->softDeletes()->after('updated_at')->nullable();
                }
                if (!Schema::hasColumn('rekam_medis', 'deleted_by')) {
                    $table->unsignedBigInteger('deleted_by')->nullable()->after('deleted_at');
                }
            });
        }

        // Detail Rekam Medis: add deleted_at (soft deletes) and deleted_by if missing
        if (!Schema::hasColumn('detail_rekam_medis', 'deleted_at') || !Schema::hasColumn('detail_rekam_medis', 'deleted_by')) {
            Schema::table('detail_rekam_medis', function (Blueprint $table) {
                if (!Schema::hasColumn('detail_rekam_medis', 'deleted_at')) {
                    $table->softDeletes()->after('updated_at')->nullable();
                }
                if (!Schema::hasColumn('detail_rekam_medis', 'deleted_by')) {
                    $table->unsignedBigInteger('deleted_by')->nullable()->after('deleted_at');
                }
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('rekam_medis', 'deleted_by')) {
            Schema::table('rekam_medis', function (Blueprint $table) {
                $table->dropColumn('deleted_by');
            });
        }

        if (Schema::hasColumn('rekam_medis', 'deleted_at')) {
            Schema::table('rekam_medis', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }

        if (Schema::hasColumn('detail_rekam_medis', 'deleted_by')) {
            Schema::table('detail_rekam_medis', function (Blueprint $table) {
                $table->dropColumn('deleted_by');
            });
        }

        if (Schema::hasColumn('detail_rekam_medis', 'deleted_at')) {
            Schema::table('detail_rekam_medis', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
    }
};
