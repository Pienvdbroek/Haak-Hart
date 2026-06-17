<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('items', 'type')) {
            Schema::table('items', function (Blueprint $table) {
                $table->string('type')->nullable()->after('item_name');
            });
        }

        if (!Schema::hasColumn('items', 'images')) {
            Schema::table('items', function (Blueprint $table) {
                $table->json('images')->nullable()->after('image');
            });
        }
    }

    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            if (Schema::hasColumn('items', 'images')) {
                $table->dropColumn('images');
            }

            if (Schema::hasColumn('items', 'type')) {
                $table->dropColumn('type');
            }
        });
    }
};
