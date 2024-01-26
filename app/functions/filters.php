<?php

use Timber\Timber;
use App\Controllers\BookingController;

add_action('panda_remind_booking', function() {
    (new BookingController())->sendPandaNotification();
});

add_filter('auth_cookie_expiration', function(){
    return 3600;
});
