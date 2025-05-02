<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../classes/Admin.php';

class AdminTest extends TestCase {
    private $pdoMock;
    private $stmtMock;

    protected function setUp(): void {
        // Mock the PDO and PDOStatement classes
        $this->pdoMock = $this->createMock(PDO::class);
        $this->stmtMock = $this->createMock(PDOStatement::class);

        // Start a mock session for testing
        $_SESSION = [];
        $_SESSION['admin_id'] = 1; // Mock admin ID
    }

    public function testCreateProductReturnsTrueOnSuccess() {
        // Mock the behavior of the PDOStatement
        $this->stmtMock->method('execute')->willReturn(true);

        // Mock the behavior of the PDO object
        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);

        // Create an instance of the Admin class
        $admin = new Admin($this->pdoMock, 'admin_username', 'admin_password');

        // Call the createProduct method
        $result = $admin->createProduct('Product 1', 100.0, 'Category 1', 10, 'image.jpg', 'Description of Product 1');

        // Assert that the returned value is true
        $this->assertTrue($result);
    }

    public function testUpdateProductReturnsTrueOnSuccess() {
        // Mock the behavior of the PDOStatement
        $this->stmtMock->method('execute')->willReturn(true);

        // Mock the behavior of the PDO object
        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);

        // Create an instance of the Admin class
        $admin = new Admin($this->pdoMock, 'admin_username', 'admin_password');

        // Call the updateProduct method
        $data = [
            'name' => 'Updated Product',
            'price' => 150.0,
            'category' => 'Updated Category',
            'stock' => 20,
            'image' => 'updated_image.jpg',
            'description' => 'Updated description',
        ];
        $result = $admin->updateProduct(1, $data);

        // Assert that the returned value is true
        $this->assertTrue($result);
    }

    public function testDeleteProductReturnsTrueOnSuccess() {
        // Mock the behavior of the PDOStatement
        $this->stmtMock->method('execute')->willReturn(true);

        // Mock the behavior of the PDO object
        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);

        // Create an instance of the Admin class
        $admin = new Admin($this->pdoMock, 'admin_username', 'admin_password');

        // Call the deleteProduct method
        $result = $admin->deleteProduct(1);

        // Assert that the returned value is true
        $this->assertTrue($result);
    }
}