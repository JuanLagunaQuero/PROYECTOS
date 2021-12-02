<?php



include("include/bd.php");

Sesion::iniciar();
if (!Login::UsuarioEstaLogueado())
{
  header("Location:login.php");
}

if (isset($_POST["aceptar"]))
{
    if ($_POST["tematica"]!="" && $_POST["enunciado"]!="" && $_POST["opcion1"]!="" && $_POST["opcion2"]!="" 
    && $_POST["opcion3"]!="" && $_POST["opcion4"]!="" && $_POST["correcta"]!="")
    {
        $p=new Pregunta(NULL, $_POST["enunciado"], $_POST["tematica"], $_POST["correcta"], NULL, 
            [$_POST["opcion1"], $_POST["opcion2"], $_POST["opcion3"], $_POST["opcion4"]]);
        
    }
    else{
        echo '<script>alert("Inserte todos los datos")</script>';
    }
}

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
        <input type="text" name="opcion1" id="opcion1"> &nbsp; <input type="radio" name="correcta" id="opcion1"> Correcta<br/>
        <label for="opcion1">Opcion 2</label><br>
        <input type="text" name="opcion2" id="opcion2"> &nbsp; <input type="radio" name="correcta" id="opcion2"> Correcta<br/>
        <label for="opcion1">Opcion 3</label><br>
        <input type="text" name="opcion1" id="opcion3"> &nbsp; <input type="radio" name="correcta" id="opcion3"> Correcta<br/>
        <label for="opcion1">Opcion 4</label><br>
        <input type="text" name="opcion1" id="opcion4"> &nbsp; <input type="radio" name="correcta" id="opcion4"> Correcta<br/>

        <input type="submit" id="aceptar" name="aceptar" value="Aceptar">

    </form>
</body>
</html>