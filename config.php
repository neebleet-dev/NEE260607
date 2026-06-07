<?php
/* =========================
   INICIO DE SESIÓN
   IMPORTANTE: debe ser lo primero
========================= */
session_start();

/* =========================
   ARCHIVOS CSV
========================= */
define("USERS_FILE", "usuarios.csv");
define("VAC_FILE", "vacaciones.csv");

/* =========================
   CONFIGURACIÓN GENERAL
   (por si quieres crecer esto luego)
========================= */
date_default_timezone_set("Europe/Madrid");

?>