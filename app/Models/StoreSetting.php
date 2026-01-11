<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_name',
        'logo',
        'favicon',
        'contact_email',
        'contact_phone',
        'currency',
        'timezone',
        'notify_new_order',
        'notify_user_registration',
        'notify_stock_alert',
        'meta_title',
        'meta_description',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'maintenance_mode',
    ];
}
