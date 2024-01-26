<?php

try {
    $comparisons = $database::statement('SELECT politics FROM wp_bookings');
} catch (Exception $e) {
    $database::statement('ALTER TABLE wp_bookings
        ADD COLUMN politics VARCHAR(50) NULL AFTER notified
    ');
}
