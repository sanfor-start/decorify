<?php
$server = "localhost";
$user = "root";
$pass = "";
$dbname = "projet";
$connexion = mysqli_connect($server, $user, $pass, $dbname);

if (!$connexion) {
    echo "Database connection failed";
    exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Product ID not provided";
    exit;
}

$product_id = intval($_GET['id']);
$sql = "SELECT * FROM produit WHERE Id = $product_id";
$result = mysqli_query($connexion, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "Product not found";
    exit;
}

$product = mysqli_fetch_assoc($result);
?>

<div class="product-popup-content">
    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
    <div class="product-popup-details">
        <img src="image/40.jpg" alt="<?php echo htmlspecialchars($product['name']); ?>">
        <div class="product-info">
            <p class="price"><?php echo $product['price']; ?>$</p>
            <?php if(isset($product['description'])): ?>
                <p class="description"><?php echo htmlspecialchars($product['description']); ?></p>
            <?php endif; ?>
            <form method="post" action="">
                <input type="hidden" name="product_id" value="<?php echo $product['Id']; ?>">
                <button type="submit" name="add_to_cart" class="add-cart-btn">Ajouter au panier</button>
            </form>
        </div>
    </div>
</div>
