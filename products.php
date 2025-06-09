<?php
include 'header.php';

$server = "localhost";
$user = "root";
$pass = "";
$dbname = "projet";
$connexion = mysqli_connect($server, $user, $pass, $dbname);

// Add to cart logic
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]++;
    } else {
        $_SESSION['cart'][$product_id] = 1;
    }
    $message = "Product added to cart!";
}

// Fetch all products
$sql = "SELECT * FROM produit";
$result = mysqli_query($connexion, $sql);
?>

<div class="container">
  <h1 class="page-title">All Products</h1>
  
  <?php if (!empty($message)): ?>
    <div class="success-message"><?php echo $message; ?></div>
  <?php endif; ?>
  
  <div class="products-grid">
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
      <div class="product">
        <img src="image/40.jpg" alt="<?php echo htmlspecialchars($row['name']); ?>">
        <div class="product-info">
          <h3><?php echo htmlspecialchars($row['name']); ?></h3>
          <p>$<?php echo htmlspecialchars($row['price']); ?></p>
          <form method="post" action="">
            <input type="hidden" name="product_id" value="<?php echo $row['Id']; ?>">
            <button type="submit" name="add_to_cart">Add to Cart</button>
          </form>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<?php include 'footer.php'; ?>
