<?php
include("include/bd.php");
include("include/Login.php");

BD::conecta();
if(isset($_GET['correo']))
{
    $correo = $_GET['correo'];

    $u = BD::leeUsuario($correo);
    
    if (isset($_POST["guardar"])) {
        if (isset($_POST["correo"]) && $_POST["nombre"] != "" && $_POST["apellidos"] != "" && $_POST["fecha_nacimiento"] != "" && $_POST["contrasena"]) {
    
            BD::actualizaUsuario($u->getid_usuario(), $_POST["nombre"], $_POST["apellidos"], $_POST["contrasena"], $_POST["fecha_nacimiento"], NULL);
    
            BD::borraConfirmacion($u->getid_usuario());
    
            Login::Identifica($_POST["correo"], $_POST["contrasena"], false);
            if (Login::UsuarioEstaLogueado()) {
                Sesion::escribir('usuario', BD::leeUsuario($_POST["correo"], $_POST["contrasena"]));
                header("Location: ../inicio.html");
            }
        } else {
            echo '<script> alert("Inserte todos los datos")</script>';
        }
    }
}
else
{
    Sesion::iniciar();
    if (!Login::UsuarioEstaLogueado()) {
        header("Location:login.php");
    }

    $correo = Sesion::usuario();

    $u = BD::leeUsuario($correo);

    if (isset($_POST["guardar"])) {
        if (isset($_POST["correo"]) && $_POST["nombre"] != "" && $_POST["apellidos"] != "" && $_POST["fecha_nacimiento"] != "" && $_POST["contrasena"]) {
    
            BD::actualizaUsuario($u->getid_usuario(), $_POST["nombre"], $_POST["apellidos"], $_POST["contrasena"], $_POST["fecha_nacimiento"], NULL);
    


        } else {
            echo '<script> alert("Inserte todos los datos")</script>';
        }
    }

}

    BD::conecta();
    
    

if (isset($_POST["guardar"])) {
    if (isset($_POST["correo"]) && $_POST["nombre"] != "" && $_POST["apellidos"] != "" && $_POST["fecha_nacimiento"] != "" && $_POST["contrasena"]) {

        BD::actualizaUsuario($u->getid_usuario(), $_POST["nombre"], $_POST["apellidos"], $_POST["contrasena"], $_POST["fecha_nacimiento"], NULL);

        header("Location: ../inicio.html");
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
        <label for="correo">Correo</label><br>
        <input type="email" name="correo" id="correo" readonly value="<?php echo $u->getcorreo(); ?>"><br><br>
        <label for="nombre">Nombre</label><br>
        <input type="text" name="nombre" id="nombre" value="<?php echo $u->getnombre(); ?>"><br><br>
        <label for="apellidos">Apellidos</label><br>
        <input type="text" name="apellidos" id="apellidos" value="<?php echo $u->getapellidos(); ?>"><br><br>
        <label for="fecha_nacimiento">Fecha de nacimiento</label><br>
        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="<?php echo $u->getfecha_nacimiento(); ?>"><br><br>
        <label for="contrasena">Contraseña</label><br>
        <input type="password" id="contrasena" name="contrasena" value="<?php if(isset($_GET['correo'])){return null;}else{echo $u->getfecha_nacimiento(); }
        ?>"><br><br>
        <input type="submit" id="guardar" name="guardar" value="Guardar">
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