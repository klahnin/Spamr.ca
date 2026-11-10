<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('funnel_domains', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->index();
            $table->string('hostname', 253);
            $table->string('verification_token', 80);
            $table->string('verification_method', 20)->default('dns_txt');
            $table->timestamp('verified_at')->nullable()->index();
            $table->timestamps();
            $table->unique(['user_id', 'hostname']);
        });

        Schema::create('funnels', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->index();
            $table->unsignedBigInteger('funnel_domain_id')->index();
            $table->string('public_id', 48)->unique();
            $table->string('name', 120);
            $table->string('landing_url', 2048);
            $table->string('goal_type', 30)->default('lead');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('funnel_links', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->index();
            $table->unsignedBigInteger('funnel_id')->index();
            $table->unsignedInteger('campaign_id')->nullable()->index();
            $table->string('label', 120);
            $table->string('token_hash', 64)->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('funnel_click_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('funnel_link_id')->index();
            $table->char('recipient_hash', 64)->nullable()->index();
            $table->char('visitor_hash', 64)->nullable()->index();
            $table->timestamp('clicked_at')->index();
            $table->timestamps();
        });

        Schema::create('funnel_page_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('funnel_id')->index();
            $table->unsignedBigInteger('funnel_link_id')->nullable()->index();
            $table->char('visitor_hash', 64)->nullable()->index();
            $table->string('event_type', 30);
            $table->unsignedSmallInteger('scroll_depth')->nullable();
            $table->timestamp('occurred_at')->index();
            $table->timestamps();
        });

        Schema::create('funnel_lead_submissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->index();
            $table->unsignedBigInteger('funnel_id')->index();
            $table->unsignedBigInteger('funnel_link_id')->nullable()->index();
            $table->unsignedInteger('campaign_id')->nullable()->index();
            $table->char('recipient_hash', 64)->nullable()->index();
            $table->json('fields');
            $table->string('status', 20)->default('new')->index();
            $table->timestamp('submitted_at')->index();
            $table->timestamps();
        });

        Schema::table('campaigns', function (Blueprint $table) {
            $table->unsignedBigInteger('funnel_id')->nullable()->index();
        });
    }

    public function down(): void
    {
        Schema::table('campaigns', fn (Blueprint $table) => $table->dropColumn('funnel_id'));
        Schema::dropIfExists('funnel_lead_submissions');
        Schema::dropIfExists('funnel_page_events');
        Schema::dropIfExists('funnel_click_events');
        Schema::dropIfExists('funnel_links');
        Schema::dropIfExists('funnels');
        Schema::dropIfExists('funnel_domains');
    }
};
