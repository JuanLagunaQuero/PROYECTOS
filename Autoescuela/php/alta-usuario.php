<?php
include("include/bd.php");

$correo = $_GET['correo'];

BD::conecta();

$u = BD::leeUsuario($correo);

if (isset($_POST["guardar"])) {
    if (isset($_POST["correo"]) && $_POST["nombre"] != "" && $_POST["apellidos"] != "" && $_POST["fecha_nacimiento"] != "" && $_POST["contrasena"]) {

        BD::actualizaUsuario($u->getid_usuario(), $_POST["nombre"], $_POST["apellidos"], $_POST["contrasena"], $_POST["fecha_nacimiento"], NULL);

        BD::borraConfirmacion($u->getid_usuario());

        Login::Identifica($_POST["correo"], $contrasena, false);
        if (Login::UsuarioEstaLogueado()) {
            Sesion::escribir('usuario', BD::leeUsuario($_POST["correo"], $_POST["contrasena"]));
            header("Location: ../inicio.html");
        }
    } else {
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
        <input type="email" name="correo" id="correo" readonly value="<?php echo $u->getcorreo(); ?>"><br><br>
        <label for="nombre">Nombre</label><br>
        <input type="text" name="nombre" id="nombre" value="<?php echo $u->getnombre(); ?>"><br><br>
        <label for="apellidos">Apellidos</label><br>
        <input type="text" name="apellidos" id="apellidos" value="<?php echo $u->getapellidos(); ?>"><br><br>
        <label for="fecha_nacimiento">Fecha de nacimiento</label><br>
        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="<?php echo $u->getfecha_nacimiento(); ?>"><br><br>
        <label for="contrasena">Contraseña</label><br>
        <input type="password" id="contrasena" name="contrasena"><br><br>
        <input type="submit" id="guardar" name="guardar" value="Guardar">
    </form>
</body>

</html>