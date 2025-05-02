<?php
class Person {
    protected $conn;
    protected $first_name;
    protected $last_name;

    // Initialize the person with database connection and names
    public function __construct($db, $first_name, $last_name) {
        $this->conn = $db;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
    }

    // Get the person's first name
    public function getFirstName() {
        return $this->first_name;
    }

    // Get the person's last name
    public function getLastName() {
        return $this->last_name;
    }

    // Get the person's full name
    public function getFullName() {
        return $this->first_name . " " . $this->last_name;
    }
}
?>
