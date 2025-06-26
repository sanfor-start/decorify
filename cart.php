<?php
session_start();

$server = "localhost";
$user = "root";
$pass = "";
$dbname = "projet";
$connexion = mysqli_connect($server, $user, $pass, $dbname);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Panier</title>
    <link rel="stylesheet" href="CSS/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .cart-container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            position: relative;
            overflow: hidden;
        }

        .cart-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .header-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .nav-buttons {
            display: flex;
            gap: 1rem;
        }

        .nav-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .nav-btn.primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .nav-btn.secondary {
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
        }

        .nav-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .cart-title {
            text-align: center;
            font-size: 2.5rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 2rem;
            font-weight: 700;
            position: relative;
        }

        .cart-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 2px;
        }

        .cart-items {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .cart-product {
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .cart-product::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .cart-product:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }

        .product-image {
            width: 100%;
            max-width: 220px;
            height: 160px;
            object-fit: cover;
            border-radius: 15px;
            margin-bottom: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .product-name {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
            color: #2d3748;
            font-weight: 600;
        }

        .product-price {
            color: #667eea;
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.3rem;
        }

        .product-qty {
            background: #f7fafc;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            margin-bottom: 0.5rem;
            color: #4a5568;
            font-weight: 500;
        }

        .product-total {
            font-weight: 700;
            color: #2d3748;
            font-size: 1.1rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .cart-summary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 2rem;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .cart-summary h2 {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .grand-total {
            font-size: 2.2rem;
            font-weight: 800;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .checkout-btn {
            background: white;
            color: #667eea;
            padding: 1rem 2rem;
            border: none;
            border-radius: 25px;
            font-weight: 700;
            font-size: 1.1rem;
            margin-top: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .checkout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .empty-cart {
            text-align: center;
            padding: 4rem 2rem;
            color: #718096;
            font-size: 1.3rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .empty-cart i {
            font-size: 4rem;
            color: #cbd5e0;
            margin-bottom: 1rem;
        }

        .empty-cart h3 {
            color: #4a5568;
            margin-bottom: 0.5rem;
        }

        .continue-shopping {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 1rem 2rem;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .continue-shopping:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        @media (max-width: 768px) {
            .cart-container {
                padding: 1.5rem;
                margin: 10px;
            }

            .cart-title {
                font-size: 2rem;
            }

            .cart-items {
                grid-template-columns: 1fr;
            }

            .header-nav {
                flex-direction: column;
                align-items: stretch;
            }

            .nav-buttons {
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <div class="cart-container">
        <div class="header-nav">
            <div class="nav-buttons">
                <a href="produitcom.php" class="nav-btn primary">
                    <i class="fas fa-arrow-left"></i>
                    Back to Products
                </a>
                <a href="pageaceuil.php" class="nav-btn secondary">
                    <i class="fas fa-home"></i>
                    Home
                </a>
            </div>
        </div>

        <div class="cart-title">
            <i class="fas fa-shopping-cart"></i>
            Votre Panier
        </div>

        <?php
        if (!empty($_SESSION['cart'])) {
            echo '<div class="cart-items">';
            $grand_total = 0;
            foreach ($_SESSION['cart'] as $id => $qty) {
                $sql = "SELECT * FROM produit WHERE Id = $id";
                $res = mysqli_query($connexion, $sql);
                $prod = mysqli_fetch_assoc($res);
                $total = $prod['price'] * $qty;
                $grand_total += $total;

                echo '<div class="cart-product">';
                echo '<img src="image/' . (!empty($prod['image']) ? htmlspecialchars($prod['image']) : '40.jpg') . '" alt="' . htmlspecialchars($prod['name']) . '" class="product-image">';
                echo '<h3 class="product-name">' . htmlspecialchars($prod['name']) . '</h3>';
                echo '<div class="product-price"><i class="fas fa-tag"></i>' . htmlspecialchars($prod['price']) . ' $</div>';
                echo '<div class="product-qty"><i class="fas fa-cubes"></i> Quantité : ' . $qty . '</div>';
                echo '<div class="product-total">Total : ' . $total . ' $</div>';
                echo '</div>';
            }
            echo '</div>';

            echo '<div class="cart-summary">';
            echo '<h2><i class="fas fa-calculator"></i>Résumé de la commande</h2>';
            echo '<div class="grand-total">' . $grand_total . ' $</div>';
            echo '<button class="checkout-btn"><i class="fas fa-credit-card"></i>Procéder au paiement</button>';
            echo '</div>';
        } else {
            echo '<div class="empty-cart">';
            echo '<i class="fas fa-shopping-cart"></i>';
            echo '<h3>Votre panier est vide</h3>';
            echo '<p>Découvrez nos produits et ajoutez-les à votre panier</p>';
            echo '<a href="produitcom.php" class="continue-shopping"><i class="fas fa-shopping-bag"></i>Continuer mes achats</a>';
            echo '</div>';
        }
        ?>
    </div>
</body>

</html>