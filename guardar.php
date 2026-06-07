<?php
include "config.php";
include "funciones.php";

if (!isset($_SESSION['user'])) {
    exit;
}

$emailSession = trim($_SESSION['user']);

/* =========================
   USO INTELIGENTE DEL EMAIL
========================= */
$emailPost = isset($_POST['email']) ? trim($_POST['email']) : "";

/* 🔥 REGLA CLARA:
   - gestor puede mandar email
   - solicitante NO debe depender del POST
*/
$email = ($emailPost !== "" ? $emailPost : $emailSession);

$dia    = intval($_POST['dia']);
$mes    = intval($_POST['mes']);
$anio   = intval($_POST['anio']);
$estado = strtolower(trim($_POST['estado']));

$data = leer_csv(VAC_FILE);

$nuevo = array();

foreach ($data as $v) {

    if (!isset($v[0], $v[1], $v[2], $v[3], $v[4])) continue;

    if (
        trim($v[0]) == $email &&
        intval($v[1]) == $anio &&
        intval($v[2]) == $mes &&
        intval($v[3]) == $dia
    ) {
        continue;
    }

    $nuevo[] = $v;
}

if ($estado !== "libre") {
    $nuevo[] = array($email, $anio, $mes, $dia, $estado);
}

guardar_csv(VAC_FILE, $nuevo);

echo "OK";
?>