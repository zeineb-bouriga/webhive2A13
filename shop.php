<?php
// Include the database connection
include('config.php');

try {
    // Définir l'ordre par défaut et la condition WHERE
    $order = "name ASC";
    $where = "1"; // Par défaut, tous les produits

    // Vérifier le tri sélectionné via le paramètre GET
    if (isset($_GET['sort'])) {
        switch ($_GET['sort']) {
            case '1': // Nom A-Z
                $order = "name ASC";
                break;
            case '2': // Nom Z-A
                $order = "name DESC";
                break;
            case '3': // Prix croissant
                $order = "price ASC";
                break;
            case '4': // Prix décroissant
                $order = "price DESC";
                break;
            case '5': // Meilleures ventes
                $order = "sales DESC"; // Tri par ventes décroissantes
                $where = "sales > 0"; // Afficher uniquement les produits avec des ventes
                break;
        }
    }

    // Récupérer les produits avec tri et filtre
    $query = "SELECT * FROM products WHERE $where ORDER BY $order";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // Récupérer tous les produits
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!-- Include the header -->
<?php include('header.php'); ?>

<!-- Start Shop Page -->
<div class="shop-box-inner">
    <div class="container">
        <div class="row">
            <div class="col-xl-9 col-lg-9 col-sm-12 col-xs-12 shop-content-right">
                <div class="right-product-box">
                    <!-- Filter and Sort Section -->
                    <div class="product-item-filter row">
                        <div class="col-12 col-sm-8 text-center text-sm-left">
                            <div class="toolbar-sorter-right">
                                <span>Sort by </span>
                                <select id="basic" class="selectpicker show-tick form-control" onchange="sortProducts(this.value)">
                                    <option value="0" data-display="Select">Nothing</option>
                                    <option value="1" <?php echo isset($_GET['sort']) && $_GET['sort'] == '1' ? 'selected' : ''; ?>>Name A → Z</option>
                                    <option value="2" <?php echo isset($_GET['sort']) && $_GET['sort'] == '2' ? 'selected' : ''; ?>>Name Z → A</option>
                                    <option value="3" <?php echo isset($_GET['sort']) && $_GET['sort'] == '3' ? 'selected' : ''; ?>>Price Low → High</option>
                                    <option value="4" <?php echo isset($_GET['sort']) && $_GET['sort'] == '4' ? 'selected' : ''; ?>>Price High → Low</option>
                                    <option value="5" <?php echo isset($_GET['sort']) && $_GET['sort'] == '5' ? 'selected' : ''; ?>>Best Selling</option>
                                </select>
                            </div>
                            <p>Showing <?php echo count($products); ?> results</p>
                        </div>
                        <div class="col-12 col-sm-4 text-center text-sm-right">
                            <ul class="nav nav-tabs ml-auto">
                                <li>
                                    <a class="nav-link active" href="#grid-view" data-toggle="tab"> <i class="fa fa-th"></i> </a>
                                </li>
                                <li>
                                    <a class="nav-link" href="#list-view" data-toggle="tab"> <i class="fa fa-list-ul"></i> </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Products Section -->
                    <div class="product-categorie-box">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade show active" id="grid-view">
                                <div class="row">
                                    <?php foreach ($products as $product): ?>
                                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                                        <div class="products-single fix">
                                            <div class="box-img-hover">
                                                <div class="type-lb">
                                                    <p class="<?php echo htmlspecialchars(strtolower($product['status'] ?? 'active')); ?>">
                                                        <?php echo htmlspecialchars(ucfirst($product['status'] ?? 'active')); ?>
                                                    </p>
                                                </div>
                                                <!-- Redimensionner l'image directement avec des styles CSS en ligne -->
                                                <img src="<?php echo htmlspecialchars($product['img']); ?>" class="img-fluid" alt="img" style="width: 100%; height: 250px; object-fit: cover;">
                                                <div class="mask-icon">
                                                    <ul>
                                                        <li><a href="#" data-toggle="tooltip" data-placement="right" title="View"><i class="fas fa-eye"></i></a></li>
                                                        <li><a href="#" data-toggle="tooltip" data-placement="right" title="Compare"><i class="fas fa-sync-alt"></i></a></li>
                                                        <li><a href="#" data-toggle="tooltip" data-placement="right" title="Add to Wishlist"><i class="far fa-heart"></i></a></li>
                                                    </ul>
                                                    
                                                    <!-- Check product status before showing the "Add to Cart" button -->
                                                    <?php if ($product['status'] === 'unavailable'): ?>
                                                        <span class="text-danger">This product is unavailable</span>
                                                    <?php elseif ($product['status'] === 'coming soon'): ?>
                                                        <span class="text-warning">Coming soon!</span>
                                                    <?php else: ?>
                                                        <a href="cart.php?action=add&id=<?php echo $product['id']; ?>" class="btn btn-primary">Add to Cart</a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="why-text">
                                                <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                                                <h5>$<?php echo number_format($product['price'], 2); ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Shop Page -->

<!-- Sorting Script -->
<script>
function sortProducts(sortValue) {
    const url = new URL(window.location.href);
    url.searchParams.set('sort', sortValue);
    window.location.href = url.toString();
}
</script>

<!-- Include the footer -->
<?php include('footer.php'); ?>
