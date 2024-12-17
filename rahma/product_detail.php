<?php
include 'config.php';
include 'header.php';

// Fetch all products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Vérifier si le produit est en solde
        $saleLabel = (strtolower($row["status"]) == 'sale') ? "<div class='type-lb'><p class='sale'>Sale</p></div>" : "";

        // Affichage du produit
        echo "<div class='col-sm-6 col-md-6 col-lg-4 col-xl-4'>";
        echo "<div class='products-single fix'>";
        echo "<div class='box-img-hover'>";
        
        // Afficher le label "Sale" si applicable
        echo $saleLabel;
        
        // Lier l'image à la page de détails du produit
        echo "<a href='product_detail.php?id=" . $row["id"] . "'><img src='" . $row["img"] . "' class='img-fluid' alt='Image'></a>";
        
        echo "<div class='mask-icon'><ul><li><a href='#' data-toggle='tooltip' data-placement='right' title='View'><i class='fas fa-eye'></i></a></li><li><a href='#' data-toggle='tooltip' data-placement='right' title='Compare'><i class='fas fa-sync-alt'></i></a></li><li><a href='#' data-toggle='tooltip' data-placement='right' title='Add to Wishlist'><i class='far fa-heart'></i></a></li></ul>
        <a class='cart' href='#'>Add to Cart</a></div></div>";
        
        // Affichage du nom et du prix
        echo "<div class='why-text'><h4>" . $row["name"] . "</h4><h5>$" . $row["price"] . "</h5><p>Status: " . ($row["status"] == 'active' ? "<span class='badge badge-success'>Active</span>" : "<span class='badge badge-danger'>Inactive</span>") . "</p></div></div></div>";
    }
} else {
    echo "No products found.";
}

include 'footer.php';
$conn->close();
?>
