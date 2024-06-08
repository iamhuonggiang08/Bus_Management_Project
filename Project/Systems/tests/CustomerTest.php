// tests/CustomerTest.php
<?php
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    protected $conn;

    protected function setUp(): void
    {
        require 'config_test.php';
        $this->conn = $conn;
        $this->createTestTable();
    }

    protected function tearDown(): void
    {
        $this->dropTestTable();
        $this->conn->close();
    }

    private function createTestTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS customers (
            id INT AUTO_INCREMENT PRIMARY KEY,
            customer_id VARCHAR(255) NOT NULL,
            customer_name VARCHAR(255) NOT NULL,
            customer_phone VARCHAR(255) NOT NULL,
            customer_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $this->conn->query($sql);
    }

    private function dropTestTable()
    {
        $this->conn->query("DROP TABLE IF EXISTS customers");
    }

    public function testAddCustomer()
    {
        // Simulate form submission
        $_POST = [
            'submit' => true,
            'cfirstname' => 'John',
            'clastname' => 'Doe',
            'cphone' => '1234567890'
        ];

        ob_start();
        include '../admin/customers.php';
        $output = ob_get_clean();

        // Check if customer is added
        $result = $this->conn->query("SELECT * FROM customers WHERE customer_name='John Doe'");
        $this->assertEquals(1, $result->num_rows);
    }

    public function testEditCustomer()
    {
        // Add a customer first
        $this->conn->query("INSERT INTO customers (customer_id, customer_name, customer_phone) VALUES ('CUST-1', 'Jane Doe', '0987654321')");

        // Simulate form submission for editing
        $_POST = [
            'edit' => true,
            'id' => 'CUST-1',
            'cname' => 'Jane Smith',
            'cphone' => '0987654321'
        ];

        ob_start();
        include '../admin/customers.php';
        $output = ob_get_clean();

        // Check if customer is edited
        $result = $this->conn->query("SELECT * FROM customers WHERE customer_name='Jane Smith'");
        $this->assertEquals(1, $result->num_rows);
    }

    public function testDeleteCustomer()
    {
        // Add a customer first
        $this->conn->query("INSERT INTO customers (customer_id, customer_name, customer_phone) VALUES ('CUST-1', 'Jane Doe', '0987654321')");

        // Simulate form submission for deleting
        $_POST = [
            'delete' => true,
            'id' => 1
        ];

        ob_start();
        include '../admin/customers.php';
        $output = ob_get_clean();

        // Check if customer is deleted
        $result = $this->conn->query("SELECT * FROM customers WHERE customer_id='CUST-1'");
        $this->assertEquals(0, $result->num_rows);
    }
}
?>
