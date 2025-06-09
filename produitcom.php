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
    // Add or increment product in cart
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]++;
    } else {
        $_SESSION['cart'][$product_id] = 1;
    }
    // Simple message (optional)
    $message = "Produit ajouté au panier !";
}

$sql = "SELECT * FROM produit";
$result = mysqli_query($connexion, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des produits</title>
    <style>
        
    .products {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 2rem;
  padding: 3rem 2rem;
  animation: fadeIn 1s ease-in-out;
}

.product {
  background: linear-gradient(to bottom right, #ffffff, #f9fafb);
  border-radius: 15px;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
  overflow: hidden;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product:hover {
  transform: translateY(-10px);
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.product img {
  width: 100%;
  height: 220px;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.product:hover img {
  transform: scale(1.05);
}

.product-info {
  padding: 1.2rem;
  text-align: center;
}

.product-info h3 {
  font-size: 1.3rem;
  margin-bottom: 0.6rem;
  color: #222;
}

.product-info p {
  color: #0d6efd;
  font-weight: bold;
  margin-bottom: 1rem;
  font-size: 1.1rem;
}

.product-info button {
  background-color: #0d6efd;
  color: white;
  border: none;
  padding: 0.6rem 1.4rem;
  font-weight: bold;
  border-radius: 30px;
  cursor: pointer;
  transition: background-color 0.3s ease, transform 0.2s;
}

.product-info button:hover {
  background-color: #084cdf;
  transform: scale(1.05);
}

@keyframes fadeIn {
  from {opacity: 0; transform: translateY(20px);}
  to {opacity: 1; transform: translateY(0);}
}

    </style>
</head>
<body>
    <h1>Liste des Produits</h1>
    <?php if (!empty($message)) echo "<p style='color:green;'>$message</p>"; ?>

    <section class="products">
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="product" id="product">
                        <img src="image/40.jpg" alt="منتج 1">
                        <div class="product-info">
                            <h3><?php echo $row['name'] ?></h3>
                            <p><?php echo $row['price'] ?>$</p>
                            <button>أضف إلى السلة</button>
                        </div>
                    </div>
                <?php endwhile; ?>
                </section>
</body>
</html>
