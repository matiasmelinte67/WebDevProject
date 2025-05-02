<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../classes/Product.php';

class ProductTest extends TestCase {
    private $pdoMock;
    private $stmtMock;

    protected function setUp(): void {
        // Mock the PDO and PDOStatement classes
        $this->pdoMock = $this->createMock(PDO::class);
        $this->stmtMock = $this->createMock(PDOStatement::class);
    }

    public function testGetAllProductsReturnsProducts() {
        // Mock the behavior of the PDOStatement
        $this->stmtMock->method('execute')->willReturn(true);
        $this->stmtMock->method('fetchAll')->willReturn([
            ['Product_ID' => 1, 'Name' => 'Product 1', 'Price' => 10.0],
            ['Product_ID' => 2, 'Name' => 'Product 2', 'Price' => 20.0],
        ]);

        // Mock the behavior of the PDO object
        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);

        // Create an instance of the Product class
        $product = new Product($this->pdoMock);

        // Call the getAllProducts method
        $result = $product->getAllProducts();

        // Assert that the returned value matches the mocked data
        $this->assertCount(2, $result);
        $this->assertEquals('Product 1', $result[0]['Name']);
    }

    public function testSearchProductsReturnsMatchingProducts() {
        // Mock the behavior of the PDOStatement
        $this->stmtMock->method('execute')->willReturn(true);
        $this->stmtMock->method('fetchAll')->willReturn([
            ['Product_ID' => 1, 'Name' => 'Product 1', 'Price' => 10.0],
        ]);

        // Mock the behavior of the PDO object
        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);

        // Create an instance of the Product class
        $product = new Product($this->pdoMock);

        // Call the searchProducts method
        $result = $product->searchProducts('Product 1');

        // Assert that the returned value matches the mocked data
        $this->assertCount(1, $result);
        $this->assertEquals('Product 1', $result[0]['Name']);
    }

    public function testGetProductByIdReturnsProduct() {
        // Mock the behavior of the PDOStatement
        $this->stmtMock->method('execute')->willReturn(true);
        $this->stmtMock->method('fetch')->willReturn([
            'Product_ID' => 1,
            'Name' => 'Product 1',
            'Price' => 10.0,
        ]);

        // Mock the behavior of the PDO object
        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);

        // Create an instance of the Product class
        $product = new Product($this->pdoMock);

        // Call the getProductById method
        $result = $product->getProductById(1);

        // Assert that the returned value matches the mocked data
        $this->assertEquals('Product 1', $result['Name']);
        $this->assertEquals(10.0, $result['Price']);
    }
}