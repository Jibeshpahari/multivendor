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
        Schema::create('vendor_profiles', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();

            $table->string('store_name');
            $table->string('store_slug')->unique();
            $table->string('store_logo')->nullable();

            $table->string('contact_role', 100)->nullable();
            $table->string('store_email')->nullable();
            $table->string('store_phone', 30)->nullable();
            $table->string('alt_phone', 30)->nullable();
            $table->string('whatsapp_number', 30)->nullable();

            $table->string('address_line')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->char('country', 2)->nullable();

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->boolean('is_active')->default(true);

            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();

            $table->unsignedInteger('total_orders')->default(0);
            $table->decimal('total_revenue', 12, 2)->default(0.00);

            $table->timestamps();
            $table->softDeletes();

            $table->index('store_name');
            $table->index(['status', 'created_at']);
            $table->index(['status', 'store_name']);
            $table->index('approved_by');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_profiles');
    }
};
