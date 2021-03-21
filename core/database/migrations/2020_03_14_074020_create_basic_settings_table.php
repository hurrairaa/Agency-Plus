<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBasicSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('basic_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('language_id')->nullable();
            $table->string('favicon', 50)->nullable();
            $table->string('logo', 50)->nullable();
            $table->string('contact_mail', 255)->nullable();
            $table->string('base_color', 30)->nullable();
            $table->string('secondary_base_color', 20)->nullable();
            $table->string('support_email', 100)->nullable();
            $table->string('support_phone', 30)->nullable();
            $table->string('breadcrumb', 50)->nullable();
            $table->string('footer_logo', 50)->nullable();
            $table->string('footer_text', 255)->nullable();
            $table->string('newsletter_text', 255)->nullable();
            $table->binary('copyright_text')->nullable();
            $table->string('hero_bg', 50)->nullable();
            $table->string('hero_section_title', 255)->nullable();
            $table->string('hero_section_text', 255)->nullable();
            $table->string('hero_section_button_text', 255)->nullable();
            $table->string('hero_section_button_url', 255)->nullable();
            $table->string('hero_section_video_link', 255)->nullable();
            $table->string('intro_bg', 50)->nullable();
            $table->string('intro_section_title', 50)->nullable();
            $table->string('intro_section_text', 255)->nullable();
            $table->string('intro_section_button_text', 255)->nullable();
            $table->string('intro_section_button_url', 255)->nullable();
            $table->text('intro_section_video_link')->nullable();
            $table->string('service_section_title', 255)->nullable();
            $table->string('service_section_subtitle', 255)->nullable();
            $table->string('approach_title', 255)->nullable();
            $table->string('approach_subtitle', 255)->nullable();
            $table->string('approach_button_text', 255)->nullable();
            $table->string('approach_button_url', 255)->nullable();
            $table->string('cta_bg', 50)->nullable();
            $table->string('cta_section_text', 255)->nullable();
            $table->string('cta_section_button_text', 255)->nullable();
            $table->string('cta_section_button_url', 255)->nullable();
            $table->string('portfolio_section_title', 255)->nullable();
            $table->string('portfolio_section_text', 255)->nullable();
            $table->string('team_bg', 50)->nullable();
            $table->string('team_section_title', 255)->nullable();
            $table->string('team_section_subtitle', 255)->nullable();
            $table->string('contact_form_title', 255)->nullable();
            $table->string('contact_form_subtitle', 255)->nullable();
            $table->string('quote_title', 255)->nullable();
            $table->string('quote_subtitle', 255)->nullable();
            $table->string('contact_address', 255)->nullable();
            $table->string('contact_number', 255)->nullable();
            $table->string('latitude', 255)->nullable();
            $table->string('longitude', 255)->nullable();
            $table->text('tawk_to_script')->nullable();
            $table->text('google_analytics_script')->nullable();
            $table->tinyInteger('is_recaptcha')->default(0);
            $table->string('google_recaptcha_site_key', 255)->nullable();
            $table->string('google_recaptcha_secret_key', 255)->nullable();
            $table->tinyInteger('is_tawkto')->default(1);
            $table->tinyInteger('is_disqus')->default(1);
            $table->text('disqus_script')->nullable();
            $table->tinyInteger('is_analytics')->default(1);
            $table->tinyInteger('maintainance_mode')->default(0)->comment('1 - active, 0 - deactive');
            $table->text('maintainance_text')->nullable();
            $table->string('announcement', 50)->nullable();
            $table->tinyInteger('is_announcement')->default(1)->comment('0 - deactive, 1 - active');
            $table->decimal('announcement_delay', 11, 2)->default(0.00);
            $table->tinyInteger('is_appzi')->default(0)->comment('0 - deactive, 1 - active');
            $table->text('appzi_script')->nullable();
            $table->tinyInteger('is_addthis')->default(0)->comment('0 - deactive, 1 - active');
            $table->text('addthis_script')->nullable();
            $table->string('service_title', 30)->nullable();
            $table->string('service_subtitle', 255)->nullable();
            $table->string('portfolio_title', 30)->nullable();
            $table->string('portfolio_subtitle', 255)->nullable();
            $table->string('testimonial_title', 255)->nullable();
            $table->string('testimonial_subtitle', 255)->nullable();
            $table->string('blog_section_title', 255)->nullable();
            $table->string('blog_section_subtitle', 255)->nullable();
            $table->string('faq_title', 255)->nullable();
            $table->string('faq_subtitle', 255)->nullable();
            $table->string('blog_title', 255)->nullable();
            $table->string('blog_subtitle', 255)->nullable();
            $table->string('service_details_title', 255)->nullable();
            $table->string('portfolio_details_title', 255)->nullable();
            $table->string('blog_details_title', 255)->nullable();
            $table->string('gallery_title', 255)->nullable();
            $table->string('gallery_subtitle', 255)->nullable();
            $table->string('team_title', 255)->nullable();
            $table->string('team_subtitle', 255)->nullable();
            $table->string('contact_title', 255)->nullable();
            $table->string('contact_subtitle', 255)->nullable();
            $table->string('error_title', 255)->nullable();
            $table->string('error_subtitle', 255)->nullable();
            $table->string('parent_link_name', 255)->nullable();
            $table->string('home_version', 30)->nullable();
            $table->tinyInteger('is_service')->default(1);
            $table->tinyInteger('is_portfolio')->default(1);
            $table->tinyInteger('is_team')->default(1);
            $table->tinyInteger('is_gallery')->default(1);
            $table->tinyInteger('is_faq')->default(1);
            $table->tinyInteger('is_blog')->default(1);
            $table->tinyInteger('is_contact')->default(1);
            $table->tinyInteger('is_quote')->default(1);
            $table->tinyInteger('feature_section')->default(1);
            $table->tinyInteger('intro_section')->default(1);
            $table->tinyInteger('service_section')->default(1);
            $table->tinyInteger('approach_section')->default(1);
            $table->tinyInteger('statistics_section')->default(1);
            $table->tinyInteger('portfolio_section')->default(1);
            $table->tinyInteger('testimonial_section')->default(1);
            $table->tinyInteger('team_section')->default(1);
            $table->tinyInteger('news_section')->default(1);
            $table->tinyInteger('call_to_action_section')->default(1);
            $table->tinyInteger('partner_section')->default(1);
            $table->tinyInteger('top_footer_section')->default(1);
            $table->tinyInteger('copyright_section')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('basic_settings');
    }
}
