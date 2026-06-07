<?php

/* =========================
   LECTURA CSV SEGURA
========================= */
function leer_csv($file) {

    $data = array();

    if (!file_exists($file)) {
        return $data;
    }

    $fp = fopen($file, "r");

    if (!$fp) {
        return $data;
    }

    while (($row = fgetcsv($fp, 1000, ",")) !== FALSE) {

        if ($row === null || $row === false) {
            continue;
        }

        $data[] = $row;
    }

    fclose($fp);

    return $data;
}

/* =========================
   ESCRITURA CSV SEGURA
========================= */
function guardar_csv($file, $data) {

    $fp = fopen($file, "w");

    if (!$fp) {
        return false;
    }

    foreach ($data as $row) {

        if (is_array($row)) {
            fputcsv($fp, $row);
        }
    }

    fclose($fp);

    return true;
}

/* =========================
   COMPROBAR USUARIO
========================= */
function usuario_valido($email, $pass) {

    $users = leer_csv(USERS_FILE);

    foreach ($users as $u) {

        if (!isset($u[0]) || !isset($u[1]) || !isset($u[2])) {
            continue;
        }

        $u_email = $u[0];
        $u_pass  = $u[1];
        $u_rol   = $u[2];

        if ($u_email == $email && $u_pass == $pass) {
            return $u_rol;
        }
    }

    return false;
}

/* =========================
   COMPROBAR SI EXISTE USUARIO
========================= */
function usuario_existe($email) {

    $users = leer_csv(USERS_FILE);

    foreach ($users as $u) {

        if (!isset($u[0])) {
            continue;
        }

        if ($u[0] == $email) {
            return true;
        }
    }

    return false;
}

/* =========================
   REGISTRAR USUARIO
========================= */
function registrar_usuario($email, $pass, $rol) {

    if (usuario_existe($email)) {
        return false;
    }

    $users = leer_csv(USERS_FILE);

    $users[] = array($email, $pass, $rol);

    return guardar_csv(USERS_FILE, $users);
}

?>