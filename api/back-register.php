<?php
session_start();

include "../modelo/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Getting data from the form
    $username = $_POST["user"];
    $password = $_POST["password"];

    // Hashing the password using md5
    $hashedPassword = md5($password);

    // Preparing the SQL query to insert data into the users table
    $stmt = $conexion->prepare("INSERT INTO usuario (user, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashedPassword);

    // Executing the SQL query
    if ($stmt->execute()) {
        // Redirecting to the login page after successful registration
        echo "<script>alert('Usuario registrado con éxito. Se hara redireccion a la pagina de inicio para que procesa con el login')</script>";
        header("Location: ../app/login/login.php"); 
        exit; // Ensure to stop the script execution after redirection
    } else {
        echo "<script>alert('Error al registrar el usuario.')</script>";
    }

    // Cerrar statement
    $stmt->close();
}

// Cerrar conexión
$conexion->close();
?>