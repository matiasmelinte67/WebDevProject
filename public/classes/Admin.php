<?php
require_once "Person.php"; 

class Admin extends Person {

    // Create a new product and insert it into the database
    public function createProduct($name, $price, $category, $stock, $image, $description) {
        $query = "INSERT INTO product (Name, Price, Category, Stock, Image, Description, Admin_Admin_ID) 
                  VALUES (:name, :price, :category, :stock, :image, :description, :admin_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":price", $price);
        $stmt->bindParam(":category", $category);
        $stmt->bindParam(":stock", $stock);
        $stmt->bindParam(":image", $image);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":admin_id", $_SESSION['admin_id']);
        return $stmt->execute();
    }

    // Update an existing product's information
    public function updateProduct($product_id, $data) {
        $query = "UPDATE product SET 
                  Name = :name,
                  Price = :price,
                  Category = :category,
                  Stock = :stock,
                  Image = :image,
                  Description = :description
                  WHERE Product_ID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $data['name']);
        $stmt->bindParam(":price", $data['price']);
        $stmt->bindParam(":category", $data['category']);
        $stmt->bindParam(":stock", $data['stock']);
        $stmt->bindParam(":image", $data['image']);
        $stmt->bindParam(":description", $data['description']);
        $stmt->bindParam(":id", $product_id);
        return $stmt->execute();
    }

    // Delete a product by its ID
    public function deleteProduct($product_id) {
        $query = "DELETE FROM product WHERE Product_ID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $product_id);
        return $stmt->execute();
    }

    // Retrieve a list of all users
    public function getAllUsers() {
        $query = "SELECT User_ID, Email, First_Name, Last_Name FROM user";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update a user's information
    public function updateUser($user_id, $data) {
        $query = "UPDATE user SET 
                  Email = :email,
                  First_Name = :first_name,
                  Last_Name = :last_name
                  WHERE User_ID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $data['email']);
        $stmt->bindParam(":first_name", $data['first_name']);
        $stmt->bindParam(":last_name", $data['last_name']);
        $stmt->bindParam(":id", $user_id);
        return $stmt->execute();
    }

    // Delete a user by their ID
    public function deleteUser($user_id) {
        $query = "DELETE FROM user WHERE User_ID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $user_id);
        return $stmt->execute();
    }

    // Authenticate an admin during login
    public function login($email, $password) {
        $query = "SELECT * FROM admin WHERE Email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['Password'])) {
            return $admin;
        }
        return false;
    }
}
?>
