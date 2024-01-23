<?php
session_start();

if (isset($_POST)) {
    include_once('conn.php');

    $usuario = $_POST['u'];
    $contrasena = $_POST['p'];

    $sql = "SELECT * FROM admin WHERE usuario = '$usuario'";
    $query = $conn->query($sql);

    if ($query->num_rows < 1) {
        $_SESSION['error'] = 'No se puede encontrar la cuenta con el nombre de usuario proporcionado';
    } else {
        $row = $query->fetch_assoc();
        if (password_verify($contrasena, $row['clave'])) {
            $_SESSION['admin'] = $row['id'];
        } else {
            $_SESSION['error'] = 'Contraseña incorrecta';
        }
    }
} else {
    $_SESSION['error'] = 'Ingrese las credenciales de administrador primero';
}

header('Location: index.php');
exit;
?>
