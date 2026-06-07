<?php
include "config.php";
include "funciones.php";

if (!isset($_SESSION['user']) || $_SESSION['rol'] != "solicitante") {
    header("Location: index.php");
    exit;
}

$email = trim($_SESSION['user']);

$mes  = isset($_GET['mes']) ? intval($_GET['mes']) : intval(date("m"));
$anio = isset($_GET['anio']) ? intval($_GET['anio']) : intval(date("Y"));

$vacaciones = leer_csv(VAC_FILE);

/* =========================
   RECONSTRUCCIÓN ROBUSTA
   (SOLO ÚLTIMO ESTADO VÁLIDO)
========================= */
$estado_dias = array();

if (is_array($vacaciones)) {

    foreach ($vacaciones as $v) {

        if (!isset($v[0], $v[1], $v[2], $v[3], $v[4])) continue;

        $email_v = trim($v[0]);
        $anio_v  = intval($v[1]);
        $mes_v   = intval($v[2]);
        $dia_v   = intval($v[3]);
        $st_v    = strtolower(trim($v[4]));

        if ($email_v === $email && $anio_v === $anio && $mes_v === $mes) {

            /* 🔥 CLAVE: sobrescribe siempre (último gana) */
            $estado_dias[$dia_v] = $st_v;
        }
    }
}

$dias = cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Solicitante</title>
<link rel="stylesheet" href="style.css">
<script src="script.js"></script>
</head>

<body>

<h2>Solicitante: <?php echo htmlspecialchars($email); ?></h2>

<p><a href="logout.php">Cerrar sesión</a></p>

<p>
<a href="?mes=<?php echo ($mes<=1?12:$mes-1); ?>&anio=<?php echo ($mes<=1?$anio-1:$anio); ?>">◀</a>
<strong><?php echo $mes."/".$anio; ?></strong>
<a href="?mes=<?php echo ($mes>=12?1:$mes+1); ?>&anio=<?php echo ($mes>=12?$anio+1:$anio); ?>">▶</a>
</p>

<table border="1">
<tr>

<?php
for ($i=1; $i<=$dias; $i++) {

    $class = "";

    if (isset($estado_dias[$i])) {

        switch ($estado_dias[$i]) {

            case "solicitado":
                $class = "selected";
                break;

            case "aceptado":
                $class = "approved";
                break;

            case "rechazado":
                $class = "rejected";
                break;
        }
    }

    echo "<td class='$class' onclick='cambiarEstadoSolicitante(this,$i,$mes,$anio)'>$i</td>";
}
?>

</tr>
</table>

</body>
</html>