<?php
include("include/bd.php");
include("include/Sesion.php");
include("include/Login.php");


Sesion::iniciar();
if (!Login::UsuarioEstaLogueado()) {
    header("Location:login.php");
}

if (isset($_POST["guardar"])) {
    BD::conecta();
    if ($_POST["correo"] != "" && isset($_POST["nombre"]) && isset($_POST["apellidos"]) && isset($_POST["fecha_nacimiento"]) && isset($_POST["rol"])) {
        $usuario = new Usuario(NULL, $_POST["correo"], $_POST["nombre"], $_POST["apellidos"], "CONTRASENA", $_POST["fecha_nacimiento"], $_POST["rol"], 0, NULL);
        BD::insertaUsuario($usuario);

        $u = BD::leeUsuario($_POST["correo"]);

        BD::insertaUsuarioConfirmar($u);
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
    <link rel="stylesheet" href="../estilos/css/main.css">

    <title>Alta usuario</title>
</head>

<body>
    <header>
        <section>
            <img src="../estilos/images/logo.png" height="150px">
        </section>

        <section class="cuenta">
            <ul>
                <li class="categoria">
                    <img src="../estilos/images/sesion.png" height="100px">
                    <ul class="submenu">
                        <li><a href="ajax/logoff.php">Cerrar sesión</a></li>
                        <li><a href="formUsuario.php">Usuario</a></li>
                    </ul>
                </li>
            </ul>

        </section>

    </header>

    <nav>
        <ul>
            <li class="categoria">
                <a href="../admin/usuarios.html">Usuarios</a>
                <ul class="submenu">
                    <li><a href="alta-usuario-admin.php">Alta de usuario</a></li>
                    <li><a href="#">Alta masiva</a></li>
                </ul>
            </li>
            <li class="categoria">
                <a href="../admin/tematicas.html">Tematicas</a>
                <ul class="submenu">
                    <li><a href="alta-tematica.php">Alta temática</a></li>
                </ul>
            </li>
            <li class="categoria">
                <a href="../admin/preguntas.html">Preguntas</a>
                <ul class="submenu">
                    <li><a href="alta-pregunta.php">Alta pregunta</a></li>
                    <li><a href="#">Alta masiva</a></li>
                </ul>
            </li>
            <li class="categoria">
                <a href="../admin/examenes.html">Examenes</a>
                <ul class="submenu">
                    <li><a href="../admin/alta-examen.html">Alta de examen</a></li>
                    <li><a href="../admin/inicio.html">Histórico</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <form action="" method="post">
        <fieldset>
            <legend>Alta usuario</legend>
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

        </fieldset>

    </form>

    <footer>
        <hr>
        <section class="izq">
            <ul>
                <li><a href="">Guía de estilo</a></li>
                <li><a href="">Mapa del sitio web</a></li>
            </ul>
        </section>

        <section class="cent">
            <h3>Enlaces relacionados</h3>
            <ul>
                <li><a href="">DGT</a></li>
                <li><a href="">Solicitud oficial de examen</a></li>
                <li><a href="">Normativa de examen</a></li>
            </ul>
        </section>

        <section class="der">
            <h3>Contacto</h3>
            <ul>
                <li>Teléfono: 953111222</li>
                <li>email: info@examinator.es</li>
                <li>Redes sociales</li>
            </ul>
        </section>

    </footer>
</body>


</html>