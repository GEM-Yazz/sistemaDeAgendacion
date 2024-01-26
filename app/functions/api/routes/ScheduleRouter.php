<?php

use App\Controllers\ScheduleController;

class ScheduleRouter {
    private $controller;

    public function __construct() {
        $this->controller = new ScheduleController();

        add_action('rest_api_init', function () {
            register_rest_route('custom/v1', '/schedules', array(
                'methods' => 'GET',
                'callback' => array($this, 'show'),
                'permission_callback' => function () {
                    return true;
                },
                'args'  => $this->__getArgs(['day', 'date'])
            ));
        });
    }

    public function show($request) {
        try {
            $data = $this->controller->show($request['day'], $request['date']);

            return wp_send_json([
                'message'   => $data ? 'Hours found!!' : 'No hours found 😥',
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
            'day' => [
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
            ]
        ];

        return $selectedRules
            ? array_intersect_key($rules, array_flip($selectedRules))
            : $rules;
    }
}
