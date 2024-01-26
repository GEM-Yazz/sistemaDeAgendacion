<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model {
    protected $table    = 'wp_bookings';
    protected $fillable = [
        'fullname',
        'email',
        'phone',
        'product',
        'message',
        'date',
        'hour',
        'notified',
        'politics',
        'news'
    ];
}
