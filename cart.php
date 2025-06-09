<?php
include 'header.php';

$server = "localhost";
$user = "root";
$pass = "";
$dbname = "projet";
$connexion = mysqli_connect($server, $user, $pass, $dbname);

// Remove from cart
if (isset($_POST['remove_from_cart'])) {
    $product_id = $_POST['product_id'];
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}

// Update quantity
if (isset($_POST['update_quantity'])) {
    $product_id = $_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    
    if ($quantity > 0) {
        $_SESSION['cart'][$product_id] = $quantity;
    } else {
        unset($_SESSION['cart'][$product_id]);
    }
}
?>

<div class="container">
  <div class="cart-container">
    <h1 class="cart-title">
      <i class="fas fa-shopping-cart"></i>
      Your Cart
    </h1>
    
    <?php if (!empty($_SESSION['cart'])): ?>
      <div class="cart-items">
        <?php 
        $grand_total = 0;
        foreach ($_SESSION['cart'] as $id => $qty): 
          $sql = "SELECT name, price FROM produit WHERE Id = ?";
          $stmt = mysqli_prepare($connexion, $sql);
          mysqli_stmt_bind_param($stmt, "i", $id);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
          $prod = mysqli_fetch_assoc($result);
          $total = $prod['price'] * $qty;
          $grand_total += $total;
        ?>
          <div class="cart-item">
            <img src="image/40.jpg" alt="<?php echo htmlspecialchars($prod['name']); ?>">
            
            <div class="item-details">
              <div class="item-name"><?php echo htmlspecialchars($prod['name']); ?></div>
              <div class="item-price">$<?php echo htmlspecialchars($prod['price']); ?></div>
            </div>
            
            <div class="item-quantity">
              <form method="post" action="">
                <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                <button type="submit" name="update_quantity" class="quantity-btn" onclick="this.form.quantity.value--">-</button>
                <input type="number" name="quantity" value="<?php echo $qty; ?>" min="1" class="quantity-input">
                <button type="submit" name="update_quantity" class="quantity-btn" onclick="this.form.quantity.value++">+</button>
              </form>
            </div>
            
            <div class="item-total">
              $<?php echo $total; ?>
              <form method="post" action="">
                <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                <button type="submit" name="remove_from_cart" class="remove-btn">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      
      <div class="cart-summary">
        <h3>Order Summary</h3>
        <div class="grand-total">$<?php echo $grand_total; ?></div>
        <button class="checkout-btn">Proceed to Checkout</button>
      </div>
    <?php else: ?>
      <div class="empty-cart">
        <i class="fas fa-shopping-cart"></i>
        <h3>Your cart is empty</h3>
        <p>Discover our products and add them to your cart</p>
        <a href="products.php" class="continue-shopping">
          <i class="fas fa-shopping-bag"></i>
          Continue Shopping
        </a>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php include 'footer.php'; ?>
