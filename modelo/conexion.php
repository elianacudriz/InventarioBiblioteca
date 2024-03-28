<?php
$servername = "localhost";
$username_db = "root";
$password_db = "";
$database = "inventario";

$conexion = new mysqli($servername, $username_db, $password_db, $database);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
$conexion->set_charset("utf8");


   
?>