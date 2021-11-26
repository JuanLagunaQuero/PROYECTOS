<?php

include("include/bd.php");

BD::conecta();
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
        <label for="tematica">Tematica</label><br>
        <select name="tematica" id="tematica">
        <?php
            foreach (BD::leeTematicas() as $tematica) {
            echo '<option value="'.$tematica->getid_tematica().'">'.$tematica->getnombre().'</option>';}    
        ?>
        </select><br><br>
        <label for="enunciado">Enunciado</label><br>
        <textarea name="enunciado" id="enunciado" cols="30" rows="10"></textarea><br><br>

        <label for="opcion1">Opcion 1</label><br>
        <input type="text" name="opcion1" id="opcion1"> &nbsp; <input type="checkbox" value="1" id="product-1-1" name="check" /> correcta<br/>
    </form>
</body>
</html>