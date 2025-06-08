<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <header>
    <h1><span style="color : blue ;">DECO</span>RIFY </h1>
    <nav>
      <a href="pageaceuil.php">Home</a>
      <a href="#product">Products</a>
      <a href="#contact">Contact us </a>
      <?php if (isset($_SESSION['Nom_user']) && $_SESSION['Nom_user']!="") : ?>
      <a href="loginout.php">Sign out</a>
      <?php else : ?>
      <a href="pageaceuil.php">Log in</a>
      <a href="logininscr.php">Create an account</a>
      <a href="cart.php">
        <img src="" alt="">
        <p>Add to cart</p>
      </a>
      <?php endif ; ?>
    </nav>
  </header>
</body>
</html>