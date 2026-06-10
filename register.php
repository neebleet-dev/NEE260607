<?php
include "config.php";
include "funciones.php";

/* Activar errores SOLO para depuración */
error_reporting(E_ALL);
ini_set('display_errors', 1);

/* =========================
   PROCESAR REGISTRO
========================= */
if ($_POST) {

    $email = trim($_POST['email']);
    $pass  = trim($_POST['pass']);
    $rol   = trim($_POST['rol']);

    /* Validación básica */
    if ($email == "" || $pass == "" || $rol == "") {
        echo "❌ Todos los campos son obligatorios. <a href='register.php'>Volver</a>";
        exit;
    }

    /* Registrar usuario */
    $ok = registrar_usuario($email, $pass, $rol);

    if (!$ok) {
        echo "<center>El usuario ya existe. <a href='register.php'>Volver</a></center>";
        exit;
    }

    echo "<center>Usuario registrado correctamente.  <a href='index.php'>Ir al login</a></center>";
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Registro</title>
</head>
<body>

<h2>Registro de usuario</h2>

<form method="post" action="register.php">

    Email:<br>
    <input type="text" name="email"><br><br>

    Password:<br>
    <input type="password" name="pass"><br><br>

    Rol:<br>
    <select name="rol">
        <option value="solicitante">Solicitante</option>
        <option value="gestor">Gestor</option>
    </select><br><br>

    <button type="submit">Registrar</button>

</form>

<br>
<a href="index.php">Volver</a>

</body>
</html>