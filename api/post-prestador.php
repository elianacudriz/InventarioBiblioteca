<?php
session_start();


if (!isset($_SESSION['username'])) {
    header("Location: ../app/index.php"); // Redirigir a la página de inicio si no hay sesión activa
    exit;
}

include "../modelo/conexion.php";


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buscar_prestador'])) {
    $tipo_de_documento = $_POST['tipo_de_documento'];
    $documento = $_POST['documento'];

    $stmt = $conexion->prepare("SELECT * FROM prestador WHERE tipo_de_documento = ? AND documento = ?");
    $stmt->bind_param("ss", $tipo_de_documento, $documento);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $r = $result->fetch_assoc();
        $_SESSION['prestador'] = $r;

    } else {
        $_SESSION['prestador'] = null;
    }

    header("Location: ../app/dashboard/prestar-libro.php?prestador=true");
    exit;
}


?>