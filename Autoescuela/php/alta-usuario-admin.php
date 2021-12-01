<?php
include("include/bd.php");


if (isset($_POST["guardar"]))
{
    BD::conecta();
    if ($_POST["correo"]!="" && isset($_POST["nombre"]) && isset($_POST["apellidos"]) && isset($_POST["fecha_nacimiento"]) && isset($_POST["rol"]))
    {
        $usuario = new Usuario(NULL, $_POST["correo"], $_POST["nombre"], $_POST["apellidos"], "CONTRASEÑA", $_POST["fecha_nacimiento"], $_POST["rol"], 0, NULL);
        BD::insertaUsuario($usuario);   

        $u = BD::leeUsuario($_POST["correo"]);

        BD::insertaUsuarioConfirmar($u);

    }
    else{
        echo '<script> alert("Inserte todos los datos")</script>';
    }
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
        <input type="email" name="correo" id="correo"><br><br>
        <label for="nombre">Nombre</label><br>
        <input type="text" name="nombre" id="nombre"><br><br>
        <label for="apellidos">Apellidos</label><br>
        <input type="text" name="apellidos" id="apellidos"><br><br>
        <label for="fecha_nacimiento">Fecha de nacimiento</label><br>
        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"><br><br>
        <label for="rol">Rol</label><br>
        <select name="rol" id="rol">
            <option value="administrador">Administrador</option>
            <option value="alumno">Alumno</option>
        </select><br><br>
        <input type="submit" id="guardar" name="guardar" value="Guardar">
    </form>
</body>
</html>