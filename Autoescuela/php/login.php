<?php
    include "include/bd.php";
    require_once "include/usuario.php";
    require_once "include/Sesion.php";

    $error="";

    if(isset($_POST['entrar']))
    {
        
    }
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../css/login.css">
    
</head>
<body>
<form action='' method='post' id="form1">

            <label for='correo' >Correo:</label><br/>
            <input type='email' name='correo' id='correo' maxlength="50" /><br/>

            <label for='password' >Contraseña:</label><br/>
            <input type="password" name="password" id="password" maxlength="50"><br/>
            

            <input type='submit' name='entrar' value='Entrar' />
            
    </form>
    <a href="recuperar-contraseña.php">¿Has olvidado tu contraseña?</a>
</body>
</html>