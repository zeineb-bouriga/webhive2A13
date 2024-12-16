<?php
session_start();
include 'header.php';
include 'config.php';

if (!isset($_GET['order_id'])) {
    echo "<p>Order ID is missing. <a href='shop.php'>Go back to shop</a></p>";
    exit;
}

$order_id = $_GET['order_id'];

// Fetch order details from the database
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo "<p>Order not found. <a href='shop.php'>Go back to shop</a></p>";
    exit;
}

// Fetch order items
$stmt = $pdo->prepare("SELECT od.*, p.name FROM order_details od JOIN products p ON od.product_id = p.id WHERE od.order_id = ?");
$stmt->execute([$order_id]);
$order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display order details
echo "<h2>Order Confirmation</h2>";
echo "<p>Thank you, " . htmlspecialchars($order['name']) . "!</p>";
echo "<p>Your order has been successfully placed.</p>";
echo "<h3>Order Details:</h3>";
echo "<p>Address: " . htmlspecialchars($order['address']) . "</p>";
echo "<p>Phone: " . htmlspecialchars($order['phone']) . "</p>";
echo "<p>Email: " . htmlspecialchars($order['email']) . "</p>";

echo "<h3>Payment Method:</h3>";
echo "<p>" . htmlspecialchars($order['payment_method']) . "</p>";

// Ensure payment_details exists and is not null
$payment_details = json_decode($order['payment_details'], true);

// Check if payment_details is an array before accessing
if (is_array($payment_details)) {
    if ($order['payment_method'] === 'credit_card' && isset($payment_details['cc_number'])) {
        echo "<p>Card Number: **** **** **** " . substr($payment_details['cc_number'], -4) . "</p>";
    } elseif ($order['payment_method'] === 'paypal' && isset($payment_details['paypal_email'])) {
        echo "<p>PayPal Email: " . htmlspecialchars($payment_details['paypal_email']) . "</p>";
    } elseif ($order['payment_method'] === 'bank_transfer') {
        if (isset($payment_details['bank_account']) && isset($payment_details['bank_reference'])) {
            echo "<p>Bank Account: " . htmlspecialchars($payment_details['bank_account']) . "</p>";
            echo "<p>Reference: " . htmlspecialchars($payment_details['bank_reference']) . "</p>";
        }
    }
} else {
    // Handle case where payment_details is not set or is not valid JSON
    echo "<p>No payment details available.</p>";
}

// Display order items
echo "<h3>Order Items:</h3>";
foreach ($order_items as $item) {
    echo "<p>" . htmlspecialchars($item['name']) . " - Quantity: " . htmlspecialchars($item['quantity']) . " - Price: $" . htmlspecialchars($item['price']) . "</p>";
}

include 'footer.php';
?>
