<?php 
include 'includes/header.php'; 
require_once __DIR__ . '/../data/db_connect.php';
require_once __DIR__ . "/classes/Product.php";

// Establish database connection
$database = new Database();
$db = $database->connect();

// Create Product object
$productObj = new Product($db);

// Check if search query exists
$searchQuery = isset($_GET['query']) ? $_GET['query'] : '';

// Get products (filtered by search if query exists)
if (!empty($searchQuery)) {
    $products = $productObj->searchProducts($searchQuery);
} else {
    $products = $productObj->getAllProducts();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Collection</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/product.css">
</head>
<body>

<form class="search-container" role="search" method="GET" action="">
    <input 
        type="search" 
        name="query" 
        class="search-input" 
        placeholder="Search for brand, color, etc."
        aria-label="Search through site content"
        value="<?php echo htmlspecialchars($searchQuery); ?>"
    >
    <!-- No need to add a visible button as your CSS already has a magnifying glass icon -->
</form>

<?php if (!empty($searchQuery)): ?>
    <div class="search-results-info" style="text-align: center; margin: 10px 0 20px; padding: 10px;">
        <p>Search results for: <strong><?php echo htmlspecialchars($searchQuery); ?></strong> 
        (<?php echo count($products); ?> products found) | 
        <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="color: #000; text-decoration: underline;">Clear search</a>
        </p>
    </div>
<?php endif; ?>

<div class="container">
    <div class="products-grid">
        <?php
        if ($products && count($products) > 0) {
            foreach ($products as $product) {
                ?>
                <div class="product-card">
                    <div class="product-image">
                        <img src="<?php echo htmlspecialchars($product['Image']); ?>" 
                             alt="<?php echo htmlspecialchars($product['Name']); ?>">
                    </div>
                    <h2 class="product-name"><?php echo htmlspecialchars($product['Name']); ?></h2>
                    <p class="product-description"><?php echo htmlspecialchars($product['Description']); ?></p>
                    <p class="product-price">€<?php echo number_format($product['Price'], 2); ?></p>
                    <button class="add-to-cart" onclick="addToCart('<?php echo htmlspecialchars($product['Name']); ?>', <?php echo $product['Price']; ?>)">
                        Add to Cart
                    </button>
                </div>
                <?php
            }
        } else {
            echo "<p style='text-align: center; padding: 30px; font-size: 18px;'>No products found matching your search.</p>";
        }
        ?>
    </div>
</div>

<script src="js/script.js"></script>
</body>
</html>

<?php include 'includes/footer.php'; ?>