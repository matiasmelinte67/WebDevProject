<?php
session_start();
require_once __DIR__ . '/../data/db_connect.php';
require_once "classes/Admin.php";
require_once "classes/Product.php";

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$database = new Database();
$db = $database->connect();
$admin = new Admin($db, "", "");

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create_product':
                $admin->createProduct(
                    $_POST['name'],
                    $_POST['price'],
                    $_POST['category'],
                    $_POST['stock'],
                    $_POST['image'],
                    $_POST['description']
                );
                break;
            
            case 'update_product':
                $admin->updateProduct($_POST['product_id'], [
                    'name' => $_POST['name'],
                    'price' => $_POST['price'],
                    'category' => $_POST['category'],
                    'stock' => $_POST['stock'],
                    'image' => $_POST['image'],
                    'description' => $_POST['description']
                ]);
                break;
            
            case 'delete_product':
                $admin->deleteProduct($_POST['product_id']);
                break;
            
            case 'update_user':
                $admin->updateUser($_POST['user_id'], [
                    'email' => $_POST['email'],
                    'first_name' => $_POST['first_name'],
                    'last_name' => $_POST['last_name']
                ]);
                break;
            
            case 'delete_user':
                $admin->deleteUser($_POST['user_id']);
                break;
        }
        // Redirect to refresh the page after any action
        header("Location: admin_dashboard.php");
        exit();
    }
}

// Get all products and users for display
$products = (new Product($db))->getAllProducts();
$users = $admin->getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - The3Guys PC Shop</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
        <nav class="navbar">
            <a href="index.php">Main Site</a>
            <a href="admin_dashboard.php">Dashboard</a>
            <a href="admin_logout.php">Logout</a>
        </nav>
    </header>

    <main class="admin-dashboard">
        <!-- Products Section -->
        <section id="products">
            <h2>Manage Products</h2>
            
            <!-- Add Product Form -->
            <div class="form-container">
                <h3>Add New Product</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="create_product">
                    <input type="text" name="name" placeholder="Product Name" required>
                    <input type="number" name="price" placeholder="Price" step="0.01" required>
                    <input type="text" name="category" placeholder="Category" required>
                    <input type="number" name="stock" placeholder="Stock" required>
                    <input type="text" name="image" placeholder="Image URL" required>
                    <textarea name="description" placeholder="Description" required></textarea>
                    <button type="submit">Add Product</button>
                </form>
            </div>

            <!-- Products Table -->
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['Product_ID']); ?></td>
                        <td><?php echo htmlspecialchars($product['Name']); ?></td>
                        <td>€<?php echo number_format($product['Price'], 2); ?></td>
                        <td><?php echo htmlspecialchars($product['Category']); ?></td>
                        <td><?php echo htmlspecialchars($product['Stock']); ?></td>
                        <td>
                            <button onclick="editProduct(<?php echo $product['Product_ID']; ?>, 
                                '<?php echo htmlspecialchars($product['Name']); ?>',
                                <?php echo $product['Price']; ?>,
                                '<?php echo htmlspecialchars($product['Category']); ?>',
                                <?php echo $product['Stock']; ?>,
                                '<?php echo htmlspecialchars($product['Image']); ?>',
                                '<?php echo htmlspecialchars($product['Description']); ?>'
                            )">Edit</button>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="delete_product">
                                <input type="hidden" name="product_id" value="<?php echo $product['Product_ID']; ?>">
                                <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <!-- Users Section -->
        <section id="users">
            <h2>Manage Users</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['User_ID']); ?></td>
                        <td><?php echo htmlspecialchars($user['Email']); ?></td>
                        <td><?php echo htmlspecialchars($user['First_Name'] . ' ' . $user['Last_Name']); ?></td>
                        <td>
                            <button onclick="editUser(<?php echo $user['User_ID']; ?>,
                                '<?php echo htmlspecialchars($user['Email']); ?>',
                                '<?php echo htmlspecialchars($user['First_Name']); ?>',
                                '<?php echo htmlspecialchars($user['Last_Name']); ?>'
                            )">Edit</button>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="delete_user">
                                <input type="hidden" name="user_id" value="<?php echo $user['User_ID']; ?>">
                                <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>

    <!-- Edit Product Modal -->
    <div id="editProductModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Product</h2>
            <form method="POST">
                <input type="hidden" name="action" value="update_product">
                <input type="hidden" name="product_id" id="edit_product_id">
                <input type="text" name="name" id="edit_name" placeholder="Product Name" required>
                <input type="number" name="price" id="edit_price" placeholder="Price" step="0.01" required>
                <input type="text" name="category" id="edit_category" placeholder="Category" required>
                <input type="number" name="stock" id="edit_stock" placeholder="Stock" required>
                <input type="text" name="image" id="edit_image" placeholder="Image URL" required>
                <textarea name="description" id="edit_description" placeholder="Description" required></textarea>
                <button type="submit">Update Product</button>
            </form>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="editUserModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit User</h2>
            <form method="POST">
                <input type="hidden" name="action" value="update_user">
                <input type="hidden" name="user_id" id="edit_user_id">
                <input type="email" name="email" id="edit_user_email" placeholder="Email" required>
                <input type="text" name="first_name" id="edit_user_first_name" placeholder="First Name" required>
                <input type="text" name="last_name" id="edit_user_last_name" placeholder="Last Name" required>
                <button type="submit">Update User</button>
            </form>
        </div>
    </div>

<script>
    const productModal = document.getElementById('editProductModal');
    const userModal = document.getElementById('editUserModal');
    const spans = document.getElementsByClassName('close');

    // Close modal when clicking (x)
    for (let span of spans) {
        span.onclick = function() {
            hideModals();
        }
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target == productModal || event.target == userModal) {
            hideModals();
        }
    }

    // Hide all modals
    function hideModals() {
        productModal.classList.remove('show');
        userModal.classList.remove('show');
        setTimeout(() => {
            productModal.style.display = "none";
            userModal.style.display = "none";
        }, 300);
    }

    function editProduct(id, name, price, category, stock, image, description) {
        document.getElementById('edit_product_id').value = id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_price').value = price;
        document.getElementById('edit_category').value = category;
        document.getElementById('edit_stock').value = stock;
        document.getElementById('edit_image').value = image;
        document.getElementById('edit_description').value = description;
        
        // Show the modal with animation
        productModal.style.display = "block";
        setTimeout(() => {
            productModal.classList.add('show');
        }, 10);
    }

    function editUser(id, email, firstName, lastName) {
        document.getElementById('edit_user_id').value = id;
        document.getElementById('edit_user_email').value = email;
        document.getElementById('edit_user_first_name').value = firstName;
        document.getElementById('edit_user_last_name').value = lastName;
        
        // Show the modal with animation
        userModal.style.display = "block";
        setTimeout(() => {
            userModal.classList.add('show');
        }, 10);
    }

    // Hide modals on page load
    hideModals();
</script>
</body>
</html>