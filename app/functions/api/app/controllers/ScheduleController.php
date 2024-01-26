<?php

namespace App\Controllers;

use App\Models\Booking;

use Exception;

class ScheduleController {
    public function __construct() {
    }

    public function show(string $day, string $date) {
        $schedule           = get_field('schedule', 'options');
        $scheduleOffDays    = get_field('schedule_offline', 'options');
        $scheduleDayHours   = $schedule[$day];
        $finalDayHours      = [];

        if (!$scheduleDayHours) throw new Exception('El calendario del sistema no tiene configurado esta fecha', 404);

        if ($scheduleOffDays) {
            foreach($scheduleOffDays as $itemDate) {
                if ($itemDate['date'] == $date) {
                    throw new Exception('La fecha proporcionada es un día no disponible', 404);
                }
            }
        }

        foreach($scheduleDayHours as $itemHour) {
            $booking = Booking::where([
                'date' => $date,
                'hour' => $itemHour['hour']
            ])->first();

            if (!$booking) {
                array_push($finalDayHours, $itemHour['hour']);
            }
        }

        if (!count($finalDayHours)) throw new Exception('No hay horas disponibles para esta fecha', 404);

        return $finalDayHours;
    }
}
