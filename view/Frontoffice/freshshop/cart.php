<?php
session_start();
include 'header.php';
include 'config.php'; // Ensure this file establishes the PDO connection
include_once('../../../tas/Controller/UserController.php');

if (!isset($_SESSION["name"]) || !isset($_SESSION['email']) || !isset($_SESSION['role']) || !isset($_SESSION['phone'])) {
    header('location: ../back/auth/auth-login.php');
}
$userC = new UserController();
if (!isset($pdo)) {
    die("Database connection not established. Check config.php.");
}

// Add product to cart
if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['id'])) {
    $product_id = (int)$_GET['id'];
    $quantity = 1; // Default quantity is 1

    // Fetch product details from the database
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        // Check if the product is available
        if ($product['status'] === 'unavailable' || $product['status'] === 'coming soon') {
            echo "<p>This product is not available for purchase.</p>";
        } else {
            // Initialize the cart if it is not already set
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = array();
            }

            // Add or update the product in the cart
            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id] += $quantity; // Increase quantity if the product is already in the cart
            } else {
                $_SESSION['cart'][$product_id] = $quantity; // Add the product to the cart if not already present
            }

            echo "<p>Product added to cart!</p>";
            echo "<a href='cart.php'>Go to cart</a>";
        }
    } else {
        echo "<p>Product not found.</p>";
    }
}

// Remove product from cart
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $product_id = (int)$_GET['id'];

    // Remove the product from the cart if it exists
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]); // Remove the product from the cart
        echo "<p>Product removed from cart.</p>";
    } else {
        echo "<p>Product not found in the cart.</p>";
    }

    echo "<a href='cart.php'>Go to cart</a>";
}

// Update product quantity in cart
if (isset($_POST['update_cart']) && isset($_SESSION['cart'])) {
    foreach ($_POST['quantity'] as $product_id => $quantity) {
        $quantity = (int)$quantity;
        if ($quantity > 0) {
            $_SESSION['cart'][$product_id] = $quantity; // Update the quantity
        } else {
            unset($_SESSION['cart'][$product_id]); // Remove the product if quantity is 0 or less
        }
    }
    echo "<p>Cart updated!</p>";
}

// Display cart items
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    echo "<h2>Your Cart</h2>";
    $total = 0;
    echo "<form action='cart.php' method='POST'>"; // Form to update quantities
    echo "<div class='cart-items-container' style='display: flex; flex-wrap: wrap;'>"; // Flexbox for cart items
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        // Fetch product details from the database
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            echo "<div class='cart-item' style='flex: 1 1 calc(25% - 20px); margin: 10px; padding: 15px; border: 1px solid #ccc; box-sizing: border-box;'>";
            // Adjust image size here (for example, set a maximum width and height)
            echo "<img src='"  . htmlspecialchars($product["img"]) . "' alt='Product Image' style='width: 150px; height: 150px; object-fit: cover;'>"; // Smaller image size
            echo "<p>" . htmlspecialchars($product["name"]) . "</p>";
            echo "<p>Price: $" . htmlspecialchars($product["price"]) . "</p>";

            // Check if the product is unavailable or coming soon
            if ($product['status'] === 'unavailable' || $product['status'] === 'coming soon') {
                echo "<p class='text-danger'>This product is currently unavailable or coming soon.</p>";
            } else {
                echo "<p>Quantity: <input type='number' name='quantity[" . $product_id . "]' value='" . $quantity . "' min='1'></p>"; // Quantity input
                echo "<p>Total: $" . number_format($product["price"] * $quantity, 2) . "</p>";
            }

            echo "<a href='cart.php?action=remove&id=" . $product_id . "'>Remove from Cart</a>";
            echo "</div>";

            // Accumulate the total (only for available products)
            if ($product['status'] !== 'unavailable' && $product['status'] !== 'coming soon') {
                $total += $product["price"] * $quantity;
            }
        } else {
            echo "<p>Product with ID $product_id not found.</p>";
        }
    }
    // Display total price and update button (only for available products)
    echo "</div>"; // End of flexbox container
    echo "<h3>Total: $" . number_format($total, 2) . "</h3>";
    echo "<button type='submit' name='update_cart'>Update Cart</button>"; // Button to update quantities

    // Add "Order" button to navigate to order.php
    echo "<br><br><a href='ordre.php'><button type='button'>Place Order</button></a>";

    echo "</form>";
} else {
    echo "<p>Your cart is empty.</p>";
}
include 'footer.php';
?>
