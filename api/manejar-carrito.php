<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../app/index.php"); // Redirigir a la página de inicio si no hay sesión activa
    exit;
}

$carrito = [];
if (!$_SESSION['carrito']) {
    $_SESSION['carrito'] = $carrito;
}
else{
    $carrito = $_SESSION['carrito'];
}

if ($_POST['action'] == 'add') {
    $id = $_POST['id_libro'];
    $isbn = $_POST['isbn_libro'];
    $nombre = $_POST['nombre_libro'];
    $autor = $_POST['autor_libro'];

    // Crear un array asociativo para el libro
    $libro = [
        'id' => $id,
        'isbn' => $isbn,
        'nombre' => $nombre,
        'autor' => $autor
    ];

    // Agregar el libro al carrito
    $carrito[] = $libro;

    $_SESSION['carrito'] = $carrito;
    header("Location: ../app/dashboard/prestar-libro.php");
}
else if ($_POST['action'] == 'remove') {
    $id = $_POST['id'];
    $isbn = $_POST['isbn'];
    // Buscar el libro en el carrito y eliminarlo
    foreach ($carrito as $indice => $libro) {
        if ($libro['id'] == $id && $libro['isbn'] == $isbn) {
            unset($carrito[$indice]);
            break;
        }
    }
    $_SESSION['carrito'] = $carrito;
    header("Location: ../app/dashboard/prestar-libro.php");
}
else if ($_POST['action'] == 'get') {
    echo json_encode($carrito);
}
else if ($_POST['action'] == 'clear') {
    $_SESSION['carrito'] = [];
    header("Location: ../app/dashboard/prestar-libro.php");
}

?>