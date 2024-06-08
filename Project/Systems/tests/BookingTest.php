<?php
require_once 'C:/Users/Admin/OneDrive/Documents/Bus_Management_Project/Project/Systems/admin/booking.php';

use PHPUnit\Framework\TestCase;

class BookingTest extends TestCase {
    public function testAddBooking() {
        // Mô phỏng dữ liệu POST
        $_POST["cid"] = 1;
        $_POST["cname"] = "Nguyen Van A";
        $_POST["cphone"] = "0123456789";
        $_POST["route_id"] = 1;
        $_POST["sourceSearch"] = "Hanoi";
        $_POST["destinationSearch"] = "Ho Chi Minh";
        $_POST["seatInput"] = "12";
        $_POST["bookAmount"] = 500000;
        $_POST["submit"] = true;

        // Bắt đầu output buffer để kiểm tra kết quả
        ob_start();
        require 'path/to/your_script.php';
        $output = ob_get_clean();

        // Kiểm tra kết quả
        $this->assertStringContainsString("Booking Added", $output);
    }
}