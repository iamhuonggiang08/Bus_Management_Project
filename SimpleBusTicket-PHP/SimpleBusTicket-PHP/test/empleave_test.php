<?php
public function testValidLeaveData() {
    // Mô phỏng dữ liệu trả về từ truy vấn cơ sở dữ liệu
    $mockResult = [
        ['id' => '1', 'firstName' => 'John', 'lastName' => 'Doe', 'start' => '2023-05-01', 'end' => '2023-05-10', 'reason' => 'Vacation', 'status' => 'Pending', 'token' => '123']
    ];
    // Mô phỏng hàm mysqli_fetch_assoc
    $this->mockFunction('mysqli_fetch_assoc', $mockResult);
    ob_start();
    include 'empleave.php';
    $output = ob_get_clean();
    $this->assertStringContainsString('John Doe', $output);
}

public function testNoLeaveData() {
    // Mô phỏng không có dữ liệu trả về
    $this->mockFunction('mysqli_fetch_assoc', false);
    ob_start();
    include 'empleave.php';
    $output = ob_get_clean();
    $this->assertStringContainsString('No leave requests found', $output);
}


?>