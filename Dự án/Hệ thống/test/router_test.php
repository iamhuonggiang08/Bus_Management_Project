<?php
use PHPUnit\Framework\TestCase;

class RouteManagementTest extends TestCase {
    private $conn;

    protected function setUp(): void {
        $this->conn = $this->createMock(mysqli::class);
    }

    public function testAddRoute() {
        $viaCities = 'CITY1,CITY2';
        $cost = 100;
        $deptime = '10:00';
        $depdate = '2024-06-01';
        $busno = 'BUS123';

        $route_exists = false;
        $this->conn->method('query')->will($this->onConsecutiveCalls(
            $this->returnValue($route_exists),
            $this->returnValue(true), // For INSERT query
            $this->returnValue(true)  // For UPDATE query
        ));
        $this->conn->method('insert_id')->willReturn(1);

        $result = addRoute($this->conn, $viaCities, $cost, $deptime, $depdate, $busno);
        $this->assertTrue($result);
    }

    public function testEditRoute() {
        $id = 1;
        $viaCities = 'CITY1,CITY2';
        $cost = 100;
        $deptime = '10:00';
        $depdate = '2024-06-01';
        $busno = 'BUS123';
        $oldBusNo = 'BUS456';

        $id_if_route_exists = false;
        $this->conn->method('query')->will($this->onConsecutiveCalls(
            $this->returnValue($id_if_route_exists),
            $this->returnValue(true) // For UPDATE query
        ));

        $result = editRoute($this->conn, $id, $viaCities, $cost, $deptime, $depdate, $busno, $oldBusNo);
        $this->assertTrue($result);
    }

    public function testDeleteRoute() {
        $id = 1;

        $busno_toFree = 'BUS123';
        $this->conn->method('query')->will($this->onConsecutiveCalls(
            $this->returnValue(true), // For DELETE query
            $this->returnValue(true)  // For freeing the bus
        ));

        $this->conn->method('affected_rows')->willReturn(1);

        $result = deleteRoute($this->conn, $id);
        $this->assertTrue($result);
    }
}
?>