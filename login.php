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

    echo '<center><div class="mensaje error">&#10060; Usuario o contrase&ntilde;a incorrectos.</div><hr>';
	 echo "<a href='index.php'>Volver</a></center>";
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

<style>

.mensaje{

    width:420px;

    margin:20px auto;

    padding:15px 20px;

    border-radius:12px;

    font-family:Arial, Helvetica, sans-serif;

    font-size:16px;

    font-weight:bold;

    text-align:center;

    box-shadow:0px 3px 10px rgba(0,0,0,0.15);

    animation:aparece 0.4s;

}

.error{

    background:#ffebee;

    color:#c62828;

    border-left:8px solid #e53935;

}

.ok{

    background:#e8f5e9;

    color:#2e7d32;

    border-left:8px solid #43a047;

}

.info{

    background:#e3f2fd;

    color:#1565c0;

    border-left:8px solid #1e88e5;

}

@keyframes aparece{

    from{

        opacity:0;

        transform:translateY(-15px);

    }

    to{

        opacity:1;

        transform:translateY(0px);

    }

}

</style>
