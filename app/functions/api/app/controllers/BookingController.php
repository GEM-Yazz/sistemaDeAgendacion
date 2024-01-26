<?php

namespace App\Controllers;

use App\Models\Booking;
use App\Services\MailService;
use Carbon\Carbon;
use Exception;

// Carbon::setTimezone('America/New_York');

class BookingController {
    public function __construct() {}

    public function store($params): Booking {
        if ($this->__checkIsUserAlreadyRegistered($params['email'], $params['date'])) {
            throw new Exception('El usuario (email) ya ha reservado una cita para esta fecha', 403);
        }

        $booking = new Booking();

        $booking->fullname  = wp_strip_all_tags($params['fullname']);
        $booking->email     = $params['email'];
        $booking->phone     = $params['phone'];
        $booking->date      = $params['date'];
        $booking->hour      = $params['hour'];
        $booking->politics  = boolval($params['politics']);
        $booking->news  = $params['news'];

        if ($params['product']) {
            $booking->product = $params['product'];
        }

        if ($params['message']) {
            $booking->message = wp_strip_all_tags($params['message']);
        }

        $booking->save();

        return $booking;
    }

    public function index($params) {
        $page       = isset($params['page']) ? $params['page'] : 1;
        $bookings   = [];
        $where      = [];

        if ($page > 1) {
            $skip = ($page - 1) * 25;

            $bookings = Booking::where($where)
                ->orderBy('id', 'desc')
                ->skip($skip)
                ->take(25)
                ->get();
        } else {
            $bookings = Booking::where($where)
                ->orderBy('id', 'desc')
                ->limit(25)
                ->get();
        }

        if (count($bookings)) {
            foreach($bookings as $booking) {
                $emailLength    = strlen($booking->email);
                $phoneLength    = strlen($booking->phone);

                $booking->email = sprintf('%s***%s', $booking->email[0], $booking->email[$emailLength - 1]);
                $booking->phone = sprintf('%s***%s', strval($booking->phone)[0], strval($booking->phone)[$phoneLength - 1]);
            }

            return $bookings;
        } else {
            return null;
        }
    }

    public function download() {
        $bookings = Booking::orderBy('created_at', 'desc')
            ->get();

        if ($bookings) {
            header('Content-Encoding: UTF-8');
            header("Content-Type: application/xls; charset=UTF-8");
            header("Content-Disposition: attachment; filename=bookings-".date('Y-m-d').".xls"); 
            echo "\xEF\xBB\xBF";

            include_once __DIR__ . "/../../assets/templates/bookings.php";
        } else {
            return null;
        }
    }

    public function sendPandaNotification() {
        $bookings = Booking::whereDate('date', '>=', Carbon::now()->subHours(5))
            ->get();

        foreach($bookings as $booking) {
            $hourBooking = date("H:i:s", strtotime($booking->hour));
            $dateTime =  $booking->date . ' ' . $hourBooking;
            $bookinDateParsed = Carbon::parse($dateTime);
            $hoursDifference =  $bookinDateParsed->diffInMinutes(Carbon::now()->subHours(5)); 

            if($hoursDifference <= 60) {
                if($booking->notified != '1h') {
                    $booking->update([
                        'notified' => '1h'
                    ]);
                    //enviar mail
                    $mailService = new MailService($booking->toArray(), [$booking->email], '¡🥳 Nos vemos en una hora 🎉!', 'registered');
                    $mailService->sendMail();
                    return '1h';
                }
            } elseif ($hoursDifference <= 1440) {
                if($booking->notified != '24h' && $booking->notified != '1h') {
                    $booking->update([
                        'notified' => '24h'
                    ]);
                    //enviar mail
                    $mailService = new MailService($booking->toArray(), [$booking->email], '¡🥳 Nos vemos en 24 horas 🎉!', 'registered');
                    $mailService->sendMail();
                    return '24h';
                }
            }
        }
    }

    private function __checkIsUserAlreadyRegistered(string $email, string $date): bool {
        $booking = Booking::where([
            'email' => $email,
            'date'  => $date
        ])->first();

        return boolval($booking);
    }
    
}
