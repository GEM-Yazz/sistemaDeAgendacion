<?php

use App\Models\Booking;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

use PHPUnit\Framework\TestCase;

class ScheduleTest extends TestCase {
    private $http;

    public function setUp(): void {
        $this->http = new Client(['base_uri' => $_ENV['APP_API_URI']]);
    }

    public function tearDown(): void {
        $bookings = Booking::whereIn('email', ['panda@test.test', 'panda2@test.test'])
            ->get();

        foreach($bookings as $booking) {
            $booking->delete();
        }
    }

    /**
     * @group schedule
     */
    public function testShowHoursResponseOk(): void {
        $response = $this->http->request('GET', 'schedules', [
            'query' => [
                'day'   => 'monday',
                'date'  => '2023/06/12'
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @group schedule
     */
    public function testShowHoursByDay(): void {
        $response = $this->http->request('GET', 'schedules', [
            'query' => [
                'day'   => 'monday',
                'date'  => '2023/06/12'
            ]
        ]);

        $body = json_decode($response->getBody());

        $this->assertIsArray($body->data);
        $this->assertEquals(2, count(explode(':', $body->data[0])));
    }

    /**
     * @group schedule
     */
    public function testShowHoursByOffDay(): void {
        try {
            $response = $this->http->request('GET', 'schedules', [
                'query' => [
                    'day'   => 'monday',
                    'date'  => '2023/06/20' /* OFF Day */
                ]
            ]);

            $this->assertEquals(404, $response->getStatusCode());
        } catch (ClientException $e) {
            $this->assertEquals(404, $e->getResponse()->getStatusCode());
        }
    }

    /**
     * @group schedule
     */
    public function testShowHoursWereNotBookedByDay(): void {
        $booking = [
            'fullname'  => 'Cleiver Valera',
            'email'     => 'panda@test.test',
            'phone'     => '942321265',
            'product'   => 'tv',
            'date'      => '2023/06/12',
            'hour'      => '11:00 am'
        ];

        $response = $this->http->request('POST', 'bookings', [
            'form_params' => $booking,
        ]);

        $response = $this->http->request('GET', 'schedules', [
            'query' => [
                'day'   => 'monday',
                'date'  => '2023/06/12'
            ]
        ]);

        $body = json_decode($response->getBody());

        $this->assertNotContains('11:00 am', $body->data);
    }

    /**
     * @group schedule
     */
    public function testShowHoursByDayWithoutHoursReturn404(): void {
        try {
            $booking = [
                'fullname'  => 'Cleiver Valera',
                'phone'     => '942321265',
                'product'   => 'tv',
                'date'      => '2023/06/12'
            ];

            $response = $this->http->request('POST', 'bookings', [
                'form_params' => array_merge(
                    $booking,
                    [
                        'email' => 'panda@test.test',
                        'hour'  => '10:00 am'
                    ]
                )
            ]);

            $response = $this->http->request('POST', 'bookings', [
                'form_params' => array_merge(
                    $booking,
                    [
                        'email' => 'panda2@test.test',
                        'hour'  => '11:00 am'
                    ]
                )
            ]);

            $response = $this->http->request('GET', 'schedules', [
                'query' => [
                    'day'   => 'monday',
                    'date'  => '2023/06/12'
                ]
            ]);

            $this->assertEquals(404, $response->getStatusCode());
        } catch (ClientException $e) {
            $this->assertEquals(404, $e->getResponse()->getStatusCode());
        }
    }
}
