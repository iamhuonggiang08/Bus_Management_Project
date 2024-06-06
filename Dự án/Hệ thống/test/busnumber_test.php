<?php

use PHPUnit\Framework\TestCase;

class BusManagementTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        $this->conn = $this->createMock(mysqli::class);
    }

    public function testAddBus()
    {
        $_POST['submit'] = true;
        $_POST['busnumber'] = 'BUS123';

        $stmt = $this->createMock(mysqli_stmt::class);
        $stmt->method('fetch')
             ->willReturn(false);

        $stmt->method('execute')
             ->willReturn(true);

        ob_start();
        include 'path/to/bus-management-script.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('Bus Information Added', $output);
    }

    public function testEditBus()
    {
        $_POST['edit'] = true;
        $_POST['busno'] = 'BUS456';
        $_POST['id'] = 1;

        $stmt = $this->createMock(mysqli_stmt::class);
        $stmt->method('fetch')
             ->willReturn(false);

        $stmt->method('execute')
             ->willReturn(true);


        ob_start();
        include 'path/to/bus-management-script.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('Bus details Edited', $output);
    }

    public function testDeleteBus()
    {
        $_POST['delete'] = true;
        $_POST['id'] = 1;

        $stmt = $this->createMock(mysqli_stmt::class);
        $stmt->method('execute')
             ->willReturn(true);

        ob_start();
        include 'path/to/bus-management-script.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('Bus Details deleted', $output);
    }
}

?>

