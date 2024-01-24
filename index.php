<?php
session_start();

if (isset($_SESSION['admin'])) {

    // Supongamos que las variables de sesión ya están definidas.
    $username = $_SESSION['usuario'];
    $password = $_SESSION['clave'];
    $roles = $_SESSION['roles'];

    if ($roles == 1) {
        header('Location: admin/index.php');
    } elseif ($roles == 2) {
        header('Location: asistencia.php');
    }
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticación</title>
    <link rel="stylesheet" href="css/estilo.css">

</head>
<body>
    <div class="login">
        <h1>Iniciar Sesión</h1>
        <form method="post" action="redireccionamiento.php">
            <input type="text" name="u" placeholder="Ingrese su Usuario" required="required" />
            <input type="password" name="p" placeholder="Ingrese su Contraseña" required="required" />
            <button type="submit" class="btn btn-primary btn-block btn-large">Ingresar</button>
        </form>
    </div>
</body>
</html>
