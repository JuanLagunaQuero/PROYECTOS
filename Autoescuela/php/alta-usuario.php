<?php
include("include/bd.php");

    $correo = $_GET['correo'];

    BD::conecta();

    BD::leeUsuario($correo);

if (isset($_POST["guardar"]))
{
        //BD::borraConfirmacion($id);
    
}
   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta usuario</title>
</head>
<body>
    <form action="" method="post">
        <label for="correo">Correo</label><br>
        <input type="email" name="correo" id="correo" readonly value=""><br><br>
        <label for="nombre">Nombre</label><br>
        <input type="text" name="nombre" id="nombre"><br><br>
        <label for="apellidos">Apellidos</label><br>
        <input type="text" name="apellidos" id="apellidos"><br><br>
        <label for="fecha_nacimiento">Fecha de nacimiento</label><br>
        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"><br><br>
        <label for="contraseña">Contraseña</label><br>
        <input type="password" id="contraseña" name="contraseña"><br><br>
        <input type="submit" id="guardar" name="guardar" value="Guardar">
    </form>
</body>
</html>