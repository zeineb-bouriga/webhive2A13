<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_POST['sub'])) {
    header('Location: ordre_payment.php');
    exit;
}

include 'header.php';
include 'config.php';
// Initialisation du panier s'il n'existe pas
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>Your cart is empty. <a href='products.php'>Go back to shop</a></p>";
    exit;
}

include_once('../../../tas/Controller/UserController.php');

if (!isset($_SESSION["name"]) || !isset($_SESSION['email']) || !isset($_SESSION['role']) || !isset($_SESSION['phone'])) {
    header('location: ../back/auth/auth-login.php');
}
$userC = new UserController();

// Traitement des données du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validation des champs requis
    $name = isset($_POST['name']) ? trim($_POST['name']) : null;
    $address = isset($_POST['address']) ? trim($_POST['address']) : null;
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : null;
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    $payment_method = isset($_POST['payment_method']) ? trim($_POST['payment_method']) : null;
 

    if (!$name || !$address || !$phone || !$email || !$payment_method) {
        echo "<p>Error: All fields are required. Please fill in all details.</p>";
    } else {
        // Stocker les détails dans la session
        $_SESSION['order_details'] = [
            'name' => $name,
            'address' => $address,
            'phone' => $phone,
            'email' => $email,
            'payment_method' => $payment_method
        ];


        // Rediriger vers la page de paiement
        
        
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <script>
        // Afficher les champs spécifiques à la méthode de paiement sélectionnée
        function showPaymentOptions() {
            const method = document.getElementById("payment_method").value;
            document.getElementById("credit_card_details").style.display = method === "credit_card" ? "block" : "none";
            document.getElementById("paypal_details").style.display = method === "paypal" ? "block" : "none";
            document.getElementById("bank_details").style.display = method === "bank_transfer" ? "block" : "none";
        }
    </script>
</head>
<body>
    <h2>Order Details</h2>
    <form action="ordre.php" method="POST">
        <!-- Détails de la commande -->
        <label for="name">Full Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="address">Address:</label><br>
        <input type="text" id="address" name="address" required><br><br>

        <label for="phone">Phone Number:</label><br>
        <input type="text" id="phone" name="phone" required pattern="\d{8}" placeholder="8-digit number"><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <!-- Sélection de la méthode de paiement -->
        <label for="payment_method">Select Payment Method:</label><br>
        <select id="payment_method" name="payment_method" onchange="showPaymentOptions()" required>
            <option value="">-- Choose Payment Method --</option>
            <option value="credit_card">Credit Card</option>
            <option value="paypal">PayPal</option>
            <option value="bank_transfer">Bank Transfer</option>
        </select><br><br>

        <!-- Options dynamiques -->
        <div id="credit_card_details" style="display:none;">
            <p>Credit card selected. Continue to the next step.</p>
        </div>

        <div id="paypal_details" style="display:none;">
            <p>PayPal selected. Continue to the next step.</p>
        </div>

        <div id="bank_details" style="display:none;">
            <p>Bank transfer selected. Continue to the next step.</p>
        </div>

        <!-- Bouton pour soumettre les informations -->
        <button type="submit" name="sub">Proceed to Payment</button>
    </form>

    <!-- Lien pour retourner à la boutique -->
    <p><a href="products.php">Back to Shop</a></p>
</body>
</html>

<?php include 'footer.php'; ?>
