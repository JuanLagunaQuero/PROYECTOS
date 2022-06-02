<?php

$c = 1;
$c = strpos($_SERVER["PHP_SELF"], "/", $c);
$c = strpos($_SERVER["PHP_SELF"], "/", $c + 1);
$c = strpos($_SERVER["PHP_SELF"], "/", $c + 1);
$inicio = $_SERVER["DOCUMENT_ROOT"] . substr($_SERVER["PHP_SELF"], 0, $c + 1);

require_once $inicio . "include/Entidades/Sesion.php";
require_once $inicio . "include/BD/BDVisita.php";

Sesion::iniciar();

$id_visita = $_POST['id_visita'];

BDVisita::borraVisita($id_visita);

$obj = new stdClass();
$obj->sucess = true;
echo json_encode($obj);
