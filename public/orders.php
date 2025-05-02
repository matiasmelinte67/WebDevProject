<?php 
include 'includes/header.php'; 
require_once __DIR__ . '/../data/db_connect.php';
require_once 'classes/Order.php';

$database = new Database();
$db = $database->connect();

// Create Order object
$orderObj = new Order($db);

// Add authentication check
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Get orders for the current user only
$orders = $orderObj->getUserOrders($user_id);
?>

<main>
    <div class="container" style="max-width: 1000px; margin: 0 auto; padding: 20px;">
        <h1>Your Order History</h1>

        <?php if ($orders && count($orders) > 0): ?>
            <div class="orders-list">
                <?php foreach ($orders as $order): ?>
                    <?php 
                    // Get order details including products
                    $order_items = $orderObj->getOrderDetails($order['Order_ID']);
                    
                    // Format date
                    $order_date = new DateTime($order['Order_Date']);
                    $formatted_date = $order_date->format('F j, Y, g:i a');
                    
                    // Get status class
                    $status_class = '';
                    switch($order['Status']) {
                        case 'Pending':
                            $status_class = 'bg-yellow-200';
                            break;
                        case 'Processing':
                            $status_class = 'bg-blue-200';
                            break;
                        case 'Shipped':
                            $status_class = 'bg-purple-200';
                            break;
                        case 'Delivered':
                            $status_class = 'bg-green-200';
                            break;
                        case 'Cancelled':
                            $status_class = 'bg-red-200';
                            break;
                        default:
                            $status_class = 'bg-gray-200';
                    }
                    ?>
                    
                    <div class="order-card" style="margin-bottom: 20px; border: 1px solid #ddd; border-radius: 5px; overflow: hidden;">
                        <div class="order-header" style="display: flex; justify-content: space-between; padding: 15px; background-color: #f5f5f5; align-items: center;">
                            <div>
                                <h3 style="margin: 0;">Order #<?php echo $order['Order_ID']; ?></h3>
                                <p style="margin: 5px 0 0 0; color: #666;"><?php echo $formatted_date; ?></p>
                            </div>
                            <div>
                                <span class="status-badge <?php echo $status_class; ?>" style="padding: 5px 10px; border-radius: 20px; font-size: 14px;"><?php echo $order['Status']; ?></span>
                            </div>
                        </div>
                        
                        <div class="order-items" style="padding: 15px;">
                            <?php foreach ($order_items as $item): ?>
                                <div class="order-item" style="display: flex; padding: 10px 0; border-bottom: 1px solid #eee;">
                                    <div class="item-image" style="width: 80px; margin-right: 15px;">
                                        <img src="<?php echo $item['Image']; ?>" alt="<?php echo $item['Name']; ?>" style="width: 100%; height: auto; border-radius: 4px;">
                                    </div>
                                    <div class="item-details" style="flex-grow: 1;">
                                        <h4 style="margin: 0 0 5px 0;"><?php echo $item['Name']; ?></h4>
                                        <p style="margin: 0; color: #666;">
                                            <?php echo $item['Quantity']; ?> × €<?php echo number_format($item['Price'], 2); ?>
                                        </p>
                                    </div>
                                    <div class="item-price" style="text-align: right;">
                                        €<?php echo number_format($item['Price'] * $item['Quantity'], 2); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="order-footer" style="display: flex; justify-content: space-between; padding: 15px; background-color: #f9f9f9; align-items: center;">
                            <div>
                                <a href="order_confirmation.php?order_id=<?php echo $order['Order_ID']; ?>" style="color: #6b46c1; text-decoration: none;">View Order Details</a>
                            </div>
                            <div style="font-weight: bold; font-size: 18px;">
                                Total: €<?php echo number_format($order['Total_Amount'], 2); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 40px 20px;">
                <div style="font-size: 60px; color: #ddd; margin-bottom: 20px;">📦</div>
                <h2>No orders yet</h2>
                <p>You haven't placed any orders yet. Start shopping to see your order history here.</p>
                <a href="products.php" class="btn" style="display: inline-block; margin-top: 20px; background-color: #6b46c1; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Browse Products</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>