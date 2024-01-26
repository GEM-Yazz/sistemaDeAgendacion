<?php

$database::statement('CREATE TABLE IF NOT EXISTS wp_bookings(
    id INT NOT NULL AUTO_INCREMENT,
    fullname VARCHAR(70) NOT NULL,
    email VARCHAR(70) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    product VARCHAR(70) NULL,
    date DATE NOT NULL,
    hour VARCHAR(20) NOT NULL,
    message TEXT NULL,
    notified VARCHAR(5) NULL,

    politics BOOLEAN NULL,

    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    PRIMARY KEY (id)
)');
