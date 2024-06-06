<?php
public function testValidSalaryData() {
    // Mô phỏng dữ liệu trả về từ truy vấn cơ sở dữ liệu
    $mockResult = [
        ['id' => '1', 'firstName' => 'John', 'lastName' => 'Doe', 'salary' => '5000']
    ];
    // Mô phỏng hàm mysqli_fetch_assoc
    $this->mockFunction('mysqli_fetch_assoc', $mockResult);
    ob_start();
    include 'salaryemp.php';
    $output = ob_get_clean();
    $this->assertStringContainsString('John Doe', $output);
}

public function testNoSalaryData() {
    // Mô phỏng không có dữ liệu trả về
    $this->mockFunction('mysqli_fetch_assoc', false);
    ob_start();
    include 'salaryemp.php';
    $output = ob_get_clean();
    $this->assertStringContainsString('No salary data found', $output);
}

?>