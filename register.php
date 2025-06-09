<?php
include 'header.php';

$server = "localhost";
$user = "root";
$pass = "";
$dbname = "projet";
$connexion = mysqli_connect($server, $user, $pass, $dbname);

$success = false;
$error = "";

if (
    isset($_POST['Ajouter']) &&
    isset($_POST['Nom']) && $_POST['Nom'] != "" &&
    isset($_POST['Prenom']) && $_POST['Prenom'] != "" &&
    isset($_POST['Email']) && $_POST['Email'] != "" &&
    isset($_POST['Password']) && $_POST['Password'] != ""
) {
    // Check if email already exists
    $check_stmt = mysqli_prepare($connexion, "SELECT * FROM `logincom` WHERE Email=?");
    mysqli_stmt_bind_param($check_stmt, "s", $_POST['Email']);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);
    
    if (mysqli_num_rows($check_result) > 0) {
        $error = "Email already exists. Please use a different email.";
    } else {
        // Use prepared statements to prevent SQL injection
        $stmt = mysqli_prepare($connexion, "INSERT INTO `logincom`(`Id`, `Nom`, `Prenom`, `Email`, `Password`) VALUES (null, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssss", $_POST['Nom'], $_POST['Prenom'], $_POST['Email'], $_POST['Password']);
        
        if (mysqli_stmt_execute($stmt)) {
            $success = true;
        } else {
            $error = "Registration failed. Please try again.";
        }
    }
}
?>

<div class="auth-container">
  <h2>Create an Account</h2>
  
  <?php if ($success): ?>
    <div class="success-message">
      Account created successfully! <a href="login.php">Sign in now</a>
    </div>
  <?php endif; ?>
  
  <?php if ($error): ?>
    <div class="error-message"><?php echo $error; ?></div>
  <?php endif; ?>
  
  <?php if (!$success): ?>
    <form method="post" class="auth-form">
      <div class="form-row">
        <div class="form-group">
          <label for="Nom">First Name</label>
          <input type="text" id="Nom" name="Nom" placeholder="Your first name" required>
        </div>
        
        <div class="form-group">
          <label for="Prenom">Last Name</label>
          <input type="text" id="Prenom" name="Prenom" placeholder="Your last name" required>
        </div>
      </div>
      
      <div class="form-group">
        <label for="Email">Email</label>
        <input type="email" id="Email" name="Email" placeholder="Enter your email" required>
      </div>
      
      <div class="form-group">
        <label for="Password">Password</label>
        <input type="password" id="Password" name="Password" placeholder="Create a password" required>
        <small>Must contain at least 8 characters</small>
      </div>
      
      <div class="checkbox">
        <input type="checkbox" id="show-password" onclick="togglePassword()">
        <label for="show-password">Show password</label>
      </div>
      
      <button type="submit" name="Ajouter" class="auth-btn">Create Account</button>
      
      <div class="bottom-text">
        Already have an account? <a href="login.php">Sign in</a>
      </div>
    </form>
  <?php endif; ?>
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
