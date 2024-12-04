
const initialCart = [
    { name: 'Product Name', price: 20, quantity: 1, image: 'product-image.jpg' },
    { name: 'Another Product', price: 15, quantity: 2, image: 'product-image.jpg' }
];
localStorage.setItem('cartItems', JSON.stringify(initialCart));

function renderCart() {
    const cartContainer = document.querySelector(".cart");
    cartContainer.innerHTML = ""; 
    const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    let total = 0;

    cartItems.forEach((item, index) => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;

        const cartItem = document.createElement("div");
        cartItem.classList.add("cart-item");
        cartItem.innerHTML = `
            <div class="product-info">
                <img src="${item.image}" alt="Product Image" class="product-image">
                <div class="product-details">
                    <h2>${item.name}</h2>
                    <p>$${item.price.toFixed(2)}</p>
                    <button class="remove-btn" onclick="removeCartItem(${index})">Remove</button>
                </div>
            </div>
            <div class="quantity">
                <button class="qty-btn" onclick="decreaseQuantity(${index})">-</button>
                <input type="number" value="${item.quantity}" min="1" class="quantity-input" onchange="updateQuantity(${index}, this.value)">
                <button class="qty-btn" onclick="increaseQuantity(${index})">+</button>
            </div>
            <div class="subtotal">
                <p>$${itemTotal.toFixed(2)}</p>
            </div>
        `;

        cartContainer.appendChild(cartItem);
    });

    document.getElementById("total-amount").textContent = `$${total.toFixed(2)}`;
}


function removeCartItem(index) {
    const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    cartItems.splice(index, 1); 
    localStorage.setItem('cartItems', JSON.stringify(cartItems)); 
    renderCart();
}


function updateQuantity(index, newQuantity) {
    const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    cartItems[index].quantity = parseInt(newQuantity);
    localStorage.setItem('cartItems', JSON.stringify(cartItems));
    renderCart();
}


function increaseQuantity(index) {
    const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    cartItems[index].quantity++;
    localStorage.setItem('cartItems', JSON.stringify(cartItems));
    renderCart();
}

function decreaseQuantity(index) {
    const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    if (cartItems[index].quantity > 1) {
        cartItems[index].quantity--;
        localStorage.setItem('cartItems', JSON.stringify(cartItems));
        renderCart();
    }
}


document.addEventListener("DOMContentLoaded", renderCart);
