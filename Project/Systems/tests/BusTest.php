<?php
use PHPUnit\Framework\TestCase;

class BusTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        // Thiết lập kết nối cơ sở dữ liệu giả lập để kiểm thử
        $this->conn = new mysqli('localhost', 'username', 'password', 'database');
    }

    protected function tearDown(): void
    {
        // Đóng kết nối cơ sở dữ liệu sau khi kiểm thử
        $this->conn->close();
    }

    public function testAddBus()
    {
        // Giả lập dữ liệu POST cho việc thêm xe bus
        $_POST['submit'] = true;
        $_POST['busnumber'] = '123ABC';
        $_SERVER['REQUEST_METHOD'] = 'POST';

        // Giả lập admin đã đăng nhập
        $loggedIn = true;

        // Gọi đoạn mã thêm xe bus
        ob_start();
        include '../path_to_your_php_file.php'; // Đường dẫn đến file PHP của bạn
        $output = ob_get_clean();

        // Kiểm tra xem thông báo thành công có xuất hiện hay không
        $this->assertStringContainsString('Successful! Bus Information Added', $output);
    }

    public function testEditBus()
    {
        // Giả lập dữ liệu POST cho việc chỉnh sửa xe bus
        $_POST['edit'] = true;
        $_POST['busno'] = '456DEF';
        $_POST['id'] = 1;
        $_SERVER['REQUEST_METHOD'] = 'POST';

        // Giả lập admin đã đăng nhập
        $loggedIn = true;

        // Gọi đoạn mã chỉnh sửa xe bus
        ob_start();
        include '../path_to_your_php_file.php'; // Đường dẫn đến file PHP của bạn
        $output = ob_get_clean();

        // Kiểm tra xem thông báo thành công có xuất hiện hay không
        $this->assertStringContainsString('Successfull! Bus details Edited', $output);
    }

    public function testDeleteBus()
    {
        // Giả lập dữ liệu POST cho việc xóa xe bus
        $_POST['delete'] = true;
        $_POST['id'] = 1;
        $_SERVER['REQUEST_METHOD'] = 'POST';

        // Giả lập admin đã đăng nhập
        $loggedIn = true;

        // Gọi đoạn mã xóa xe bus
        ob_start();
        include '../path_to_your_php_file.php'; // Đường dẫn đến file PHP của bạn
        $output = ob_get_clean();

        // Kiểm tra xem thông báo thành công có xuất hiện hay không
        $this->assertStringContainsString('Successfull! Bus Details deleted', $output);
    }
}
