<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../classes/Order.php';

class OrderTest extends TestCase {
    private $pdoMock;
    private $stmtMock;

    protected function setUp(): void {
        // Mock the PDO and PDOStatement classes
        $this->pdoMock = $this->createMock(PDO::class);
        $this->stmtMock = $this->createMock(PDOStatement::class);
    }

    public function testCreateOrderReturnsOrderIdOnSuccess() {
        // Mock the behavior of the PDOStatement
        $this->stmtMock->method('execute')->willReturn(true);

        // Mock the behavior of the PDO object
        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);
        $this->pdoMock->method('lastInsertId')->willReturn("123"); // Return a string as expected

        // Create an instance of the Order class
        $order = new Order($this->pdoMock);

        // Call the createOrder method
        $result = $order->createOrder(1, "100.50", "Pending");

        // Assert that the returned value matches the mocked lastInsertId
        $this->assertEquals("123", $result);
    }

    public function testCreateOrderReturnsFalseOnFailure() {
        // Mock the behavior of the PDOStatement to simulate a failure
        $this->stmtMock->method('execute')->willReturn(false);

        // Mock the behavior of the PDO object
        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);

        // Create an instance of the Order class
        $order = new Order($this->pdoMock);

        // Call the createOrder method
        $result = $order->createOrder(1, "100.50", "Pending");

        // Assert that the returned value is false
        $this->assertFalse($result);
    }
}