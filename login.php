<?php
include "config.php";
include "funciones.php";

/* Activar errores SOLO para depuración (quitar en producción) */
error_reporting(E_ALL);
ini_set('display_errors', 1);

/* Validación básica de entrada */
if (!isset($_POST['email']) || !isset($_POST['pass'])) {
    echo "Faltan datos de login. <a href='index.php'>Volver</a>";
    exit;
}

/* Limpiar datos */
$email = trim($_POST['email']);
$pass  = trim($_POST['pass']);

/* Buscar usuario en CSV */
$rol = usuario_valido($email, $pass);

/* Comprobación segura */
if ($rol === false) {

    echo "❌ Usuario o contraseña incorrectos. <a href='index.php'>Volver</a>";
    exit;

}

/* Iniciar sesión */
$_SESSION['user'] = $email;
$_SESSION['rol']  = $rol;

/* Redirección según rol */
if ($rol == "gestor") {

    header("Location: gestor.php");
    exit;

} elseif ($rol == "solicitante") {

    header("Location: solicitante.php");
    exit;

} else {

    /* Caso raro: rol corrupto en CSV */
    echo "❌ Rol inválido en el sistema. Contacta con el administrador.";
    exit;

}
?>