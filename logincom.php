<?php
$server="localhost";
$user="root";
$pass="";
$dbname="projet";
$connexion= mysqli_connect($server,$user,$pass,$dbname);

include("header/Header.php");
session_start();
$err = "";
$_SESSION['Nom_user']="";

if((isset($_POST['Email']) && $_POST['Email']!="") && isset($_POST['Password']) && $_POST['Password']!="")
{
    $Email = $_POST['Email'];
    $Password = ($_POST['Password']);

    $sql = "SELECT * FROM `logincom` WHERE Email='$Email' and password='$Password'";
    $result = mysqli_query($connexion,$sql);
    $data = mysqli_fetch_assoc($result);
    if($data)
    {
        $err ="OK";
        $_SESSION['Nom_user']=$data['Nom'];
        header('location: pageaceuil.php');
    }
    else
    {
        $err = "";
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
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
      max-width: 400px;
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
    .alert {
      background-color: #e0e7ff;
      padding: 10px;
      border-radius: 5px;
      color: #1e3a8a;
      text-align: center;
      font-size: 14px;
      margin-bottom: 20px;
    }
    label {
      display: block;
      margin-bottom: 5px;
      margin-top: 15px;
    }
    input[type="email"], input[type="password"], [type="text"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }
    .checkbox {
      margin-top: 10px;
      display: flex;
      align-items: center;
    }
    .checkbox input {
      margin-left: 5px;
    }
    .forgot {
      text-align: left;
      margin-top: 5px;
      font-size: 14px;
    }
    .forgot a {
      color: #0d6efd;
      text-decoration: none;
    }
    .forgot a:hover {
      text-decoration: underline;
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
    .btn-login {
      text-align: center;
      margin-top: 15px;
      font-size: 14px;
    }

    .btn-login-text a {
      color: #0d6efd;
      text-decoration: none;
    }

    .btn-login-text a:hover {
      text-decoration: underline;
    }  

    .btn-login:hover {
  background-color: #084cdf;
  transform: scale(1.05);
}


  </style>
</head>
<body>
  <h1><?= $err ?></h1>
  <div class="container">
    <h2>Welcome</h2>
    <form method="post">
      <label for="login">Username</label>
      <input type="email" id="login" name="Email" placeholder="Username">

      <label for="Password">Mot de Passe</label>
      <input type="password" id="Password" name="Password" placeholder="password" required>

       <div class="checkbox">
        <input type="checkbox" onclick="Password.type = this.checked ? 'text' : 'password'">
      </div> 

      <div class="forgot">
        <a href="#">Forgot your password?</a>
      </div>

      <input type="submit" class="btn-login" value="log in"></input>
      <!-- <button class="btn-login" type="button"><a href="logininscr.php?inscr">Inscription</a></button> -->
    </form>
    <br>
    <div class="bottom-text">
      Don't have an account ?<a href="logininscr.php?inscr">Create a new account</a>
    </div>
  </div>
</body>
</html>
