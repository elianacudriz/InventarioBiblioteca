<?php
session_start();
// include 'db.php';
$servername = "localhost";
$username_db = "root";
$password_db = "";
$database = "inventario";

//Crear conexión
$conn = new mysqli($servername, $username_db, $password_db, $database);

// Verificar conexión
if($con->connect_errno > 0){
    die('Sorry, We\'re experiencing some connection problems.');
    }

    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $sql = "SELECT id FROM usuario WHERE user = '$username' and password = '$password'";
      $result = mysqli_query($conn,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

    // $stmt = $con->prepare( "SELECT * FROM usuario WHERE user=? AND password=? LIMIT 1");
    // $stmt->bind_param('ss',$username,$password);
    //     $stmt->execute();
    //     $stmt->bind_result($FullName,$id);
    //     $rs= $stmt->fetch ();
    //     $stmt->close();
    $count = mysqli_num_rows($result);
        if($count != 1) {
      echo "<script>alert('Invalid Details. Please try again.')</script>";
      header("Location: ../login/login.php");  
        } 
        else {
                   $_SESSION['username'] = $username;
                   header("Location: ../dashboard/dashboard.php");   

    }

// Cerrar statement y conexión
$conn->close();
?>
