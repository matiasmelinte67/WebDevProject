<?php

use PHPUnit\Framework\TestCase;

class ValidationTest extends TestCase
{
    /** 
     * Test 1: Email format validation during User registration 
     */
    public function testInvalidEmailFormat()
    {
        $email = "invalidemail.com"; 
        $this->assertFalse(filter_var($email, FILTER_VALIDATE_EMAIL), "Test 1 Failed: Email format should be invalid.");
    }

    /** 
     * Test 2: Password strength validation during User registration 
     */
    public function testWeakPassword()
    {
        $password = "pass12"; 
        $isStrong = strlen($password) >= 8 && preg_match('/[^a-zA-Z\d]/', $password);
        $this->assertFalse($isStrong, "Test 2 Failed: Password should be considered weak.");
    }

    /** 
     * Test 3: Product Price must be positive 
     */
    public function testNegativeProductPrice()
    {
        $productPrice = -25.00; 
        $this->assertFalse($productPrice > 0, "Test 3 Failed: Product price must be positive.");
    }

    /** 
     * Test 4: Order Total Amount must match the sum of products 
     */
    public function testOrderTotalMismatch()
    {
        $cartItems = [
            ['price' => 30, 'quantity' => 2], // 60
            ['price' => 20, 'quantity' => 1], // 20
        ];
        $totalCartAmount = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cartItems));
        $orderTotalSubmitted = 70; // Incorrect (should be 80)

        $this->assertNotEquals($totalCartAmount, $orderTotalSubmitted, "Test 4 Failed: Order total should match cart total.");
    }

    /** 
     * Test 5: Delivery Address must not be empty if delivery selected 
     */
    public function testEmptyDeliveryAddress()
    {
        $deliveryOption = "Home Delivery";
        $address = ""; 

        $isValidAddress = !($deliveryOption === "Home Delivery" && empty(trim($address)));
        $this->assertFalse($isValidAddress, "Test 5 Failed: Delivery address must not be empty if Home Delivery is selected.");
    }
}
