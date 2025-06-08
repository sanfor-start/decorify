<?php 
$server="localhost";
$user="root";
$pass="";
$dbname="projet";
$connexion=mysqli_connect($server,$user,$pass,$dbname);
if (
    isset($_GET['Ajouter']) &&
    isset($_GET['Nom']) && $_GET['Nom'] != "" &&
    isset($_GET['Prenom']) && $_GET['Prenom'] != "" &&
    isset($_GET['Email']) && $_GET['Email'] != "" &&
    isset($_GET['Password']) && $_GET['Password'] != ""
) {
    $Nom = $_GET['Nom'];
    $Prenom = $_GET['Prenom'];
    $Email = $_GET['Email'];
    $Password = $_GET['Password'];
    $sql="INSERT INTO `logincom`(`Id`, `Nom`, `Prenom`, `Email`, `Password`) VALUES ( null,'$Nom','$Prenom','$Email','$Password')";
    mysqli_query($connexion, $sql);
    header("location: logincom.php");
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>إنشاء حساب</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background: #f4f4ff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .container {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 500px;
    }
    h2 {
      text-align: center;
      margin-bottom: 10px;
    }
    p.subtitle {
      text-align: center;
      color: #666;
      margin-bottom: 20px;
    }
    label {
      display: block;
      margin-bottom: 5px;
      margin-top: 15px;
    }
    input[type="text"], input[type="email"], input[type="password"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }
    .row {
      display: flex;
      gap: 10px;
    }
    .row .column {
      flex: 1;
    }
    .checkbox {
      margin-top: 20px;
      display: flex;
      align-items: center;
    }
    .checkbox input {
      margin-left: 5px;
    }
    .checkbox label a {
      color: #0d6efd;
      text-decoration: none;
    }
    .checkbox label a:hover {
      text-decoration: underline;
    }
    button {
      width: 100%;
      margin-top: 20px;
      padding: 10px;
      background: linear-gradient(to right, #0d6efd, #0d6efd);
      border: none;
      border-radius: 5px;
      color: white;
      font-size: 16px;
      cursor: pointer;
    }

    .btn-login {
      width: 100%;
      margin-top: 20px;
      padding: 10px;
      background: linear-gradient(to right, #0d6efd, #0d6efd);
      border: none;
      border-radius: 5px;
      color: white;
      font-size: 16px;
      cursor: pointer;
    }
    a{
      text-decoration:none;
      color:white;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2> Create an account </h2>
    <form>
      <div class="row">
        <div class="column">
          <label for="Nom"> Nom </label>
          <input type="text" name="Nom" id="Nom" placeholder=" Nom ">
        </div>
        <div class="column">
          <label for="Prenom"> Prenom </label>
          <input type="text" name="Prenom" id="Prenom" placeholder=" Prenom ">
        </div>
      </div>

      <label for="email"> Email </label>
      <input type="email" id="email" name="Email" placeholder=" Email ">

      <label for="password"> Password </label>
      <input type="password" name="Password" id="password" placeholder=" Password ">
      <small>Must contain at least 8 characters</small>

      <!-- <div class="checkbox">
        <input type="checkbox" id="agree">
        <label for="agree">أوافق على <a href="#">الشروط والأحكام</a></label>
      </div> -->

      <button type="submit" name="Ajouter"> Create an account </button>

      <button type="button" class="btn-login"><a href="logincom.php">log in</a></button>
    </form>
  </div>
</body>
</html>
