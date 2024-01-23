<?php
session_start();

if (isset($_SESSION['roles'])) {
    switch ($_SESSION['roles']) {
        case 0:
            header('Location: asistencia.php');
            break;
        case 1:
            header('Location: admin/index.php');
            break;
    }
} else {
    header("Location: index.php");
}
?>