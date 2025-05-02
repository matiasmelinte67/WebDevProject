let cart = JSON.parse(localStorage.getItem('cart')) || [];

document.addEventListener('DOMContentLoaded', () => {
    setupEventListeners();
    setupSearchFunctionality();
});

// ➕ Add to Cart
function addToCart(name, price) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let existingItem = cart.find(item => item.name === name);
    
    if (existingItem) {
        existingItem.quantity++;
    } else {
        cart.push({ name, price, quantity: 1 });
    }
    
    localStorage.setItem("cart", JSON.stringify(cart));
    
    // Show confirmation message
    showToast(`${name} added to cart!`);
}

// Show toast notification
function showToast(message) {
    // Create toast element if it doesn't exist
    let toast = document.getElementById('toast-notification');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'toast-notification';
        toast.style.position = 'fixed';
        toast.style.bottom = '20px';
        toast.style.right = '20px';
        toast.style.backgroundColor = '#6b46c1';
        toast.style.color = 'white';
        toast.style.padding = '10px 20px';
        toast.style.borderRadius = '5px';
        toast.style.zIndex = '1000';
        toast.style.boxShadow = '0 2px 5px rgba(0,0,0,0.2)';
        document.body.appendChild(toast);
    }
    
    // Set message and show toast
    toast.textContent = message;
    toast.style.display = 'block';
    
    // Hide toast after 3 seconds
    setTimeout(() => {
        toast.style.display = 'none';
    }, 3000);
}

// ✅ Setup event listeners for "Add to Cart" buttons
function setupEventListeners() {
    // Handle "Add to Cart" buttons on product page
    const addToCartButtons = document.querySelectorAll(".add-to-cart");
    if (addToCartButtons.length > 0) {
        addToCartButtons.forEach(button => {
            button.addEventListener("click", function(e) {
                e.preventDefault(); // Prevent default button action
                const productCard = this.closest('.product-card');
                const productName = productCard.querySelector('.product-name').textContent;
                const productPrice = parseFloat(productCard.querySelector('.product-price').textContent.replace('€', ''));
                addToCart(productName, productPrice);
            });
        });
    }
}

// 🔍 Setup search functionality
function setupSearchFunctionality() {
    const searchForm = document.querySelector('.search-container');
    const searchInput = searchForm.querySelector('input[type="search"]');
    
    // Enable pressing Enter to submit the search
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            searchForm.submit();
        }
    });
    
    // Add clear search button functionality
    const clearSearchLinks = document.querySelectorAll('.search-results-info a');
    if (clearSearchLinks.length > 0) {
        clearSearchLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                window.location.href = this.getAttribute('href');
            });
        });
    }

}

// Helper function for debouncing (used for search suggestions)
function debounce(func, delay) {
    let timeout;
    return function() {
        const context = this;
        const args = arguments;
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(context, args), delay);
    };
}

