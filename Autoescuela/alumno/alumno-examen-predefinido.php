<?php
include("../php/include/bd.php");
include("../php/include/Sesion.php");
include("../php/include/Login.php");

Sesion::iniciar();
if (!Login::UsuarioEstaLogueado()) {
    header("Location: ../php/login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/css/main.css">
    <title>Document</title>
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
                        <li><a href="../php/ajax/logoff.php">Cerrar sesión</a></li>
                        <li><a href="../php/formUsuario.php">Usuario</a></li>
                    </ul>
                </li>
            </ul>

        </section>

    </header>

    <nav>
        <ul>
            <li class="categoria">

                <a href="alumno-inicio.php">Histórico</a>

            </li>
            <li class="categoria">
                <a href="alumno-examen-predefinido.php">Examen predefinido</a>

            </li>
            <li class="categoria">
                <a href="alumno-examen-aleatorio.php">Examen aleatorio</a>

            </li>


        </ul>
    </nav>
    <main>
        <table>

        </table>
    </main>

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