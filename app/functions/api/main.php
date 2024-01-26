<?php

require_once(__DIR__ . "/config.php");
require_once(__DIR__ . "/database/main.php");

$appRoutes  = ['PageRouter', 'BookingRouter', 'ScheduleRouter'];

__importProviders('router', $appRoutes);
