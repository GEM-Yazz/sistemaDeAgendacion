<?php

use App\Controllers\BookingController;
use App\Services\MailService;

class BookingRouter {
    private $controller;

    public function __construct() {
        $this->controller = new BookingController();

        add_action('rest_api_init', function () {
            register_rest_route('custom/v1', '/bookings', array(
                'methods' => 'POST',
                'callback' => array($this, 'store'),
                'permission_callback' => function () {
                    return true;
                },
                'args'  => $this->__getArgs(['fullname', 'email', 'phone', 'date', 'hour'])
            ));
        });

        add_action('rest_api_init', function () {
            register_rest_route('custom/v1', '/bookings', array(
                'methods' => 'GET',
                'callback' => array($this, 'index'),
                'permission_callback' => function () {
                    return true;
                }
            ));
        });

        add_action('rest_api_init', function () {
            register_rest_route('custom/v1', '/bookings/download', array(
                'methods' => 'GET',
                'callback' => array($this, 'download'),
                'permission_callback' => function () {
                    return true;
                }
            ));
        });

        add_action('rest_api_init', function () {
            register_rest_route('custom/v1', '/bookings/test', array(
                'methods' => 'GET',
                'callback' => array($this, 'test'),
                'permission_callback' => function () {
                    return true;
                }
            ));
        });
    }

    public function store($request) {
        try {
            $data = $this->controller->store($request);

            $mailService = new MailService($data->toArray(), [$data->email], '¡🥳 Gracias por tu registro 🎉!', 'registered');

            $mailService->sendMail();

            $mailServiceAdmin = new MailService($data->toArray(), ['dikharla.martinez@lge.com'], 'Nueva Reserva', 'registered-admin');

            $mailServiceAdmin->sendMail();

            return wp_send_json([
                'message'   => $data ? 'Booking saved!!' : 'No booking saved 😥',
                'data'      => $data,
                'status'    => $data ? true : false
            ], 200);
        } catch (Exception $e) {
            return wp_send_json([
                'code'      => $e->getCode() ?? 502,
                'message'   => $e->getMessage(),
                'status'    => false
            ], $e->getCode() ?? 502);
        }
    }

    public function index($request) {
        try {
            $data = $this->controller->index($request);

            return wp_send_json([
                'message'   => $data ? 'Bookings here!!' : 'No bookings here 😥',
                'data'      => $data,
                'status'    => $data ? true : false
            ], 200);
        } catch (Exception $e) {
            return wp_send_json([
                'code'      => $e->getCode() ?? 502,
                'message'   => $e->getMessage(),
                'status'    => false
            ], $e->getCode() ?? 502);
        }
    }

    public function download() {
        $this->controller->download();
    }

    public function test($request) {
        try {
            $data = $this->controller->sendPandaNotification();

            // $mailService = new MailService($data->toArray(), $data->email, '¡🥳 Gracias por tu registro 🎉!', 'registered');
            // $mailService->sendMail();

            return wp_send_json([
                'message'   => $data ? 'Booking saved!!' : 'No booking saved 😥',
                'data'      => $data,
                'status'    => $data ? true : false
            ], 200);
        } catch (Exception $e) {
            return wp_send_json([
                'code'      => $e->getCode() ?? 502,
                'message'   => $e->getMessage(),
                'status'    => false
            ], $e->getCode() ?? 502);
        }
    }

    private function __getArgs($selectedRules) {
        $rules = [
            'fullname' => [
                'required'          => true,
                'type'              => 'string',
                'validate_callback' => function($param, $request, $key) {
                    return is_string($param);
                },
            ],
            'email' => [
                'required'          => true,
                'type'              => 'string',
                'validate_callback' => function($param, $request, $key) {
                    return is_string($param);
                },
            ],
            'phone' => [
                'required'          => true,
                'type'              => 'string',
                'validate_callback' => function($param, $request, $key) {
                    return is_string($param);
                },
            ],
            'date' => [
                'required'          => true,
                'type'              => 'string',
                'validate_callback' => function($param, $request, $key) {
                    return is_string($param);
                },
            ],
            'hour' => [
                'required'          => true,
                'type'              => 'string',
                'validate_callback' => function($param, $request, $key) {
                    return is_string($param);
                },
            ],
        ];

        return $selectedRules
            ? array_intersect_key($rules, array_flip($selectedRules))
            : $rules;
    }
}
