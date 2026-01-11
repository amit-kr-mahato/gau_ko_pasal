<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('store_settings', function (Blueprint $table) {
            $table->id();
            $table->string('store_name')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('currency')->default('USD');
            $table->string('timezone')->nullable();

            // Notification toggles
            $table->boolean('notify_new_order')->default(false);
            $table->boolean('notify_user_registration')->default(false);
            $table->boolean('notify_stock_alert')->default(false);

            // SEO & Social
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->boolean('maintenance_mode')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('store_settings');
    }
};
