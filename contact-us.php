<?php 

$server="localhost";
$user="root";
$pass="";
$dbname="projet";
$connexion=mysqli_connect($server,$user,$pass,$dbname);
if (
    isset($_GET['send']) &&
    isset($_GET['Nom']) && $_GET['Nom'] != "" &&
    isset($_GET['Prenom']) && $_GET['Prenom'] != "" &&
    isset($_GET['Email']) && $_GET['Email'] != "" &&
    isset($_GET['Messege']) && $_GET['Messege'] != "" 
) {
    $Nom = $_GET['Nom'];
    $Prenom = $_GET['Prenom'];
    $Email = $_GET['Email'];
    $Messege = $_GET['Messege'];
    $sql="INSERT INTO `contact us`(`Id`, `Nom`, `Prenom`, `Email`, `Messege`) VALUES ( null,'$Nom','$Prenom','$Email','$Messege')";
    mysqli_query($connexion, $sql);
    header("location: contact-us.php");
}


?>


