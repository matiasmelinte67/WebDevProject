<?php
class Payment {
    private $conn;

    public function __construct($db) {
        $this->conn = $db; 
    }

    // Process a payment by inserting a new payment record
    public function processPayment($order_id, $method, $shipping, $product_id = NULL) {
        $query = "INSERT INTO payment (Payment_Method, Shipping, Order_Order_ID, Order_Product_Product_ID) 
                  VALUES (:method, :shipping, :order_id, :product_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":method", $method);
        $stmt->bindParam(":shipping", $shipping);
        $stmt->bindParam(":order_id", $order_id, PDO::PARAM_INT);
        $stmt->bindParam(":product_id", $product_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Delete a payment record by the associated order ID
    public function deletePaymentByOrderId($order_id) {
        $query = "DELETE FROM payment WHERE Order_Order_ID = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":order_id", $order_id);
        return $stmt->execute();
    }

    // Handle the full checkout process including order creation and payment
    public function processCheckout($user_id, $cart_data, $payment_method, $shipping_address, $order) {
        if (empty($cart_data)) {
            return "Error: No items in the cart.";
        }

        $total_amount = array_reduce($cart_data, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0); // Calculate total cart amount

        if ($order->createOrder($user_id, $total_amount)) {
            $order_id = $this->conn->lastInsertId(); // Get the created order ID

            if ($this->processPayment($order_id, $payment_method, $shipping_address)) {
                return $order_id; // Return the new order ID if payment succeeded
            } else {
                return "Payment processing failed.";
            }
        } else {
            return "Order creation failed.";
        }
    }
}
?>
