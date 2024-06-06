<?php
require_once 'booking.php';

use PHPUnit\Framework\TestCase;

class BookingTest extends TestCase
{
    public function testAdminAccess()
    {
        $_SESSION['admin'] = true;

        ob_start();
        include 'booking.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('<title>Bookings</title>', $output);
    }

    public function testAddBookingValidData()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['submit'] = true;
        $_POST['cname'] = 'John Doe';
        $_POST['cphone'] = '1234567890';

        $connMock = $this->getMockBuilder('mysqli')
                         ->disableOriginalConstructor()
                         ->getMock();


        $result = addBooking(your_conn_function(), $connMock);


        $this->assertTrue($result);
    }

    public function testAddBookingInvalidData()
    {

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['submit'] = true;


        $connMock = $this->getMockBuilder('mysqli')
                         ->disableOriginalConstructor()
                         ->getMock();

        $result = addBooking(your_conn_function(), $connMock);

        $this->assertFalse($result);
    }

}
