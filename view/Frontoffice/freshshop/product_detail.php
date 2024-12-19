<?php
session_start();
// Inclure la connexion à la base de données
include('config.php');
include('header.php');
include_once('../../../tas/Controller/UserController.php');

if (!isset($_SESSION["name"]) || !isset($_SESSION['email']) || !isset($_SESSION['role']) || !isset($_SESSION['phone'])) {
    header('location: ../back/auth/auth-login.php');
}
$userC = new UserController();
// Vérifier si l'ID du produit est passé via GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $productId = intval($_GET['id']);

    try {
        // Préparer la requête pour récupérer le produit
        $query = "SELECT * FROM products WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
        $stmt->execute();

        // Récupérer le produit
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            ?>
            <div class="container my-5">
                <div class="row">
                    <!-- Image du produit -->
                    <div class="col-md-6">
                        <img src="<?php echo htmlspecialchars($product['img']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width: 100%; height: auto;">
                    </div>

                    <!-- Détails du produit -->
                    <div class="col-md-6">
                        <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                        <h4 class="text-success"><?php echo number_format($product['price'], 2); ?> DT</h4>
                        <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                        <p>Status: 
                            <?php 
                            echo ($product['status'] == 'active') 
                                ? "<span class='badge badge-success'>Available</span>" 
                                : "<span class='badge badge-warning'>Coming Soon</span>";
                            ?>
                        </p>

                        <!-- Bouton Add to Cart -->
                        <!-- Check product status before showing the "Add to Cart" button -->
                        <?php if ($product['status'] === 'unavailable'): ?>
                                                        <span class="text-danger">This product is unavailable</span>
                                                    <?php elseif ($product['status'] === 'coming soon'): ?>
                                                        <span class="text-warning">Coming soon!</span>
                                                    <?php else: ?>
                                                        <a href="cart.php?action=add&id=<?php echo $product['id']; ?>" class="btn btn-primary">Add to Cart</a>
                                                    <?php endif; ?>

                        <a href="shop.php" class="btn btn-secondary btn-lg mt-3 ml-2">Back to Products</a>
                    </div>
                </div>
            </div>
            <?php
        } 
    } catch (PDOException $e) {
        echo "<div class='container'><h3 class='text-danger'>Error: " . $e->getMessage() . "</h3></div>";
    }
} else {
    echo "<div class='container'><h3 class='text-danger'>Invalid Product ID!</h3></div>";
}

include('footer.php');
?>
