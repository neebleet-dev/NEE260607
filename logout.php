<?php
include "config.php";

/* Destruir sesión */
session_unset();
session_destroy();

/* Volver al login */
header("Location: index.php");
exit;
?>