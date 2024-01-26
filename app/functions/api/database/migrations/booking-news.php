<?php

try {
    $comparisons = $database::statement('SELECT news FROM wp_bookings');
} catch (Exception $e) {
    $database::statement('ALTER TABLE wp_bookings
        ADD COLUMN news BOOLEAN NULL AFTER politics
    ');
}
