<?php
public function testValidEmployeeData() {
    $_POST = [
        'firstName' => 'John',
        'lastName' => 'Doe',
        'email' => 'john.doe@example.com',
        'birthday' => '1990-01-01',
        'gender' => 'Male',
        'contact' => '1234567890',
        'nid' => '123456789',
        'address' => '123 Main St',
        'dept' => 'IT',
        'degree' => 'Bachelor',
        'salary' => '5000'
    ];
    ob_start();
    include 'addemp.php';
    $output = ob_get_clean();
    $this->assertStringContainsString('Employee added successfully', $output);
}

public function testEmptyFirstName() {
    $_POST = [
        'firstName' => '',
        'lastName' => 'Doe',
        'email' => 'john.doe@example.com',
        'birthday' => '1990-01-01',
        'gender' => 'Male',
        'contact' => '1234567890',
        'nid' => '123456789',
        'address' => '123 Main St',
        'dept' => 'IT',
        'degree' => 'Bachelor',
        'salary' => '5000'
    ];
    ob_start();
    include 'addemp.php';
    $output = ob_get_clean();
    $this->assertStringContainsString('First Name is required', $output);
}

?>