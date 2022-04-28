<?php
include "include/bd.php";
require_once "include/Usuario.php";
require_once "include/Login.php";
require_once "include/Sesion.php";
// Comprobamos si ya se ha enviado el formulario
$error = "";
if (isset($_POST['enviar'])) {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    if (empty($correo) || empty($contrasena))
        $error = "Debes introducir un correo y una contraseña";
    else {

        // Comprobamos si existe el usuario. Si existe se crea la variable de seion login
        Login::Identifica($correo, $contrasena);

        // Si el usuario es identificado se crea la variable de sesion login
        if (Login::UsuarioEstaLogueado()) {
            Sesion::escribir('usuario', BD::leeUsuario($correo, $contrasena));
            if(BD::rolUsuario(Sesion::usuario())=="administrador")
            {
                header("Location: ../admin/admin-inicio.php");
            }
            else
            {
                if(BD::rolUsuario(Sesion::usuario())=="alumno")
                {
                    header("Location: ../alumno/alumno-inicio.php");
                }
            }
            
        }
    }
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Login Autoescuela</title>
</head>

<body>
    <div id='login'>
        <form action='' method='post'>
            <fieldset>
                <legend>Login</legend>
                <div>
                    <?php echo $error; ?>
                </div>
                <div>
                    <label for='correo'>Correo:</label><br />
                    <input type='email' name='correo' id='correo' maxlength="50" /><br />
                </div>
                <div>
                    <label for='contrasena'>Contraseña:</label><br />
                    <input type='password' name='contrasena' id='contrasena' maxlength="50" /><br />
                </div>

                <div>
                    <input type='submit' name='enviar' value='Enviar' />
                </div>
            </fieldset>
        </form>
    </div>
</body>

</html>