
<!doctype html>
<html>
<head>
    <title>Registro de Usuarios</title>
</head>
<body>
    <h2>Página de Registro</h2>
    <a href="../index.php">Click para ir atrás</a><br/><br/>
    <form action="../../api/back-register.php" method="POST">
       Ingrese usuario: <input type="text" name="user" id="user" required="required" /> <br/>
       Ingrese contraseña: <input type="password" name="password" id="password" required="required" /> <br/>
       <input type="submit" value="Register"/>
    </form>
</body>
</html>
