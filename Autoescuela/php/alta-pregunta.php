<?php
include("include/bd.php");
include("include/Sesion.php");
include("include/Login.php");
BD::conecta();

Sesion::iniciar();
if (!Login::UsuarioEstaLogueado()) {
    header("Location:login.php");
}

if (isset($_POST["aceptar"])) {
    if (
        $_POST["tematica"] != "" && $_POST["enunciado"] != "" && $_POST["opcion1"] != "" && $_POST["opcion2"] != ""
        && $_POST["opcion3"] != "" && $_POST["opcion4"] != "" && $_POST["correcta"] != ""
    ) {
        $p = new Pregunta(
            NULL,
            $_POST["enunciado"],
            $_POST["tematica"],
            NULL,
            NULL,
            [$_POST["opcion1"], $_POST["opcion2"], $_POST["opcion3"], $_POST["opcion4"]]
        );

        BD::insertaPregunta($p);

        $id_pregunta = BD::leeIdPregunta($_POST["enunciado"]);

        foreach($p->getrespuestas() as $respuesta)
        {
            $r = new Respuesta(null, $respuesta, $id_pregunta);
            BD::insertaRespuestas($r);
        }

        $rc = BD::leeIdRespuesta($_POST[$_POST["correcta"]]);

        BD::asignaRespuestaCorrecta($id_pregunta, $rc);

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
    <link rel="stylesheet" href="../estilos/css/main.css">
    <title>Document</title>
</head>

<body>

    <header>
        <section>
            <img src="../estilos/images/logo.png" height="100px">
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
            <legend>Alta de preguntas</legend>
            <label for="tematica">Tematica</label><br>
            <select name="tematica" id="tematica">
                <?php
                foreach (BD::leeTematicas() as $tematica) {
                    echo '<option value="' . $tematica->getid_tematica() . '">' . $tematica->getnombre() . '</option>';
                }
                ?>
            </select><br><br>
            <label for="enunciado">Enunciado</label><br>
            <textarea name="enunciado" id="enunciado" cols="30" rows="5"></textarea><br><br>

            <label for="opcion1">Opcion 1</label><br>
            <input type="text" name="opcion1" id="opcion1"> &nbsp; <input type="radio" name="correcta" value="opcion1"> Correcta<br />
            <label for="opcion1">Opcion 2</label><br>
            <input type="text" name="opcion2" id="opcion2"> &nbsp; <input type="radio" name="correcta" value="opcion2"> Correcta<br />
            <label for="opcion1">Opcion 3</label><br>
            <input type="text" name="opcion3" id="opcion3"> &nbsp; <input type="radio" name="correcta" value="opcion3"> Correcta<br />
            <label for="opcion1">Opcion 4</label><br>
            <input type="text" name="opcion4" id="opcion4"> &nbsp; <input type="radio" name="correcta" value="opcion4"> Correcta<br />

            <input type="submit" id="aceptar" name="aceptar" value="Aceptar">

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