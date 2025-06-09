<?php
include 'header.php';

$server = "localhost";
$user = "root";
$pass = "";
$dbname = "projet";
$connexion = mysqli_connect($server, $user, $pass, $dbname);

$error = "";
$_SESSION['Nom_user'] = "";

if (isset($_POST['Email']) && $_POST['Email'] != "" && isset($_POST['Password']) && $_POST['Password'] != "") {
    // Use prepared statements to prevent SQL injection
    $stmt = mysqli_prepare($connexion, "SELECT * FROM `logincom` WHERE Email=? AND password=?");
    mysqli_stmt_bind_param($stmt, "ss", $_POST['Email'], $_POST['Password']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    
    if ($data) {
        $_SESSION['Nom_user'] = $data['Nom'];
        header('location: index.php');
        exit;
    } else {
        $error = "Invalid email or password";
    }
}
?>

<div class="auth-container">
  <h2>Welcome Back</h2>
  
  <?php if ($error): ?>
    <div class="error-message"><?php echo $error; ?></div>
  <?php endif; ?>
  
  <form method="post" class="auth-form">
    <div class="form-group">
      <label for="Email">Email</label>
      <input type="email" id="Email" name="Email" placeholder="Enter your email" required>
    </div>
    
    <div class="form-group">
      <label for="Password">Password</label>
      <input type="password" id="Password" name="Password" placeholder="Enter your password" required>
    </div>
    
    <div class="checkbox">
      <input type="checkbox" id="show-password" onclick="togglePassword()">
      <label for="show-password">Show password</label>
    </div>
    
    <div class="form-group">
      <a href="#" class="forgot-link">Forgot your password?</a>
    </div>
    
    <button type="submit" class="auth-btn">Sign In</button>
    
    <div class="bottom-text">
      Don't have an account? <a href="register.php">Create a new account</a>
    </div>
  </form>
</div>

<script>
function togglePassword() {
  var passwordField = document.getElementById("Password");
  if (passwordField.type === "password") {
    passwordField.type = "text";
  } else {
    passwordField.type = "password";
  }
}
</script>

<?php include 'footer.php'; ?>
