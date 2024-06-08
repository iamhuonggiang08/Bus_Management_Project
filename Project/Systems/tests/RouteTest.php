// tests/RouteTest.php
<?php
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    protected $conn;
    protected $backupGlobalsBlacklist = ['_SESSION'];

    protected function setUp(): void
    {
        require 'config_test.php';
        $this->conn = $conn;
        $this->createTestTables();
        $_SESSION = [];
    }

    protected function tearDown(): void
    {
        $this->dropTestTables();
        $this->conn->close();
    }

    private function createTestTables()
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS routes (
                id INT AUTO_INCREMENT PRIMARY KEY,
                route_id VARCHAR(255),
                route_cities VARCHAR(255) NOT NULL,
                bus_no VARCHAR(255) NOT NULL,
                route_dep_date DATE NOT NULL,
                route_dep_time TIME NOT NULL,
                route_step_cost INT NOT NULL,
                route_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS buses (
                bus_no VARCHAR(255) PRIMARY KEY,
                bus_assigned INT DEFAULT 0
            );
        ";
        $this->conn->multi_query($sql);
        while ($this->conn->more_results() && $this->conn->next_result()) {;}
    }

    private function dropTestTables()
    {
        $sql = "
            DROP TABLE IF EXISTS routes;
            DROP TABLE IF EXISTS buses;
        ";
        $this->conn->multi_query($sql);
        while ($this->conn->more_results() && $this->conn->next_result()) {;}
    }

    public function testAddRoute()
    {
        // Simulate form submission
        $_SESSION['loggedIn'] = true;
        $_POST = [
            'submit' => true,
            'viaCities' => 'Hanoi, Haiphong',
            'stepCost' => 500000,
            'dep_time' => '10:00',
            'dep_date' => '2024-12-01',
            'busno' => 'BUS-001'
        ];

        ob_start();
        include '../admin/routes.php';
        ob_end_clean();

        // Check if route is added
        $result = $this->conn->query("SELECT * FROM routes WHERE route_cities='HANOI, HAIPHONG'");
        $this->assertEquals(1, $result->num_rows);
    }

    public function testEditRoute()
    {
        // Add a route first
        $this->conn->query("INSERT INTO routes (route_cities, bus_no, route_dep_date, route_dep_time, route_step_cost) VALUES ('Hanoi, Haiphong', 'BUS-001', '2024-12-01', '10:00', 500000)");

        // Simulate form submission for editing
        $_SESSION['loggedIn'] = true;
        $_POST = [
            'edit' => true,
            'id' => 1,
            'viaCities' => 'Hanoi, Danang',
            'stepCost' => 600000,
            'dep_time' => '12:00',
            'dep_date' => '2024-12-01',
            'busno' => 'BUS-002',
            'old-busno' => 'BUS-001'
        ];

        ob_start();
        include '../admin/routes.php';
        ob_end_clean();

        // Check if route is edited
        $result = $this->conn->query("SELECT * FROM routes WHERE route_cities='HANOI, DANANG'");
        $this->assertEquals(1, $result->num_rows);
    }

    public function testDeleteRoute()
    {
        // Add a route first
        $this->conn->query("INSERT INTO routes (route_cities, bus_no, route_dep_date, route_dep_time, route_step_cost) VALUES ('Hanoi, Haiphong', 'BUS-001', '2024-12-01', '10:00', 500000)");

        // Simulate form submission for deleting
        $_SESSION['loggedIn'] = true;
        $_POST = [
            'delete' => true,
            'id' => 1
        ];

        ob_start();
        include '../admin/routes.php';
        ob_end_clean();

        // Check if route is deleted
        $result = $this->conn->query("SELECT * FROM routes WHERE id=1");
        $this->assertEquals(0, $result->num_rows);
    }

    public function testAccessWithoutLogin()
    {
        $_SESSION['loggedIn'] = false;
        ob_start();
        include '../admin/routes.php';
        $output = ob_get_clean();
        
        // Ensure the page does not allow access without login
        $this->assertStringContainsString('login', $output);
    }
}
?>
