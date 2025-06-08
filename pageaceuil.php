<?php
session_start();

$server="localhost";
$user="root";
$pass="";
$dbname="projet";
$connexion=mysqli_connect($server,$user,$pass,$dbname);
if (
    isset($_POST['send']) &&
    isset($_POST['Nom']) && $_POST['Nom'] != "" &&
    isset($_POST['Prenom']) && $_POST['Prenom'] != "" &&
    isset($_POST['Email']) && $_POST['Email'] != "" &&
    isset($_POST['Messege']) && $_POST['Messege'] != "" 
) {
    $Nom = $_POST['Nom'];
    $Prenom = $_POST['Prenom'];
    $Email = $_POST['Email'];
    $Messege = $_POST['Messege'];
    $sql="INSERT INTO `contact us`(`Id`, `Nom`, `Prenom`, `Email`, `Messege`) VALUES ( null,'$Nom','$Prenom','$Email','$Messege')";
    mysqli_query($connexion, $sql);
    header("location: pageaceuil.php");
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title> DECORIFY </title>
  <link rel="stylesheet" href="CSS/style.css">
  <style>
    body {
  padding-top: 80px; 
}

.categories {
  text-align: center;
  padding: 4rem 2rem;
  background-color: #f9fafb;
}

.categories h2 {
  font-size: 2rem;
  margin-bottom: 0.5rem;
  color: #111827;
}

.categories p {
  color: #6b7280;
  margin-bottom: 2rem;
}

.category-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
  gap: 1.5rem;
  max-width: 900px;
  margin: 0 auto;
}

.category-box {
  background-color: #f1f5f9;
  border-radius: 12px;
  padding: 1.5rem 1rem;
  display: flex;
  flex-direction: column;
  align-items: center;
  box-shadow: 0 2px 6px rgba(0,0,0,0.06);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  cursor: pointer;
}

.category-box:hover {
  transform: translateY(-6px);
  box-shadow: 0 6px 15px rgba(0,0,0,0.1);
}

.category-box .icon {
  font-size: 2.5rem;
  margin-bottom: 0.8rem;
  color: #3b82f6;
}

.category-box span {
  font-weight: bold;
  font-size: 1rem;
  color: #111827;
}
/* /////////////////////////////////////////////// */

.body-feature{
  font-family: 'Tahoma', sans-serif;
  
  color: #fff;
  text-align: center;
  margin: 0;
  padding: 40px 0;
  direction: rtl;
}

.feature {
  background-color: #f1f5f9;
  border-radius: 12px;
  padding: 1.5rem 1rem;
  display: flex;
  flex-direction: column;
  align-items: center;
  box-shadow: 0 2px 6px rgba(0,0,0,0.06);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  cursor: pointer;
}

.feature:hover{
  transform: translateY(-6px);
  box-shadow: 0 6px 15px rgba(0,0,0,0.1);
}

.feature {
  width: 200px;
}
.feature-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
  gap: 1.5rem;
  max-width: 900px;
  margin: 0 auto;
}

.icon {
  font-size: 2.5rem;
  margin-bottom: 0.8rem;
  color: #3b82f6;
}

h3 {
  margin: 0;
  font-size: 18px;
  font-weight: bold;
}

p {
  font-size: 14px;
  margin-top: 5px;
  color: #555;
}
/* /////////////////////////////////////////////// */

.testimonials {
  font-family: 'Tahoma', sans-serif;
  margin: 0;
  background-color: #fff;
  direction: rtl;
  text-align: right;
  padding: 40px;
}

.testimonials {
  max-width: 1000px;
  margin: auto;
}

.testimonials h2 {
  font-size: 28px;
  font-weight: bold;
  margin-bottom: 5px;
  text-align: center;
}

.subtitle {
  color: #888;
  text-align: center;
  margin-bottom: 30px;
}

.testimonial {
  background-color: #f9f9f9;
  border-radius: 12px;
  padding: 20px;
  margin-bottom: 20px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.stars {
  color: #ffc107;
  font-size: 18px;
  margin-bottom: 10px;
}

.review {
  font-size: 16px;
  margin-bottom: 15px;
  color: #333;
}

.user-info {
  display: flex;
  align-items: center;
  gap: 10px;
}

.avatar {
  background-color: #2f70ff;
  color: #fff;
  width: 36px;
  height: 36px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
  font-size: 16px;
}

.date {
  font-size: 13px;
  color: #777;
}

    </style>


  <header>
    
    <nav>
      <a href="#hero">Home</a>
      <a href="#product">Products</a>
      <a href="#contact">Contact us</a>

      <?php if (isset($_SESSION['Nom_user']) && $_SESSION['Nom_user']!="") : ?>
      <a href="loginout.php">Sign out</a>
      <?php else : ?>

      <a href="logincom.php">Log in</a>
      <a href="logininscr.php">Create an account</a>
      <?php endif ; ?>
    </nav>
    <h1><span style="color : blue ;">DECO</span>RIFY</h1>
  </header>

  <section class="hero" id="hero">
    <div>
      <h2> WELCOME TO DECORIFY </h2>
      <p>The best products at competitive prices + exclusive discounts on all purchases!</p>
    </div>
  </section>

  <section class="categories">
  <h2>تصفح حسب الفئات</h2>
  <p>اكتشف مجموعة واسعة من المنتجات المميزة</p>
  <div class="category-grid">

    <div class="category-box">
      <i class="icon">🛏️</i>
      <span>bedroom</span>
    </div>

    <div class="category-box">
      <i class="icon">🛋️</i>
      <span>living room</span>
    </div>

    <div class="category-box">
      <i class="icon">👕</i>
      <span>Fashion</span>
    </div>

    <div class="category-box">
      <i class="icon">🚽</i>
      <span>bathroom</span>
    </div>

    <!-- <div class="category-box">
      <i class="icon"></i>
      <span>هدايا</span>
    </div> -->

    <div class="category-box">
      <i class="icon">😊</i>
      <span>أخرى</span>
    </div>
  </div>
</section>

  <section class="products">
    <div class="product" id="product">
      <img src="image/40.jpg" alt="منتج 1">
      <div class="product-info">
        <h3>سماعة بلوتوث</h3>
        <p>120 ر.س</p>
        <button>أضف إلى السلة</button>
      </div>
    </div>

    <div class="product" id="product">
      <img src="image/41.jpg" alt="منتج 2">
      <div class="product-info">
        <h3>ساعة ذكية</h3>
        <p>250 ر.س</p>
        <button>أضف إلى السلة</button>
      </div>
    </div>

    <div class="product" id="product">
      <img src="image/42.jpg" alt="منتج 3">
      <div class="product-info">
        <h3>حقيبة ظهر</h3>
        <p>90 ر.س</p>
        <button>أضف إلى السلة</button>
      </div>
    </div>

    <div class="product" id="product">
      <img src="image/43.jpg" alt="منتج 3">
      <div class="product-info">
        <h3>حقيبة ظهر</h3>
        <p>90 ر.س</p>
        <button>أضف إلى السلة</button>
      </div>
    </div>

    <div class="product" id="product">
      <img src="image/40.jpg" alt="منتج 3">
      <div class="product-info">
        <h3>حقيبة ظهر</h3>
        <p>90 ر.س</p>
        <button>أضف إلى السلة</button>
      </div>
    </div>

    <div class="product" id="product">
      <img src="image/40.jpg" alt="منتج 3">
      <div class="product-info">
        <h3>حقيبة ظهر</h3>
        <p>90 ر.س</p>
        <button>أضف إلى السلة</button>
      </div>
    </div>

    <div class="product" id="product">
      <img src="image/40.jpg" alt="منتج 3">
      <div class="product-info">
        <h3>حقيبة ظهر</h3>
        <p>90 ر.س</p>
        <button>أضف إلى السلة</button>
      </div>
    </div>

     <div class="product" id="product">
      <img src="image/40.jpg" alt="منتج 3">
      <div class="product-info">
        <h3>حقيبة ظهر</h3>
        <p>90 ر.س</p>
        <button>أضف إلى السلة</button>
      </div>
    </div>
</div>
  </section>

<section class="features">
  <div class="feature-grid">

    <div class="feature">
      <div class="icon">🕒</div>
      <h3>توصيل سريع</h3>
      <p>توصيل لجميع المناطق خلال 24 ساعة</p>
    </div>

    <div class="feature">
      <div class="icon">🛡️</div>
      <h3>ضمان الجودة</h3>
      <p>استرجاع مجاني خلال 14 يوم</p>
    </div>

    <div class="feature">
      <div class="icon">💳</div>
      <h3>دفع آمن</h3>
      <p>طرق دفع متعددة وآمنة</p>
    </div>

  </div>
</section>

    <section class="contact" id="contact">
    <h2> Contact us </h2>
    <form action="" method="post">
      <label for="Nom">Nom</label>
      <input type="text" id="Nom" name="Nom" placeholder=" Votre nom " required>

      <label for="Prenom">Prenom</label>
      <input type="text" id="Prenom" name="Prenom" placeholder="Votre prenom" required>

      <label for="Email"> Email </label>
      <input type="email" id="Email" name="Email" placeholder="example@email.com" required>

      <label for="Message">Messege</label>
      <textarea id="Messege" name="Messege" rows="5" placeholder="Write your message here ..." required></textarea>

      <button type="submit" name="send">send</button>
    </form>
  </section>

 <section class="testimonials">
    <h2>آراء عملائنا</h2>
    <p class="subtitle">ماذا يقول عملاؤنا عن منتجاتنا</p>

    <div class="testimonial">
      <div class="stars">★★★★★</div>
      <p class="review">
        "جودة المنتجات ممتازة جداً، وخدمة العملاء رائعة. سعيدة جداً بتجربتي مع متجركم."
      </p>
      <div class="user-info">
        <div class="avatar">س</div>
        <div>
          <strong>سارة محمد</strong>
          <div class="date">عميلة منذ 2020</div>
        </div>
      </div>
    </div>

    <div class="testimonial">
      <div class="stars">★★★★★</div>
      <p class="review">
        "التوصيل سريع جداً والمنتجات مطابقة للمواصفات. أنصح الجميع بالتسوق من هذا المتجر."
      </p>
      <div class="user-info">
        <div class="avatar">م</div>
        <div>
          <strong>محمد علي</strong>
          <div class="date">عميل منذ 2021</div>
        </div>
      </div>
    </div>
  </section>

  <footer>
    &copy; 2025  DECORIFY - Reserved All Rights
  </footer>
</body>
</html>
