<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'site_name', 'logo', 'phone', 'email', 'address', 'whatsapp',
        'twitter', 'instagram', 'snapchat', 'facebook',
        'work_hours_weekdays', 'work_hours_friday', 'footer_description',
        'recaptcha_site_key', 'recaptcha_secret_key', 'recaptcha_enabled_contact', 'recaptcha_enabled_booking',
        'google_maps_iframe',
        'meta_title', 'meta_description', 'meta_keywords', 'og_image',
        'seo_robots', 'og_title', 'og_description', 'og_type',
        'twitter_card', 'twitter_site', 'twitter_creator', 'twitter_title', 'twitter_description', 'twitter_image',
        'facebook_app_id'
    ];
}
