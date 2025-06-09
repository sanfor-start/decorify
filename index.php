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
    // Optional: show a message
    $message = "Product added to cart!";
}

// Fetch featured products (limit to 8)
$sql = "SELECT * FROM produit LIMIT 8";
$result = mysqli_query($connexion, $sql);

// Handle contact form submission
if (
    isset($_POST['send']) &&
    isset($_POST['Nom']) && $_POST['Nom'] != "" &&
    isset($_POST['Prenom']) && $_POST['Prenom'] != "" &&
    isset($_POST['Email']) && $_POST['Email'] != "" &&
    isset($_POST['Messege']) && $_POST['Messege'] != "" 
) {
    // Use prepared statements to prevent SQL injection
    $stmt = mysqli_prepare($connexion, "INSERT INTO `contact us`(`Id`, `Nom`, `Prenom`, `Email`, `Messege`) VALUES (null, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssss", $_POST['Nom'], $_POST['Prenom'], $_POST['Email'], $_POST['Messege']);
    mysqli_stmt_execute($stmt);
    $contact_success = true;
}
?>

<!-- Hero Section -->
<section class="hero">
  <div class="container">
    <h2>WELCOME TO DECORIFY</h2>
    <p>The best products at competitive prices + exclusive discounts on all purchases!</p>
  </div>
</section>

<!-- Categories Section -->
<section class="categories">
  <div class="container">
    <h2>Browse by Categories</h2>
    <p>Discover a wide range of premium products</p>
    
    <div class="category-grid">
      <div class="category-box">
        <div class="icon">🛏️</div>
        <span>Bedroom</span>
      </div>
      
      <div class="category-box">
        <div class="icon">🛋️</div>
        <span>Living Room</span>
      </div>
      
      <div class="category-box">
        <div class="icon">👕</div>
        <span>Fashion</span>
      </div>
      
      <div class="category-box">
        <div class="icon">🚽</div>
        <span>Bathroom</span>
      </div>
      
      <div class="category-box">
        <div class="icon">😊</div>
        <span>Other</span>
      </div>
    </div>
  </div>
</section>

<!-- Products Section -->
<section class="products">
  <div class="container">
    <h2>Featured Products</h2>
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
    
    <div style="text-align: center; margin-top: 30px;">
      <a href="products.php" class="view-all-btn">View All Products</a>
    </div>
  </div>
</section>

<!-- Features Section -->
<section class="features">
  <div class="container">
    <div class="feature-grid">
      <div class="feature">
        <div class="icon">🕒</div>
        <h3>Fast Delivery</h3>
        <p>Delivery to all areas within 24 hours</p>
      </div>
      
      <div class="feature">
        <div class="icon">🛡️</div>
        <h3>Quality Guarantee</h3>
        <p>Free return within 14 days</p>
      </div>
      
      <div class="feature">
        <div class="icon">💳</div>
        <h3>Secure Payment</h3>
        <p>Multiple secure payment methods</p>
      </div>
    </div>
  </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials">
  <div class="container">
    <h2>Customer Reviews</h2>
    <p class="subtitle">What our customers say about our products</p>
    
    <div class="testimonial-grid">
      <div class="testimonial">
        <div class="stars">★★★★★</div>
        <p class="review">
          "Excellent product quality and amazing customer service. Very happy with my experience."
        </p>
        <div class="user-info">
          <div class="avatar">S</div>
          <div>
            <div class="user-name">Sarah Mohamed</div>
            <div class="date">Customer since 2020</div>
          </div>
        </div>
      </div>
      
      <div class="testimonial">
        <div class="stars">★★★★★</div>
        <p class="review">
          "Very fast delivery and products match specifications. I recommend everyone to shop from this store."
        </p>
        <div class="user-info">
          <div class="avatar">M</div>
          <div>
            <div class="user-name">Mohamed Ali</div>
            <div class="date">Customer since 2021</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Contact Section -->
<section id="contact" class="contact">
  <div class="container">
    <h2>Contact Us</h2>
    
    <?php if (isset($contact_success)): ?>
      <div class="success-message">Your message has been sent successfully!</div>
    <?php endif; ?>
    
    <form method="post" action="#contact">
      <div class="form-group">
        <label for="Nom">First Name</label>
        <input type="text" id="Nom" name="Nom" placeholder="Your first name" required>
      </div>
      
      <div class="form-group">
        <label for="Prenom">Last Name</label>
        <input type="text" id="Prenom" name="Prenom" placeholder="Your last name" required>
      </div>
      
      <div class="form-group">
        <label for="Email">Email</label>
        <input type="email" id="Email" name="Email" placeholder="example@email.com" required>
      </div>
      
      <div class="form-group">
        <label for="Messege">Message</label>
        <textarea id="Messege" name="Messege" rows="5" placeholder="Write your message here..." required></textarea>
      </div>
      
      <button type="submit" name="send" class="submit-btn">Send Message</button>
    </form>
  </div>
</section>

<?php include 'footer.php'; ?>
