<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Eski tekil alanı kaldırıp yerine 5 platformu ekliyoruz
            if (Schema::hasColumn('products', 'affiliate_url')) {
                $table->dropColumn('affiliate_url');
            }
            $table->string('trendyol_url')->nullable()->after('stock');
            $table->string('hepsiburada_url')->nullable()->after('trendyol_url');
            // $table->string('idefix_url')->nullable()->after('hepsiburada_url');
            // $table->string('amazon_url')->nullable()->after('idefix_url');
            // $table->string('pazarama_url')->nullable()->after('amazon_url');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['trendyol_url', 'hepsiburada_url']);
            // $table->dropColumn(['trendyol_url', 'hepsiburada_url', 'idefix_url', 'amazon_url', 'pazarama_url']);
            $table->string('affiliate_url')->nullable();
        });
    }
};