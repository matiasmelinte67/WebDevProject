<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../classes/Payment.php';
require_once __DIR__ . '/../classes/Order.php';

class PaymentTest extends TestCase {
    private $pdoMock;
    private $stmtMock;

    protected function setUp(): void {
        $this->pdoMock = $this->createMock(PDO::class);
        $this->stmtMock = $this->createMock(PDOStatement::class);
    }

    public function testProcessPaymentReturnsTrueOnSuccess() {
        $this->stmtMock->method('execute')->willReturn(true);
        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);

        $payment = new Payment($this->pdoMock);
        $result = $payment->processPayment(1, 'Card', 'Home Delivery', 10);

        $this->assertTrue($result);
    }

    public function testDeletePaymentByOrderIdReturnsTrue() {
        $this->stmtMock->method('execute')->willReturn(true);
        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);

        $payment = new Payment($this->pdoMock);
        $result = $payment->deletePaymentByOrderId(5);

        $this->assertTrue($result);
    }

    public function testProcessCheckoutSuccess() {
        // Mock cart data
        $cart_data = [
            ['price' => 20, 'quantity' => 2], // total 40
            ['price' => 15, 'quantity' => 1], // total 15
        ];
    
        // Mock order object
        $orderMock = $this->createMock(Order::class);
        $orderMock->method('createOrder')->willReturn(true);
    
        // Mock database insert and lastInsertId
        $this->stmtMock->method('execute')->willReturn(true);
        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);
        $this->pdoMock->method('lastInsertId')->willReturn("123"); // Return a string instead of an int
    
        $payment = new Payment($this->pdoMock);
        $result = $payment->processCheckout(1, $cart_data, 'Credit Card', '123 Main St', $orderMock);
    
        $this->assertEquals(123, (int)$result); // Cast the result to int for comparison
    }
    public function testProcessCheckoutFailsWithEmptyCart() {
        $payment = new Payment($this->pdoMock);
        $result = $payment->processCheckout(1, [], 'Credit Card', '123 Main St', $this->createMock(stdClass::class));
        $this->assertEquals("Error: No items in the cart.", $result);
    }
}
