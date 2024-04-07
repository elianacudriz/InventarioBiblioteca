
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Descontinuar Libro</title>
<style>
body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  background-color: #f4f4f4;
}

.container {
  width: 400px; /* Ancho ajustado */
  margin: 50px auto;
}

.card {
  background-color: #fff;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
  text-align: center;
}

form {
  display: flex;
  flex-direction: column;
}

label {
  margin-bottom: 8px;
}

input[type="text"] {
  width: calc(100% - 20px); /* Se ajusta para tener en cuenta el padding */
  padding: 10px;
  margin-bottom: 20px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

input[type="submit"] {
  width: 100%;
  padding: 10px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type="submit"]:hover {
  background-color: #0056b3;
}

</style>
</head>
<body>

<div class="container">
  <div class="card">
    <h2>Descontinuar Libro</h2>

    <form action="../../api/descontinuar-libro-back.php" method="post">
      <label for="id">ID del Libro:</label>
      <input type="text" id="id" name="id">

      <input type="submit" name="procesar-descontinuar-libro" value="Descontinuar Libro"> <!-- Corregido el nombre del botón -->
    </form>
  </div>
</div>

</body>
</html>
