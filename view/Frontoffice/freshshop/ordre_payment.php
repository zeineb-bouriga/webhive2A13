<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_POST['sub'])) {
    header('Location: order_confirmation.php');
    exit;
}
include 'header.php';
include 'config.php';
include_once('../../../tas/Controller/UserController.php');

if (!isset($_SESSION["name"]) || !isset($_SESSION['email']) || !isset($_SESSION['role']) || !isset($_SESSION['phone'])) {
    header('location: ../back/auth/auth-login.php');
}
$userC = new UserController();
// Vérifiez si les détails de la commande existent dans la session
if (!isset($_SESSION['order_details']) || empty($_SESSION['cart'])) {
    echo "<p>Order details are missing or your cart is empty. <a href='ordre.php'>Go back</a></p>";
    exit;
}

$order_details = $_SESSION['order_details'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifiez si une méthode de paiement a été sélectionnée
    $payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : null;

    if (!$payment_method) {
        echo "<p>Error: Please select a payment method.</p>";
        exit;
    }

    try {
        // Démarrer une transaction pour garantir la cohérence des données
        $pdo->beginTransaction();

        // Insérer les détails de la commande dans la table `orders`
        $stmt = $pdo->prepare("
            INSERT INTO orders (name, address, phone, email, payment_method, status) 
            VALUES (?, ?, ?, ?, ?, 'pending')
        ");
        $stmt->execute([
            $order_details['name'],
            $order_details['address'],
            $order_details['phone'],
            $order_details['email'],
            $payment_method
        ]);

        // Récupérer l'ID de la commande nouvellement insérée
        $order_id = $pdo->lastInsertId();

        // Insérer les produits de la commande dans la table `order_details`
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            // Récupérer le prix du produit dans la table `products`
            $stmt = $pdo->prepare("SELECT price FROM products WHERE id = ?");
            $stmt->execute([$product_id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($product) {
                // Insérer les détails des produits dans `order_details`
                $stmt = $pdo->prepare("
                    INSERT INTO order_details (order_id, product_id, quantity, price)
                    VALUES (?, ?, ?, ?)
                ");
                $stmt->execute([$order_id, $product_id, $quantity, $product['price']]);
            }
        }

        // Confirmer la transaction
        $pdo->commit();

        // Nettoyer le panier après la commande réussie
        unset($_SESSION['cart']);
        $_SESSION['order_id'] = $order_id; // Enregistrer l'ID de la commande pour la confirmation

        // Inclure la page de confirmation de commande
        include 'order_confirmation.php';
    

    } catch (Exception $e) {
        // Annuler la transaction en cas d'erreur
        $pdo->rollBack();
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Method</title>
    <script>
        // Fonction pour afficher dynamiquement le formulaire selon le mode de paiement
        function showPaymentForm() {
            const selectedMethod = document.getElementById("payment_method").value;
            document.getElementById("credit_card_form").style.display = selectedMethod === "credit_card" ? "block" : "none";
            document.getElementById("paypal_form").style.display = selectedMethod === "paypal" ? "block" : "none";
            document.getElementById("bank_transfer_form").style.display = selectedMethod === "bank_transfer" ? "block" : "none";
        }
    </script>
</head>
<body>
    <h2>Choose Payment Method</h2>
    <form action="ordre_payment.php" method="POST">
        <label for="payment_method">Select Payment Method:</label>
        <select id="payment_method" name="payment_method" onchange="showPaymentForm()" required>
            <option value="">-- Select Payment Method --</option>
            <option value="credit_card">Credit Card</option>
            <option value="paypal">PayPal</option>
            <option value="bank_transfer">Bank Transfer</option>
        </select>

        <!-- Formulaire Carte de Crédit -->
        <div id="credit_card_form" style="display:none;">
            <h3>Credit Card Information</h3>
            <label for="cc_number">Card Number:</label><br>
            <input type="text" id="cc_number" name="cc_number" placeholder="1234 5678 9012 3456"><br>
            <label for="cc_expiry">Expiry Date:</label><br>
            <input type="month" id="cc_expiry" name="cc_expiry"><br>
            <label for="cc_cvv">CVV:</label><br>
            <input type="text" id="cc_cvv" name="cc_cvv" placeholder="123"><br>
        </div>

        <!-- Formulaire PayPal -->
        <div id="paypal_form" style="display:none;">
            <h3>PayPal Information</h3>
            <label for="paypal_email">PayPal Email:</label><br>
            <input type="email" id="paypal_email" name="paypal_email" placeholder="example@paypal.com"><br>
        </div>

        <!-- Formulaire Virement Bancaire -->
        <div id="bank_transfer_form" style="display:none;">
            <h3>Bank Transfer</h3>
            <label for="bank_account">Account Number:</label><br>
            <input type="text" id="bank_account" name="bank_account" placeholder="Bank Account Number"><br>
        </div>

        <button type="submit" name="sub">Confirm Payment</button>
    </form>
</body>
</html>

<?php include 'footer.php'; ?>
