<?php
class Product {
    private $conn;

    // Set the database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Retrieve all products from the database
    public function getAllProducts() {
        $query = "SELECT Product_ID, Name, Price, Category, Stock, Image, Description FROM product";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Search for products by name, description, or category
    public function searchProducts($searchTerm) {
        $searchTerm = '%' . $searchTerm . '%';
        
        $query = "SELECT Product_ID, Name, Price, Category, Stock, Image, Description 
                  FROM product 
                  WHERE Name LIKE :search 
                  OR Description LIKE :search 
                  OR Category LIKE :search";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":search", $searchTerm);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Retrieve a single product by its ID
    public function getProductById($product_id) {
        $query = "SELECT Product_ID, Name, Price, Category, Stock, Image, Description FROM product WHERE Product_ID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $product_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Add a new product to the database
    public function addProduct($name, $price, $category, $stock, $admin_id, $image, $description) {
        $query = "INSERT INTO product (Name, Price, Category, Stock, Admin_Admin_ID, Image, Description) 
                  VALUES (:name, :price, :category, :stock, :admin_id, :image, :description)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":price", $price);
        $stmt->bindParam(":category", $category);
        $stmt->bindParam(":stock", $stock);
        $stmt->bindParam(":admin_id", $admin_id);
        $stmt->bindParam(":image", $image);
        $stmt->bindParam(":description", $description);
        return $stmt->execute();
    }
}
?>
