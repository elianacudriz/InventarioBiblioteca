
<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'On');

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php"); // Redirigir a la página de inicio si no hay sesión activa
    exit;
}

include "../modelo/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $libro_id = $_POST['libro_id'];
    $fecha_retorno = $_POST['fecha_retorno'];

    // 1. Buscar en la tabla ticket_libro
    $stmt = $conexion->prepare("SELECT ticket_id FROM ticket_libro WHERE libro_id = ?");
    $stmt->bind_param("i", $libro_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $ticket_id = $row['ticket_id'];

    // Buscar en la tabla ticket
    $stmt2 = $conexion->prepare("SELECT fecha_devolucion FROM ticket WHERE id = ?");
    $stmt2->bind_param("i", $ticket_id);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    $row2 = $result2->fetch_assoc();
    $fecha_devolucion = $row2['fecha_devolucion'];

    // 2. Calcular la diferencia de fechas
    $fecha_devolucion = new DateTime($fecha_devolucion);
    $fecha_retorno = new DateTime($fecha_retorno);
    $interval = $fecha_devolucion->diff($fecha_retorno);
    $dias_diferencia = $interval->format('%r%a'); // %r incluirá el signo "-" si es negativo

    $valor = 0;
    if ($dias_diferencia > 0) {
        $valor = $dias_diferencia * 500 + 2000;
    }

    // 3. Actualizar la tabla ticket
    $stmt3 = $conexion->prepare("UPDATE ticket SET fecha_retorno = ?, valor = ?, estado = 0 WHERE id = ?");
    $stmt3->bind_param("sii", $fecha_retorno->format('Y-m-d'), $valor, $ticket_id);
    $stmt3->execute();

    if ($stmt3->errno) {
        echo "<script>alert('Error al actualizar el ticket.')</script>";
    } else {
        echo "<script>alert('Ticket actualizado con éxito.')</script>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ticket_id = $_POST['id'];
    $fecha_retorno = $_POST['fecha_retorno'];

    // Buscar en la tabla ticket
    $stmt = $conexion->prepare("SELECT fecha_devolucion FROM ticket WHERE id = ?");
    $stmt->bind_param("i", $ticket_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $fecha_devolucion = $row['fecha_devolucion'];

    // Calcular la diferencia de fechas
    $fecha_devolucion = new DateTime($fecha_devolucion);
    $fecha_retorno = new DateTime($fecha_retorno);
    $interval = $fecha_devolucion->diff($fecha_retorno);
    $dias_diferencia = $interval->format('%r%a'); // %r incluirá el signo "-" si es negativo

    $valor = 0;
    if ($dias_diferencia > 0) {
        $valor = $dias_diferencia * 500;
    }

    // Actualizar la tabla ticket
    $stmt2 = $conexion->prepare("UPDATE ticket SET fecha_retorno = ?, valor = ?, estado = 0 WHERE id = ?");
    $stmt2->bind_param("sii", $fecha_retorno->format('Y-m-d'), $valor, $ticket_id);
    $stmt2->execute();

    if ($stmt2->errno) {
        echo "<script>alert('Error al actualizar el ticket.')</script>";
    } else {
        echo "<script>alert('Ticket actualizado con éxito.')</script>";
    }
}

?>