<?php

require_once(__DIR__ . "/../../config/database.php");

use App\Models\Booking;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

use PHPUnit\Framework\TestCase;

class BookingTest extends TestCase {
    private $http;

    public function setUp(): void {
        $this->http = new Client(['base_uri' => $_ENV['APP_API_URI']]);
    }

    public function tearDown(): void {
        $bookings = Booking::where(['email' => 'panda@test.test'])
            ->get();

        foreach($bookings as $booking) {
            $booking->delete();
        }
    }

    /**
     * @group booking
     */
    public function testPostBooking() {
        $booking = [
            'fullname'  => 'Cleiver Valera',
            'email'     => 'panda@test.test',
            'phone'     => '942321265',
            'product'   => 'tv',
            'message'   => 'empty',
            'date'      => '2023/06/12',
            'hour'      => '11:00 am'
        ];

        $response = $this->http->request('POST', 'bookings', [
            'form_params' => $booking,
        ]);

        $body = json_decode($response->getBody());

        $this->assertEquals($booking['fullname'], $body->data->fullname);
        $this->assertEquals($booking['email'], $body->data->email);
        $this->assertEquals($booking['phone'], $body->data->phone);
        $this->assertEquals($booking['product'], $body->data->product);
        $this->assertEquals($booking['date'], $body->data->date);
        $this->assertEquals($booking['hour'], $body->data->hour);
        $this->assertEquals($booking['message'], $body->data->message);
    }

    /**
     * @group booking
     */
    public function testPostBookingWithoutFullnameReturn400() {
        try {
            $booking = [
                'email'     => 'panda@test.test',
                'phone'     => '942321265',
                'product'   => 'tv',
                'date'      => '2023/06/12',
                'hour'      => '11:00 am'
            ];

            $this->http->request('POST', 'bookings', [
                'form_params' => $booking,
            ]);
        } catch (ClientException $e) {
            $this->assertEquals(400, $e->getResponse()->getStatusCode());
        }
    }

    /**
     * @group booking
     */
    public function testPostBookingWithoutEmailReturn400() {
        try {
            $booking = [
                'fullname'  => 'Cleiver Valera',
                'phone'     => '942321265',
                'product'   => 'tv',
                'date'      => '2023/06/12',
                'hour'      => '11:00 am'
            ];

            $this->http->request('POST', 'bookings', [
                'form_params' => $booking,
            ]);
        } catch (ClientException $e) {
            $this->assertEquals(400, $e->getResponse()->getStatusCode());
        }
    }

    /**
     * @group booking
     */
    public function testPostBookingWithoutPhoneReturn400() {
        try {
            $booking = [
                'fullname'  => 'Cleiver Valera',
                'email'     => 'panda@test.test',
                'product'   => 'tv',
                'date'      => '2023/06/12',
                'hour'      => '11:00 am'
            ];

            $this->http->request('POST', 'bookings', [
                'form_params' => $booking
            ]);
        } catch (ClientException $e) {
            $this->assertEquals(400, $e->getResponse()->getStatusCode());
        }
    }

    /**
     * @group booking
     */
    public function testPostBookingWithoutDateReturn400() {
        try {
            $booking = [
                'fullname'  => 'Cleiver Valera',
                'email'     => 'panda@test.test',
                'phone'     => '942321265',
                'hour'      => '11:00 am'
            ];

            $this->http->request('POST', 'bookings', [
                'form_params' => $booking,
            ]);
        } catch (ClientException $e) {
            $this->assertEquals(400, $e->getResponse()->getStatusCode());
        }
    }

    /**
     * @group booking
     */
    public function testPostBookingOptionalMessageAndProduct() {
        $booking = [
            'fullname'  => 'Cleiver Valera',
            'email'     => 'panda@test.test',
            'phone'     => '942321265',
            'date'      => '2023/06/12',
            'hour'      => '11:00 am'
        ];

        $response = $this->http->request('POST', 'bookings', [
            'form_params' => $booking,
        ]);

        $body = json_decode($response->getBody());

        $this->assertEquals($booking['fullname'], $body->data->fullname);
        $this->assertEquals($booking['email'], $body->data->email);
        $this->assertEquals($booking['phone'], $body->data->phone);
        $this->assertEquals($booking['date'], $body->data->date);
        $this->assertEquals($booking['hour'], $body->data->hour);
    }

    /**
     * @group booking
     */
    public function testGetBookings() {
        $booking = [
            'fullname'  => 'Cleiver Valera',
            'email'     => 'panda@test.test',
            'phone'     => '942321265',
            'product'   => 'tv',
            'message'   => 'empty',
            'date'      => '2023-06-12',
            'hour'      => '11:00 am'
        ];

        $response = $this->http->request('POST', 'bookings', [
            'form_params' => $booking,
        ]);

        $response = $this->http->request('GET', 'bookings');

        $body = json_decode($response->getBody());

        $this->assertIsArray($body->data);
        $this->assertEquals($booking['fullname'], $body->data[0]->fullname);
        $this->assertEquals('p***t', $body->data[0]->email);
        $this->assertEquals('9***5', $body->data[0]->phone);
        $this->assertEquals($booking['product'], $body->data[0]->product);
        $this->assertEquals($booking['date'], $body->data[0]->date);
        $this->assertEquals($booking['hour'], $body->data[0]->hour);
        $this->assertEquals($booking['message'], $body->data[0]->message);
    }

    /**
     * @group booking
     */
    public function testPostBookingUserHasOnlyOne() {
        $booking = [
            'fullname'  => 'Cleiver Valera',
            'email'     => 'panda@test.test',
            'phone'     => '942321265',
            'product'   => 'tv',
            'message'   => 'empty',
            'date'      => '2023-06-12',
            'hour'      => '11:00 am'
        ];

        $response = $this->http->request('POST', 'bookings', [
            'form_params' => $booking,
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        try {
            $response = $this->http->request('POST', 'bookings', [
                'form_params' => $booking,
            ]);

            $this->assertEquals(403, $response->getStatusCode());
        } catch (ClientException $e) {
            $this->assertEquals(403, $e->getResponse()->getStatusCode());
        }
    }
}
