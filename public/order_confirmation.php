<?php 
include 'includes/header.php'; 
require_once __DIR__ . '/../data/db_connect.php';
require_once 'classes/Order.php';
require_once 'classes/Product.php';

$db = new Database();
$conn = $db->connect();

$order = new Order($conn);
$product = new Product($conn);

// Check if order_id is set in URL
if (!isset($_GET['order_id'])) {
    header("Location: index.php");
    exit();
}

$order_id = $_GET['order_id'];

// Get order details (now supports multiple products)
$order_items = $order->getOrderDetails($order_id);

// Get payment details
$query = "SELECT * FROM payment WHERE Order_Order_ID = :order_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':order_id', $order_id);
$stmt->execute();
$payment_details = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if order exists
if (empty($order_items)) {
    echo "<p>Order not found.</p>";
    include 'includes/footer.php';
    exit();
}

// Basic order info (will be same for all items)
$order_details = $order_items[0];

// Format date
$order_date = new DateTime($order_details['Order_Date']);
$formatted_date = $order_date->format('F j, Y, g:i a');

// Calculate total
$total = 0;
foreach ($order_items as $item) {
    $total += ($item['Price'] * $item['Quantity']);
}
?>

<main>
    <div class="confirmation-container" style="max-width: 800px; margin: 0 auto; padding: 20px;">
        <div class="confirmation-header" style="text-align: center; margin-bottom: 20px;">
            <h1>Order Confirmation</h1>
            <div class="success-icon" style="margin: 20px auto; width: 80px; height: 80px; background-color: #4CAF50; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <span style="color: white; font-size: 40px;">✓</span>
            </div>
            <p style="font-size: 1.2rem;">Thank you for your order!</p>
            <p>Your order has been successfully placed and is being processed.</p>
        </div>

        <div class="order-details" style="margin: 30px 0; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
            <h2>Order Summary</h2>
            <p><strong>Order Number:</strong> #<?php echo $order_details['Order_ID']; ?></p>
            <p><strong>Date:</strong> <?php echo $formatted_date; ?></p>
            <p><strong>Status:</strong> <?php echo $order_details['Status']; ?></p>
            
            <h3 style="margin-top: 20px;">Purchased Items</h3>
            
            <?php foreach ($order_items as $item): ?>
            <div class="order-item" style="display: flex; margin: 10px 0; padding: 10px; background-color: #f9f9f9; border-radius: 5px;">
                <div class="item-image" style="width: 100px; margin-right: 20px;">
                    <img src="<?php echo $item['Image']; ?>" alt="<?php echo $item['Name']; ?>" style="width: 100%; height: auto;">
                </div>
                <div class="item-details">
                    <h4 style="margin: 0 0 10px 0;"><?php echo $item['Name']; ?></h4>
                    <p><strong>Price:</strong> €<?php echo number_format($item['Price'], 2); ?></p>
                    <p><strong>Quantity:</strong> <?php echo $item['Quantity']; ?></p>
                    <p><strong>Subtotal:</strong> €<?php echo number_format($item['Price'] * $item['Quantity'], 2); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
            
            <div style="margin-top: 20px; text-align: right; font-weight: bold; font-size: 1.2rem;">
                Total: €<?php echo number_format($order_details['Total_Amount'], 2); ?>
            </div>
        </div>

        <div class="shipping-details" style="margin: 30px 0; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
            <h2>Shipping Details</h2>
            <p><?php echo $payment_details['Shipping']; ?></p>
            <p><strong>Payment Method:</strong> <?php echo $payment_details['Payment_Method']; ?></p>
        </div>

        <div class="confirmation-actions" style="margin-top: 30px; text-align: center;">
            <a href="products.php" class="btn" style="background-color: #6b46c1; color: white; padding: 10px 20px; text-decoration: none; margin-right: 10px; border-radius: 5px;">Continue Shopping</a>
            <a href="orders.php" class="btn" style="background-color: #333; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">View All Orders</a>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>