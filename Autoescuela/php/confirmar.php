<?php
include("include/bd.php");

$id = $_GET['id'];

BD::conecta();

if (BD::existeConfirmacion($id)) {
    $c = BD::leeConfirmacion($id);

    date_default_timezone_set("Europe/Madrid");

    $fecha_actual = date('Y-m-d H:i:s');
    $formato = 'Y-m-d H:i:s';
    $fecha_vencimiento = date($c->getfecha_vencimiento());

    var_dump($fecha_actual);
    var_dump($fecha_vencimiento);

    if ($fecha_actual < $fecha_vencimiento) {
        $correo = BD::leeCorreo($c->getid_usuario());

        header('Location: alta-usuario.php?correo='.$correo);

        echo "Te manda";

    } else {
        echo "Ha vencido";
    }
} else {
    header("Location: login.php");
}
?>