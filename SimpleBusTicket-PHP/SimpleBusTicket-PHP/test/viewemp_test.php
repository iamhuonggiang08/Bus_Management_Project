<?php
public function testValidEmployeeData() {
    // Mô phỏng dữ liệu trả về từ truy vấn cơ sở dữ liệu
    $mockResult = [
        ['id' => '1', 'firstName' => 'John', 'lastName' => 'Doe', 'email' => 'john.doe@example.com', 'birthday' => '1990-01-01', 'gender' => 'Male', 'contact' => '1234567890', 'nid' => '123456789', 'address' => '123 Main St', 'dept' => 'IT', 'degree' => 'Bachelor', 'salary' => '5000']
    ];
    // Mô phỏng hàm mysqli_fetch_assoc
    $this->mockFunction('mysqli_fetch_assoc', $mockResult);
    ob_start();
    include 'viewemp.php';
    $output = ob_get_clean();
    $this->assertStringContainsString('John Doe', $output);
}

public function testNoEmployeeData() {
    // Mô phỏng không có dữ liệu trả về
    $this->mockFunction('mysqli_fetch_assoc', false);
    ob_start();
    include 'viewemp.php';
    $output = ob_get_clean();
    $this->assertStringContainsString('No employee data found', $output);
}


?>