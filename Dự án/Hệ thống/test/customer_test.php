<?php
// tests/CustomerTest.php

use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        // Thiết lập kết nối giả lập cho cơ sở dữ liệu
        $this->conn = $this->createMock(mysqli::class);
    }

    public function testAdminCheck()
    {
        $_SESSION['loggedin'] = true;
        include '../assets/partials/_admin-check.php';
        $this->assertTrue($loggedIn, 'Admin đã đăng nhập nên $loggedIn phải là true.');

        $_SESSION['loggedin'] = false;
        include '../assets/partials/_admin-check.php';
        $this->assertFalse($loggedIn, 'Admin chưa đăng nhập nên $loggedIn phải là false.');
    }

    public function testAddCustomer()
    {
        $_SERVER["REQUEST_METHOD"] = "POST";
        $_POST["submit"] = true;
        $_POST["cfirstname"] = "John";
        $_POST["clastname"] = "Doe";
        $_POST["cphone"] = "1234567890";

        $exist_customers = function ($conn, $cname, $cphone) {
            return false;
        };

        $this->conn->method('query')
                   ->willReturn(true);

        include '../src/process_customer_post.php';

        $this->assertTrue($customer_added, 'Khách hàng mới phải được thêm thành công.');
    }

    public function testAddExistingCustomer()
    {
        $_SERVER["REQUEST_METHOD"] = "POST";
        $_POST["submit"] = true;
        $_POST["cfirstname"] = "John";
        $_POST["clastname"] = "Doe";
        $_POST["cphone"] = "1234567890";

        $exist_customers = function ($conn, $cname, $cphone) {
            return true;
        };

        $this->conn->method('query')
                   ->willReturn(true);

        include '../src/process_customer_post.php';

        $this->assertFalse($customer_added, 'Khách hàng đã tồn tại nên không thể thêm.');
    }

    public function testEditCustomer()
    {
        $_SERVER["REQUEST_METHOD"] = "POST";
        $_POST["edit"] = true;
        $_POST["cname"] = "John Doe";
        $_POST["cphone"] = "0987654321";
        $_POST["id"] = "CUST-1234567890";

        $exist_customers = function ($conn, $cname, $cphone) {
            return false;
        };

        $this->conn->method('query')
                   ->willReturn(true);

        include '../src/process_customer_post.php';

        $this->assertTrue($rowsAffected > 0, 'Thông tin khách hàng phải được chỉnh sửa thành công.');
    }

    public function testDeleteCustomer()
    {
        $_SERVER["REQUEST_METHOD"] = "POST";
        $_POST["delete"] = true;
        $_POST["id"] = 1;

        $this->conn->method('query')
                   ->willReturn(true);

        include '../src/process_customer_post.php';

        $this->assertTrue($rowsAffected > 0, 'Khách hàng phải được xóa thành công.');
    }

    public function testDisplayCustomers()
    {
        $resultSqlResult = $this->createMock(mysqli_result::class);
        $resultSqlResult->method('fetch_assoc')
                        ->willReturnOnConsecutiveCalls(
                            ["id" => 1, "customer_id" => "CUST-1", "customer_name" => "John Doe", "customer_phone" => "1234567890"],
                            ["id" => 2, "customer_id" => "CUST-2", "customer_name" => "Jane Doe", "customer_phone" => "0987654321"],
                            false
                        );

        $this->conn->method('query')
                   ->willReturn($resultSqlResult);

        ob_start();
        include '../src/display_customers.php';
        $output = ob_get_clean();

        $this->assertStringContainsString("CUST-1", $output, 'Danh sách khách hàng phải được hiển thị đúng.');
        $this->assertStringContainsString("CUST-2", $output, 'Danh sách khách hàng phải được hiển thị đúng.');
    }
}
?>

