<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../classes/Person.php';
require_once __DIR__ . '/../classes/User.php';

class UserTest extends TestCase {
    private $dbMock;

    protected function setUp(): void {
        // Create a mock for the PDO class
        $this->dbMock = $this->createMock(PDO::class);
    }

    public function testUserIsInstanceOfPerson() {
        $user = new User($this->dbMock, "test@example.com", "password123", "John", "Doe");

        $this->assertInstanceOf(Person::class, $user);
    }

    public function testInheritedGetFirstName() {
        $user = new User($this->dbMock, "test@example.com", "password123", "Alice", "Smith");

        $this->assertEquals("Alice", $user->getFirstName());
    }

    public function testInheritedGetLastName() {
        $user = new User($this->dbMock, "test@example.com", "password123", "Alice", "Smith");

        $this->assertEquals("Smith", $user->getLastName());
    }

    public function testInheritedGetFullName() {
        $user = new User($this->dbMock, "test@example.com", "password123", "Alice", "Smith");

        $this->assertEquals("Alice Smith", $user->getFullName());
    }
}
