<?php include 'includes/header.php'; ?>

<main>
    <h1>Your Shopping Cart</h1>

    <div id="cart-items">
        <!-- Cart items will be loaded via JavaScript -->
    </div>

    <div class="checkout-button-container" style="margin-top: 20px; text-align: center;">
        <button id="checkout-button" class="btn" style="background-color: #6b46c1;">Proceed to Checkout</button>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', () => {
    loadCart();
    
    // Add event listener to checkout button
    document.getElementById('checkout-button').addEventListener('click', function() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        
        if (cart.length === 0) {
            alert("Your cart is empty. Please add items before proceeding.");
            return;
        }

        // Redirect to checkout and ensure cart data is still available
        window.location.href = 'checkout.php';
    });
});

function loadCart() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartItems = document.getElementById('cart-items');
    let total = 0;
    let itemsHTML = '';

    if (cart.length > 0) {
        itemsHTML += '<div class="cart-items-container">';
        
        cart.forEach((item, index) => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;
            itemsHTML += `
                <div class="cart-item" style="display:flex; justify-content:space-between; margin-bottom:10px; padding:10px; background-color:#f9f9f9; border-radius:5px;">
                    <div>
                        <p><strong>${item.name}</strong></p>
                        <p>Price: €${item.price.toFixed(2)} × ${item.quantity} = <strong>€${itemTotal.toFixed(2)}</strong></p>
                    </div>
                    <div>
                        <button onclick="confirmRemove(${index})" style="background-color:#f44336; color:white; border:none; padding:5px 10px; border-radius:3px; cursor:pointer;">
                            Remove
                        </button>
                    </div>
                </div>
            `;
        });

        itemsHTML += `
            <div style="margin-top:20px; text-align:right; font-weight:bold;">
                Total: €${total.toFixed(2)}
            </div>
        </div>`;
    } else {
        itemsHTML = '<p>Your cart is empty.</p>';
        document.getElementById('checkout-button').disabled = true;
        document.getElementById('checkout-button').style.opacity = '0.5';
    }
    
    cartItems.innerHTML = itemsHTML;
}

function confirmRemove(index) {
    if (confirm("Are you sure you want to remove this item from your cart?")) {
        removeFromCart(index);
    }
}

function removeFromCart(index) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cart));
    loadCart();
}
</script>
