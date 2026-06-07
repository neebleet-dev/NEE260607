<?php
include "config.php";
include "funciones.php";

if (!isset($_SESSION['user']) || $_SESSION['rol'] != "gestor") {
    header("Location: index.php");
    exit;
}

$users = leer_csv(USERS_FILE);
$vacaciones = leer_csv(VAC_FILE);

$mes  = isset($_GET['mes']) ? intval($_GET['mes']) : intval(date("m"));
$anio = isset($_GET['anio']) ? intval($_GET['anio']) : intval(date("Y"));

$estado = array();

/* =========================
   INDEXAR CSV (FIABLE)
========================= */
foreach ($vacaciones as $v) {

    if (!isset($v[0], $v[1], $v[2], $v[3], $v[4])) {
        continue;
    }

    $email = trim($v[0]);
    $y     = intval($v[1]);
    $m     = intval($v[2]);
    $d     = intval($v[3]);
    $st    = strtolower(trim($v[4]));

    $estado[$email][$y][$m][$d] = $st;
}

$dias = cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css">
<script src="script.js"></script>
</head>

<body>

<h2>Gestor</h2>

<p><a href="logout.php">Cerrar sesión</a></p>

<p>
<a href="?mes=<?php echo max(1,$mes-1); ?>&anio=<?php echo $anio; ?>">◀</a>
<strong><?php echo $mes."/".$anio; ?></strong>
<a href="?mes=<?php echo min(12,$mes+1); ?>&anio=<?php echo $anio; ?>">▶</a>
</p>

<table border="1">

<tr>
<th>Empleado</th>

<?php
for ($i=1; $i<=$dias; $i++) {
    echo "<th>$i</th>";
}
?>
</tr>

<?php
foreach ($users as $u) {

    if (!isset($u[0], $u[2]) || $u[2] != "solicitante") continue;

    $email = trim($u[0]);

    echo "<tr>";
    echo "<td>" . htmlspecialchars($email) . "</td>";

    for ($i=1; $i<=$dias; $i++) {

        $class = "";

        if (isset($estado[$email][$anio][$mes][$i])) {

            $st = $estado[$email][$anio][$mes][$i];

            if ($st == "solicitado") $class = "selected";
            if ($st == "aceptado")   $class = "approved";
            if ($st == "rechazado")  $class = "rejected";
        }

        echo "<td class='$class' onclick='cambiarEstadoGestor(this,\"$email\",$i,$mes,$anio)'>$i</td>";
    }

    echo "</tr>";
}
?>

</table>

</body>
</html>
<?
echo "<pre>";
echo VAC_FILE;
echo "\n";
echo realpath(VAC_FILE);
echo "</pre>";
exit;
?>