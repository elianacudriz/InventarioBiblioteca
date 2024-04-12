
<?php


session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../app/index.php"); // Redirigir a la página de inicio si no hay sesión activa
    exit;
}

include "../modelo/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['procesar-retorno-noticket'])) {
    $libro_id = $_POST['libro_id'];
    $libro_isbn = $_POST['libro_isbn'];

    // 1. Buscar en la tabla ticket_libro
    $stmt = $conexion->prepare("SELECT ticket_libro.ticket_id FROM ticket_libro,ticket WHERE ticket_libro.libro_id = ? AND ticket_libro.libro_isbn = ? AND ticket_libro.ticket_id = ticket.id AND ticket.estado = 1");
    $stmt->bind_param("is", $libro_id, $libro_isbn);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if($row === null){
        $_SESSION['mensaje'] = "Error buscando el ticket. Intente de nuevo";
        header("Location: ../app/dashboard/dashboard.php");
        exit();
       }
    $ticket_id = $row['ticket_id'];

    $valor = 2000;

    retornarValoresTicket($ticket_id,$valor,$conexion);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['procesar-retorno-ticket'])) {
    $ticket_id = $_POST['ticket_id'];
    $valor = 0;

    retornarValoresTicket($ticket_id,$valor,$conexion);
  
    
}

function retornarValoresTicket($ticket_id,$valor,$conexion){
     // Buscar en la tabla ticket
   $fecha_retorno = new DateTime();
   $stmt2 = $conexion->prepare("SELECT nombre, ticket.fecha_devolucion, ticket.prestador_tipo_de_documento, ticket.prestador_documento FROM ticket, prestador WHERE ticket.id = ? and ticket.prestador_tipo_de_documento = prestador.tipo_de_documento and ticket.prestador_documento = prestador.documento AND ticket.estado = 1");
   $stmt2->bind_param("i", $ticket_id);
   $stmt2->execute();
   $result2 = $stmt2->get_result();
   $row2 = $result2->fetch_assoc();
   if($row2 === null){
    $_SESSION['mensaje'] = "Error buscando el ticket. Intente de nuevo";
    header("Location: ../app/dashboard/dashboard.php");
    exit();
   }
   $fecha_devolucion = new DateTime($row2['fecha_devolucion']);
   $prestador_tipo_de_documento = $row2['prestador_tipo_de_documento'];
   $prestador_documento = $row2['prestador_documento'];
   $nombre_prestador = $row2['nombre'];
   

   // 2. Calcular la diferencia de fechas
   $interval = $fecha_devolucion->diff($fecha_retorno);
   $dias_diferencia = $interval->format('%r%a'); // %r incluirá el signo "-" si es negativo

   if ($dias_diferencia > 0) {
       $valor += $dias_diferencia * 500;
   }
   
   $qur = "SELECT libro.isbn, libro.id, libro.nombre, libro.autor from libro, ticket_libro where libro.id = ticket_libro.libro_id and libro.isbn = ticket_libro.libro_isbn and ticket_libro.ticket_id = ?";
   $stmt = $conexion->prepare($qur);
   $stmt->bind_param("i", $ticket_id);
   $stmt->execute();
   $result = $stmt->get_result();
   $libros_prestados = $result->fetch_all(MYSQLI_ASSOC);

   $libros = $libros_prestados;

       $respuesta_retorno= [
           'ticket_id' => $ticket_id,
           'fecha_devolucion' => $fecha_devolucion->format('Y-m-d'),
           'tipo_de_documento' => $prestador_tipo_de_documento,
           'documento' => $prestador_documento,
           'nombre_prestador' => $nombre_prestador,
           'valor' => $valor,
           'libros' => $libros
       ];

       $_SESSION['respuesta_retorno'] = $respuesta_retorno;
       #$jsonRespuesta =  json_encode($respuesta);

       if($respuesta_retorno !== null){
        header("Location: ../app/dashboard/retornar-libro.php?ticket=true");
    }
    else{
        echo "<script>alert('Error intentando retornar libro. Intente de nuevo.')</script>";
        header("Location: ../app/dashboard/dashboard.php");  
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizar-retorno'])) {
    if (!isset($_SESSION['respuesta_retorno'])) {
        $_SESSION['error'] = 'Error al actualizar el ticket.';
        header("Location: ../app/dashboard/error.php");
    exit;
}
    // Asegúrate de validar y/o sanear estos valores antes de usarlos
    $fecha_retorno = new DateTime();
    $valor = $_SESSION['respuesta_retorno']['valor'];
    $ticket_id = $_SESSION['respuesta_retorno']['ticket_id'];
    $libros = $_SESSION['respuesta_retorno']['libros'];

    if (!actualizarTicket($conexion, $fecha_retorno, $valor, $ticket_id,$libros)) {
        $_SESSION['error'] = 'Error al actualizar el ticket.';
    
    // Redirigir al usuario a una página de error
        header("Location: ../app/dashboard/error.php");
    exit();
    }
    else{
        $_SESSION['respuesta_retorno'] = [];
        $_SESSION['mensaje'] = "Libro retornado con éxito. ID del ticket: {$ticket_id}, con fecha de retorno: {$fecha_retorno->format('Y-m-d')}.";
        header("Location: ../app/dashboard/dashboard.php");
    
    }
}

function actualizarTicket($conexion, $fecha_retorno, $valor, $ticket_id,$libros) {
    $fecha_string = $fecha_retorno->format('Y-m-d');
    $stmt4 = $conexion->prepare("UPDATE ticket SET fecha_retorno = ?, valor = ?, estado = 0 WHERE id = ?");
    $stmt4->bind_param("sii",$fecha_string, $valor, $ticket_id);
    $stmt4->execute();

    if ($stmt4->errno) {
        echo json_encode(['error' => 'Error al actualizar el ticket.']);
        return false;
    }

    foreach ($libros as $libro) {
        $stmt5 = $conexion->prepare("UPDATE libro SET estado = 1 WHERE id = ? and isbn = ?");
        $stmt5->bind_param("is", $libro['id'], $libro['isbn']);
        $stmt5->execute();
        if ($stmt5->errno) {
            $mensaje = "Error al actualizar el libro {$libro['id']}:{$libro['isbn']}.";
            echo json_encode(['error' => $mensaje]);
            return false;
        }
    }

    return true;
}
?>