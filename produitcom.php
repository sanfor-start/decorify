<?php
session_start();

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
  $message = "Produit ajouté au panier !";
}

// Get product details for popup if product_id is in URL
$show_popup = false;
$popup_product = null;
if (isset($_GET['product_id']) && !empty($_GET['product_id'])) {
    $product_id = intval($_GET['product_id']);
    $popup_sql = "SELECT * FROM produit WHERE Id = $product_id";
    $popup_result = mysqli_query($connexion, $popup_sql);
    if (mysqli_num_rows($popup_result) > 0) {
        $popup_product = mysqli_fetch_assoc($popup_result);
        $show_popup = true;
    }
}

$sql = "SELECT * FROM produit";
$result = mysqli_query($connexion, $sql);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Nos Produits</title>
  <link rel="stylesheet" href="CSS/style.css">

  <style>
    body {
      padding-top: 80px;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background: #f5f5f5;
    }

    header,
    footer {
      background-color: #222;
      color: white;
      padding: 20px;
      text-align: center;
    }

    h1 {
      margin: 0;
      font-size: 28px;
    }

    .container {
      padding: 40px;
    }

    .products {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
      gap: 20px;
    }

    .product-card {
      background: white;
      border-radius: 10px;
      padding: 15px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .product-card img {
      max-width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 8px;
      cursor: pointer;
    }

    .product-card h3 {
      margin: 10px 0 5px;
    }

    .product-card p {
      color: #555;
    }

    .product-card button {
      margin-top: 10px;
      padding: 10px 20px;
      background: #27ae60;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .product-card button:hover {
      background: #219150;
    }

    .product-link {
      text-decoration: none;
      color: inherit;
    }

    .product-link:hover h3 {
      color: #1d4ed8;
    }

    /* Simple Popup Styles */
    .popup-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.7);
      z-index: 1000;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .popup-content {
      background: white;
      border-radius: 10px;
      padding: 30px;
      max-width: 500px;
      width: 90%;
      position: relative;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .popup-close {
      position: absolute;
      top: 10px;
      right: 15px;
      font-size: 24px;
      text-decoration: none;
      color: #333;
      font-weight: bold;
    }

    .popup-close:hover {
      color: #666;
    }

    .popup-product-info {
      text-align: center;
    }

    .popup-product-info img {
      max-width: 100%;
      border-radius: 8px;
      margin-bottom: 15px;
    }

    .popup-product-info h3 {
      font-size: 24px;
      margin-bottom: 10px;
      color: #333;
    }

    .popup-product-info .price {
      font-size: 20px;
      font-weight: bold;
      color: #27ae60;
      margin-bottom: 15px;
    }

    .popup-product-info .description {
      margin-bottom: 20px;
      line-height: 1.5;
      color: #666;
    }

    .popup-add-cart {
      background-color: #27ae60;
      color: white;
      border: none;
      padding: 12px 20px;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
      width: 100%;
      font-size: 16px;
    }

    .popup-add-cart:hover {
      background-color: #219150;
    }
  </style>
</head>

<body>

  <header>
    <nav>
      <a href="pageaceuil.php">Home</a>
      <a href="produitcom.php">Products</a>
      <a href="#contact">Contact us</a>

      <?php if (isset($_SESSION['Nom_user']) && $_SESSION['Nom_user'] != "") : ?>
        <a href="loginout.php">Sign out</a>
      <?php else : ?>
        <a href="logincom.php">Log in</a>
        <a href="logininscr.php">Create an account</a>
        <a href="cart.php">
          <img src="image/cart.png" alt="" width="20">
        </a>
      <?php endif; ?>
    </nav>
    <h1><span style="color : blue ;">DECO</span>RIFY</h1>
  </header>

  <div class="container">
    <h2>Nos Produits</h2>
    <?php if (isset($message)) echo "<p style='color: green;'>$message</p>"; ?>
    <div class="products">
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="product-card">
          <a href="?product_id=<?php echo $row['Id']; ?>" class="product-link">
            <img src="image/40.jpg" alt="<?= htmlspecialchars($row['name']) ?>">
            <h3><?= htmlspecialchars($row['name']) ?></h3>
          </a>
          <p><?= htmlspecialchars($row['description']) ?></p>
          <p><strong><?= $row['price'] ?> €</strong></p>
          <form method="POST">
            <input type="hidden" name="product_id" value="<?= $row['Id'] ?>">
            <button type="submit" name="add_to_cart">Ajouter au panier</button>
          </form>
        </div>
      <?php endwhile; ?>
    </div>
  </div>

  <footer>
    <p>&copy; 2025 Ma Boutique. Tous droits réservés.</p>
  </footer>

  <!-- Simple PHP Popup -->
  <?php if ($show_popup && $popup_product): ?>
  <div class="popup-overlay">
    <div class="popup-content">
      <a href="produitcom.php" class="popup-close">&times;</a>
      <div class="popup-product-info">
        <img src="image/40.jpg" alt="<?php echo htmlspecialchars($popup_product['name']); ?>">
        <h3><?php echo htmlspecialchars($popup_product['name']); ?></h3>
        <p class="price"><?php echo $popup_product['price']; ?> €</p>
        <p class="stock">المخزون: 
          <?php 
            echo isset($popup_product['stock']) ? (int)$popup_product['stock'] : 'غير متوفر'; 
          ?>
        </p>

        <?php if(isset($popup_product['description']) && !empty($popup_product['description'])): ?>
          <p class="description"><?php echo htmlspecialchars($popup_product['description']); ?></p>
        <?php endif; ?>
        <form method="post" action="">
          <input type="hidden" name="product_id" value="<?php echo $popup_product['Id']; ?>">
          <button type="submit" name="add_to_cart" class="popup-add-cart">Ajouter au panier</button>
        </form>
      </div>
    </div>
  </div>
  <?php endif; ?>

</body>

</html>
