<?php
class Order {
    private $conn;
    private $table = "`order`";

    public function __construct($db) {
        $this->conn = $db; 
    }

    // Create a new order with a default status of 'Pending'
    public function createOrder($user_id, $total_amount, $status = 'Pending') {
        $query = "INSERT INTO `order` (User_ID, Status, Order_Date, Order_History, Total_Amount) 
                  VALUES (:user_id, :status, NOW(), 'Created', :total_amount)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':total_amount', $total_amount, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId(); // Return new order ID if created successfully
        }
        return false;
    }

    // Add a product item to an existing order
    public function addOrderItem($order_id, $product_id, $quantity, $price) {
        $query = "INSERT INTO order_items (Order_ID, Product_ID, Quantity, Price) 
                  VALUES (:order_id, :product_id, :quantity, :price)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Get all orders sorted by most recent
    public function getAllOrders() {
        $query = "SELECT * FROM `order` ORDER BY Order_Date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all orders for a specific user
    public function getUserOrders($user_id) {
        $query = "SELECT * FROM `order` WHERE User_ID = :user_id ORDER BY Order_Date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get detailed information for a specific order
    public function getOrderDetails($order_id) {
        $query = "SELECT o.*, p.Name, p.Image, p.Description, oi.Quantity, oi.Price 
                  FROM `order` o
                  JOIN order_items oi ON o.Order_ID = oi.Order_ID
                  JOIN product p ON oi.Product_ID = p.Product_ID
                  WHERE o.Order_ID = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update the status of an existing order
    public function updateOrderStatus($order_id, $status) {
        $query = "UPDATE `order` SET Status = :status WHERE Order_ID = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
