<?php
include("include/bd.php");
include("include/Sesion.php");
include("include/Login.php");

Sesion::iniciar();
if (!Login::UsuarioEstaLogueado()) {
    header("Location:login.php");
}

if (isset($_POST["aceptar"])) {
    BD::conecta();
    if ($_POST["nombre"] != "") {
        $tematica = new Tematica(NULL, $_POST["nombre"]);
        BD::insertaTematica($tematica);
        var_dump($tematica);
    } else {
        echo '<script>alert("Inserte todos los datos")</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../estilos/css/main.css">
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
                <a href="../admin/usuarios.php">Usuarios</a>
                <ul class="submenu">
                    <li><a href="alta-usuario-admin.php">Alta de usuario</a></li>
                    <li><a href="#">Alta masiva</a></li>
                </ul>
            </li>
            <li class="categoria">
                <a href="../admin/tematicas.php">Tematicas</a>
                <ul class="submenu">
                    <li><a href="alta-tematica.php">Alta temática</a></li>
                </ul>
            </li>
            <li class="categoria">
                <a href="../admin/preguntas.php">Preguntas</a>
                <ul class="submenu">
                    <li><a href="alta-pregunta.php">Alta pregunta</a></li>
                    <li><a href="#">Alta masiva</a></li>
                </ul>
            </li>
            <li class="categoria">
                <a href="../admin/examenes.php">Examenes</a>
                <ul class="submenu">
                    <li><a href="../admin/alta-examen.php">Alta de examen</a></li>
                    <li><a href="../admin/inicio.php">Histórico</a></li>
                </ul>
            </li>
        </ul>
    </nav>


    <form action="" method="post" id="formTematica">
        <fieldset>
            <legend>Alta temática</legend>
            <p>
                <label for="nombre">Descripción</label><br>
                <input type="text" name="nombre" id="nombre"><br>
            </p>

            <p> 
                <input type="submit" id="aceptar" name="aceptar" value="Aceptar">
            </p>

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