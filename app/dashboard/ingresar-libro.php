<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
        <h1 class="text-center p-3"> </p-3>Ingreso de Libros BiblioApp</h1>
        <div class="container-fluid row">
        <form action="../../api/ingreso-libro-back.php" class="col-4 p-3" method="POST">
        <h3 class = "text-center text-secundary">Registro de libros</h3>
         
            <div class="mb-4">
                <label for="exampleInputEmail1" class="form-label">ISBN</label>
                <input type="text" class="form-control" name="isbn">
                </div>
            <div class="mb-4">
                <label for="exampleInputEmail1" class="form-label">Nombre del Libro</label>
                <input type="text" class="form-control" name="nombre">
            </div>
            <div class="mb-4">
                <label for="exampleInputEmail1" class="form-label">Autor del Libro</label>
                <input type="text" class="form-control" name="autor">
            </div>
              
          <button type="submit" class="btn btn-primary" name="procesar-ingreso-libro" value="ok">Registrar</button>
    
    </form>


    </div>

</div>
</body>
</html>