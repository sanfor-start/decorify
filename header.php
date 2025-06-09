<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DECORIFY - Premium Furniture & Home Decor</title>
  <link rel="stylesheet" href="styles.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
  <header>
    <div class="container">
      <div class="header-content">
        <a href="index.php" class="logo">
          <span class="logo-blue">DECO</span>RIFY
        </a>
        <nav class="desktop-nav">
          <a href="index.php">Home</a>
          <a href="products.php">Products</a>
          <a href="index.php#contact">Contact us</a>
          
          <?php if (isset($_SESSION['Nom_user']) && $_SESSION['Nom_user'] != ""): ?>
            <a href="logout.php">Sign out</a>
          <?php else: ?>
            <a href="login.php">Log in</a>
            <a href="register.php">Create an account</a>
          <?php endif; ?>
          
          <a href="cart.php" class="cart-link">
            <i class="fas fa-shopping-cart"></i>
            <span>Cart</span>
          </a>
        </nav>
        <div class="mobile-menu-btn">
          <i class="fas fa-bars"></i>
        </div>
      </div>
      
      <div class="mobile-nav">
        <a href="index.php">Home</a>
        <a href="products.php">Products</a>
        <a href="index.php#contact">Contact us</a>
        
        <?php if (isset($_SESSION['Nom_user']) && $_SESSION['Nom_user'] != ""): ?>
          <a href="logout.php">Sign out</a>
        <?php else: ?>
          <a href="login.php">Log in</a>
          <a href="register.php">Create an account</a>
        <?php endif; ?>
        
        <a href="cart.php" class="cart-link">
          <i class="fas fa-shopping-cart"></i>
          <span>Cart</span>
        </a>
      </div>
    </div>
  </header>

  <script>
    document.querySelector('.mobile-menu-btn').addEventListener('click', function() {
      document.querySelector('.mobile-nav').classList.toggle('active');
    });
  </script>
