<?php
require_once "Person.php";

class User extends Person {
    private $email;
    private $password;

    // Constructor to initialize user properties and hash the password
    public function __construct($db, $email, $password, $first_name, $last_name) {
        parent::__construct($db, $first_name, $last_name);
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    // Method to register a new user into the database
    public function register() {
        // Check if the provided email already exists in the database
        $checkQuery = "SELECT * FROM user WHERE Email = :email";
        $checkStmt = $this->conn->prepare($checkQuery);
        $checkStmt->bindParam(":email", $this->email);
        $checkStmt->execute();
        
        if ($checkStmt->rowCount() > 0) {
            // Email already exists, registration fails
            return false; 
        }

        // Insert the new user's information into the database
        $query = "INSERT INTO user (Email, Password, First_Name, Last_Name) 
                  VALUES (:email, :password, :first_name, :last_name)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":first_name", $this->getFirstName());
        $stmt->bindParam(":last_name", $this->getLastName());

        // Execute the insert statement and return success status
        if ($stmt->execute()) {
            return true; 
        } else {
            // Output SQL error information for debugging
            print_r($stmt->errorInfo()); 
            return false;
        }
    }

    // Method to authenticate a user during login
    public function login($email, $password) {
        // Retrieve the user record matching the provided email
        $query = "SELECT * FROM user WHERE Email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Verify the provided password against the hashed password stored
        if ($user && password_verify($password, $user['Password'])) {
            return $user; // Return user details if authentication is successful
        }
        return false; // Return false if authentication fails
    }
}
?>
