<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'header.php';
include 'config.php';

if (!isset($_SESSION['order_details'])) {
    echo "<p>Order details missing. <a href='ordre.php'>Go back to fill order details</a></p>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification si 'payment_method' existe dans POST
    $payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : null;
    if (!$payment_method) {
        echo "<p>Error: Payment method is required. Please select a payment method.</p>";
        exit;
    }

    $order_details = $_SESSION['order_details'];

    // Préparer les détails du paiement
    $payment_details = [
        'payment_method' => $payment_method,
        'details' => json_encode($_POST) // Encode all payment-specific fields as JSON
    ];

    try {
        $pdo->beginTransaction();

        // Insérer les détails de la commande
        $stmt = $pdo->prepare("INSERT INTO orders (name, address, phone, email, payment_method, payment_details, status) VALUES (?, ?, ?, ?, ?, ?, 'pending')");
        $stmt->execute([
            $order_details['name'],
            $order_details['address'],
            $order_details['phone'],
            $order_details['email'],
            $payment_method,
            $payment_details['details']
        ]);

        // Récupérer l'ID de la commande insérée
        $order_id = $pdo->lastInsertId();

        // Insérer les produits dans la table `order_details`
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $product_id => $quantity) {
                $stmt = $pdo->prepare("SELECT price FROM products WHERE id = ?");
                $stmt->execute([$product_id]);
                $product = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($product) {
                    $stmt = $pdo->prepare("INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$order_id, $product_id, $quantity, $product['price']]);
                }
            }
        }

        $pdo->commit();

        // Effacer le panier après la commande réussie
        $_SESSION['order_id'] = $order_id;
        unset($_SESSION['cart']);

         // Rediriger vers la page de confirmation avec l'ID de la commande
         echo '<script>
         window.location.href = "order_confirmation.php?order_id=' . $order_id . '";
     </script>';
     exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Payment</title>
    <script>
        // Fonction pour afficher dynamiquement les formulaires en fonction du mode de paiement sélectionné
        function showPaymentForm() {
            const selectedMethod = document.getElementById("payment_method").value;
            document.getElementById("credit_card_form").style.display = selectedMethod === "credit_card" ? "block" : "none";
            document.getElementById("paypal_form").style.display = selectedMethod === "paypal" ? "block" : "none";
            document.getElementById("bank_transfer_form").style.display = selectedMethod === "bank_transfer" ? "block" : "none";
        }
    </script>
</head>
<body>
    <h2>Payment Method</h2>
    <form action="ordre_payment.php" method="POST">
        <label for="payment_method">Select Payment Method:</label>
        <select id="payment_method" name="payment_method" onchange="showPaymentForm()" required>
            <option value="">-- Select Payment Method --</option>
            <option value="credit_card">Credit Card</option>
            <option value="paypal">PayPal</option>
            <option value="bank_transfer">Bank Transfer</option>
        </select>

        <!-- Formulaire de paiement par carte de crédit -->
        <div id="credit_card_form" style="display: none; margin-top: 20px;">
            <h3>Credit Card Information</h3>
            <label for="cc_number">Card Number:</label><br>
            <input type="text" id="cc_number" name="cc_number" required pattern="\d{16}" placeholder="16 digits"><br><br>

            <label for="cc_expiry">Expiry Date:</label><br>
            <input type="month" id="cc_expiry" name="cc_expiry" required><br><br>

            <label for="cc_cvv">CVV:</label><br>
            <input type="text" id="cc_cvv" name="cc_cvv" required pattern="\d{3}" placeholder="3 digits"><br><br>
        </div>

        <!-- Formulaire de paiement PayPal -->
        <div id="paypal_form" style="display: none; margin-top: 20px;">
            <h3>PayPal Information</h3>
            <label for="paypal_email">PayPal Email:</label><br>
            <input type="email" id="paypal_email" name="paypal_email" required><br><br>
        </div>

        <!-- Formulaire de paiement par virement bancaire -->
        <div id="bank_transfer_form" style="display: none; margin-top: 20px;">
            <h3>Bank Transfer Details</h3>
            <label for="bank_account">Bank Account Number:</label><br>
            <input type="text" id="bank_account" name="bank_account" required><br><br>

            <label for="bank_reference">Payment Reference:</label><br>
            <input type="text" id="bank_reference" name="bank_reference" required><br><br>
        </div>

        <!-- Bouton de soumission du formulaire -->
        <button type="submit">Confirm Payment</button>
    </form>
</body>
</html>

<?php include 'footer.php'; ?>
