<?php
session_start();
include 'header.php';
include 'config.php'; // Assurez-vous que ce fichier établit la connexion PDO à la base de données

// Vérifiez si le panier est vide
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>Votre panier est vide. <a href='shop.php'>Retourner au magasin</a></p>";
    exit;
}

// Traitement de la commande si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $user_id = 1; // Exemple : Supposons que l'utilisateur est connecté et que son ID est 1
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $payment_method = $_POST['payment_method'];
    $payment_details = $_POST['payment_details'] ?? '';

    // Validation des entrées
    $errors = [];

    if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
        $errors[] = "Le nom doit contenir uniquement des lettres et des espaces.";
    }

    if (empty($address)) {
        $errors[] = "L'adresse est requise.";
    }

    if (!preg_match("/^[0-9]{8}$/", $phone)) {
        $errors[] = "Le numéro de téléphone doit contenir exactement 8 chiffres.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Adresse email invalide.";
    }

    if (empty($payment_method)) {
        $errors[] = "Veuillez sélectionner une méthode de paiement.";
    } else {
        // Validation spécifique par méthode de paiement
        if ($payment_method === "credit_card") {
            if (!preg_match("/^\d{16}$/", $payment_details)) {
                $errors[] = "Le numéro de carte de crédit doit contenir exactement 16 chiffres.";
            }
        } elseif ($payment_method === "paypal") {
            if (!filter_var($payment_details, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Veuillez entrer une adresse email valide pour PayPal.";
            }
        } elseif ($payment_method === "bank_transfer") {
            if (empty($payment_details)) {
                $errors[] = "Veuillez fournir les détails du compte bancaire pour le virement.";
            }
        }
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>Erreur : $error</p>";
        }
        exit;
    }

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("INSERT INTO orders (user_id, name, address, phone, email, payment_method, payment_details, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')");
        $stmt->execute([$user_id, $name, $address, $phone, $email, $payment_method, $payment_details]);

        $order_id = $pdo->lastInsertId();

        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $stmt = $pdo->prepare("SELECT price FROM products WHERE id = ?");
            $stmt->execute([$product_id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($product) {
                $price = $product['price'];
                $stmt = $pdo->prepare("INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
                $stmt->execute([$order_id, $product_id, $quantity, $price]);
            }
        }

        $pdo->commit();
        unset($_SESSION['cart']);

        // Rediriger vers la page de confirmation avec l'ID de la commande
        echo '<script>
            window.location.href = "order_confirmation.php?order_id=' . $order_id . '";
        </script>';
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "<p style='color:red;'>Erreur : " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Page de commande</title>
    <script>
        function togglePaymentDetails() {
            const paymentMethod = document.getElementById("payment_method").value;
            const paymentDetailsDiv = document.getElementById("payment_details_div");

            if (paymentMethod === "paypal") {
                paymentDetailsDiv.style.display = "block";
                document.getElementById("payment_details").placeholder = "Entrez votre email PayPal";
            } else if (paymentMethod === "credit_card") {
                paymentDetailsDiv.style.display = "block";
                document.getElementById("payment_details").placeholder = "Entrez votre numéro de carte de crédit (16 chiffres)";
            } else if (paymentMethod === "bank_transfer") {
                paymentDetailsDiv.style.display = "block";
                document.getElementById("payment_details").placeholder = "Entrez les détails de votre compte bancaire";
            } else {
                paymentDetailsDiv.style.display = "none";
            }
        }
    </script>
</head>
<body>
    <h2>Résumé de la commande</h2>
    <form action="ordre.php" method="POST">
        <h3>Détails de l'expédition</h3>
        <label for="name">Nom:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="address">Adresse:</label><br>
        <textarea id="address" name="address" required></textarea><br><br>

        <label for="phone">Téléphone:</label><br>
        <input type="text" id="phone" name="phone" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <h3>Méthode de paiement</h3>
        <select id="payment_method" name="payment_method" onchange="togglePaymentDetails()" required>
            <option value="">--Sélectionnez--</option>
            <option value="credit_card">Carte de crédit</option>
            <option value="paypal">PayPal</option>
            <option value="bank_transfer">Virement bancaire</option>
        </select><br><br>

        <div id="payment_details_div" style="display:none;">
            <label for="payment_details">Détails du paiement:</label><br>
            <input type="text" id="payment_details" name="payment_details"><br><br>
        </div>

        <h3>Détails du panier</h3>
        <?php
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            echo "<table border='1'>";
            echo "<tr><th>Nom du produit</th><th>Prix</th><th>Quantité</th><th>Total</th></tr>";

            $total = 0;
            foreach ($_SESSION['cart'] as $product_id => $quantity) {
                $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
                $stmt->execute([$product_id]);
                $product = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($product) {
                    $product_total = $product['price'] * $quantity;
                    $total += $product_total;
                    echo "<tr>
                            <td>" . htmlspecialchars($product['name']) . "</td>
                            <td>$" . htmlspecialchars($product['price']) . "</td>
                            <td>" . htmlspecialchars($quantity) . "</td>
                            <td>$" . number_format($product_total, 2) . "</td>
                        </tr>";
                }
            }

            echo "</table>";
            echo "<h3>Total: $" . number_format($total, 2) . "</h3>";
        }
        ?>
        <button type="submit">Passer la commande</button>
    </form>
</body>
</html>

<?php include 'footer.php'; ?>
