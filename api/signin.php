<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 'On');
session_start();

include "../modelo/conexion.php";


    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $result = $conexion -> query("SELECT id FROM usuario WHERE user = '$username' and password = '$password'");
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

    $count = mysqli_num_rows($result);
        if($count != 1) {
      echo "<script>alert('Invalid Details. Please try again.')</script>";
      header("Location: ../app/login/login.php");  
        } 
        else {
                   $_SESSION['username'] = $username;
                   header("Location: ../app/dashboard/dashboard.php");   

    }

// Cerrar statement y conexión
$conexion->close();
?>
