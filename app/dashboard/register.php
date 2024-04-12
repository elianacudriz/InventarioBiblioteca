
<!doctype html>
<html>
<head>
    <title>Registro de Usuarios</title>

    <style>
body {
  /*text-shadow: 0 .05rem .1rem rgba(0, 0, 0, .5);
  box-shadow: inset 0 0 5rem rgba(0, 0, 0, .5);*/

  background-image: url('https://cdn.pixabay.com/photo/2016/03/09/15/29/books-1246674_1280.jpg'); /* Cambia 'ruta/a/la/imagen.jpg' a la ruta de tu imagen */
  background-size: cover; /* Para cubrir todo el fondo */
  background-repeat: no-repeat;
  background-attachment: fixed;
  font-size: 18px; /* Tamaño de letra base para todo el documento */
  color: black; /* Color de texto base para todo el documento */

 }

 form {
            margin: 0 auto;
            width: 600px; /* Ajusta el ancho según tus necesidades */
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.8); /* Fondo blanco semi-transparente */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-size: 30px; /* Tamaño de letra para el formulario */
        }

        a {
            display: block;
            text-align: center;
            font-size: 30px; /* Tamaño de letra para el enlace */
            color: #fff; /* Color del enlace */
            margin-top: 10px; /* Espacio superior */
        }

 
 h2, a {
            text-align: center;
            color: white; /* Cambia el color del texto según tus necesidades */
        }

        h2 {
            text-align: center;
            font-size: 50px; /* Tamaño de letra para el encabezado */
        }

        /* Estilos para el botón */
        input[type="submit"] {
            background-color: #007bff; /* Azul */
            color: white; /* Texto blanco */
            padding: 10px 20px; /* Ajusta el padding según tus necesidades */
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 20px; /* Tamaño de la letra */
            margin-top: 10px; /* Espacio superior */
            width: 40%; /* Ancho del botón igual al 100% del contenedor */
            box-sizing: border-box; /* Incluye padding y border en el ancho */
        }

        input[type="submit"]:hover {
            background-color: #0056b3; /* Azul oscuro al pasar el ratón */
            }
        /* Estilos para los elementos de entrada */
        input[type="text"],
        input[type="password"] {
            font-size: 25px; /* Tamaño de letra para los elementos de entrada */
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            width: 100%; /* Ancho completo */
        }
        
    </style>
</head>
<body>


    <h2>Página de Registro</h2>
    
    <form action="../../api/back-register.php" method="POST">
       Ingrese usuario: <input type="text" name="user" id="user" required="required" /> <br/>
       Ingrese contraseña: <input type="password" name="password" id="password" required="required" /> <br/>
       <input type="submit" value="Register"/>
    </form>

    <strong><a href="../index.php" style="color: black">Click para Regresar</a></strong><br/><br/>
</body>
</html>