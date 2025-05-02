<?php 
include 'includes/header.php'; 
require_once __DIR__ . '/../data/db_connect.php';
include 'classes/Order.php';
include 'classes/Payment.php';

$db = new Database();
$conn = $db->connect();

$order = new Order($conn);
$payment = new Payment($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user ID (assuming user is logged in)
    $user_id = $_SESSION['user_id'] ?? 1; // Default to 1 if not logged in

    // Get billing and payment details
    $firstname = $_POST['firstname'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    
    $payment_method = "Credit Card"; // Modify if supporting multiple methods
    $shipping_address = "$address, $city, $state, $zip";

    // Retrieve cart data from form
    $cart_data = json_decode($_POST['cart_data'], true);

    // Validate cart data
    if (empty($cart_data) || !is_array($cart_data)) {
        die("Error: Invalid cart data.");
    }
    
    // Calculate total amount
    $total_amount = 0;
    foreach ($cart_data as $item) {
        if (!isset($item['name']) || !isset($item['price']) || !isset($item['quantity'])) {
            die("Error: Product data is incomplete.");
        }
        $total_amount += $item['price'] * $item['quantity'];
    }

    //Create Order (without Product_ID)
    $order_id = $order->createOrder($user_id, $total_amount, 'Pending');
    
    if ($order_id) {
        //Add each item to `order_items`
        $success = true;
        foreach ($cart_data as $item) {
            // Get product ID based on name
            $query = "SELECT Product_ID FROM product WHERE Name = :name LIMIT 1";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':name', $item['name']);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($product) {
                $product_id = $product['Product_ID'];
                $success = $order->addOrderItem($order_id, $product_id, $item['quantity'], $item['price']) && $success;
            } else {
                // Product not found, use default ID (for testing - should be handled properly)
                $product_id = 1;
                $success = $order->addOrderItem($order_id, $product_id, $item['quantity'], $item['price']) && $success;
            }
        }

        //Process Payment
        if ($success && $payment->processPayment($order_id, $payment_method, $shipping_address)) {
            //Redirect to Confirmation Page
            echo "<script>
                    localStorage.removeItem('cart');
                    window.location.href = 'order_confirmation.php?order_id=$order_id';
                  </script>";
            exit();
        } else {
            echo "<p style='color:red;'>Payment processing failed.</p>";
        }
    } else {
        echo "<p style='color:red;'>Order creation failed.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/checkout.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-75">
                <div class="checkout-container">
                    <form method="POST">
                        <!-- Order Summary Section -->
                        <div class="order-summary">
                            <h3>Order Summary</h3>
                            <div id="checkout-items"></div>
                            <hr>
                            <div id="checkout-total"></div>
                        </div>

                        <div class="row">
                            <div class="col-50">
                                <h3>Billing Address</h3>
                                <label for="fname">Full Name</label>
                                <input type="text" id="fname" name="firstname" required>

                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" required>

                                <label for="adr">Address</label>
                                <input type="text" id="adr" name="address" required>

                                <label for="city">City</label>
                                <input type="text" id="city" name="city" required>

                                <div class="row">
                                    <div class="col-50">
                                        <label for="state">State</label>
                                        <input type="text" id="state" name="state" required>
                                    </div>
                                    <div class="col-50">
                                        <label for="zip">Zip</label>
                                        <input type="text" id="zip" name="zip" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-50">
                                <h3>Payment</h3>
                                <label for="cname">Name on Card</label>
                                <input type="text" id="cname" name="cardname" required>

                                <label for="ccnum">Credit card number</label>
                                <input type="text" id="ccnum" name="cardnumber" required>

                                <label for="expmonth">Exp Month</label>
                                <input type="text" id="expmonth" name="expmonth" required>

                                <div class="row">
                                    <div class="col-50">
                                        <label for="expyear">Exp Year</label>
                                        <input type="text" id="expyear" name="expyear" required>
                                    </div>
                                    <div class="col-50">
                                        <label for="cvv">CVV</label>
                                        <input type="text" id="cvv" name="cvv" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <label>
                            <input type="checkbox" checked="checked" name="sameadr"> Shipping address same as billing
                        </label>

                        <input type="submit" value="Complete Purchase" class="btn">
                        <input type="hidden" name="cart_data" id="cart_data">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Wait until the full page content is loaded before running the script
    document.addEventListener('DOMContentLoaded', function() {
        // Retrieve the cart data from localStorage or initialize an empty array if none exists
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        
        // Get references to the checkout items and total display elements
        const checkoutItemsDiv = document.getElementById('checkout-items');
        const checkoutTotalDiv = document.getElementById('checkout-total');
        
        let itemsHTML = '';
        let total = 0;

        // Check if there are any items in the cart
        if (cart.length > 0) {
            // Loop through each item, calculate the total price, and build the HTML for display
            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                total += itemTotal;
                itemsHTML += `<div style="display:flex; justify-content:space-between; margin:5px 0;">
                                <span>${item.name} × ${item.quantity}</span>
                                <span>€${itemTotal.toFixed(2)}</span>
                              </div>`;
            });

            // Display the total amount at the bottom of the checkout summary
            checkoutTotalDiv.innerHTML = `<div style="display:flex; justify-content:space-between; font-weight:bold;">
                                            <span>Total:</span>
                                            <span>€${total.toFixed(2)}</span>
                                          </div>`;
        } else {
            // If the cart is empty, show a message encouraging the user to add items
            itemsHTML = '<p>Your cart is empty. Please add items before checkout.</p>';
        }

        // Insert the generated items HTML into the checkout items container
        checkoutItemsDiv.innerHTML = itemsHTML;

        // Store the cart data into a hidden input field for server-side processing if needed
        document.getElementById('cart_data').value = JSON.stringify(cart);
    });
</script>

</body>
</html>
