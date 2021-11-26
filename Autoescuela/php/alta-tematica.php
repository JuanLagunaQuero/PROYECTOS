<?php
include("include/bd.php");

if (isset($_POST["aceptar"]))
{
    BD::conecta();
    if (isset($_POST["nombre"]))
    {
        $tematica = new Tematica(NULL, $_POST["nombre"]);
        BD::insertaTematica($tematica);  
        var_dump($tematica);
    }
    else{
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
</head>
<body>
    <form action="" method="post">
        <label for="nombre">Descripción</label><br>
        <input type="text" name="nombre" id="nombre"><br>

        <input type="submit" id="aceptar" name="aceptar" value="Aceptar">
    </form>
    
</body>
</html>