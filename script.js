function cambiarEstadoSolicitante(td, dia, mes, anio) {

    let estado = "";

    if (td.classList.contains("selected")) {

        td.classList.remove("selected");
        estado = "libre";   // 🔥 IMPORTANTE: BORRA DEL CSV

    } else {

        td.classList.add("selected");
        estado = "solicitado";
    }

    guardarCambio("", dia, mes, anio, estado);
}

function cambiarEstadoGestor(td, email, dia, mes, anio) {

    let estado = "";

    if (td.classList.contains("selected")) {

        td.classList.remove("selected");
        td.classList.add("approved");
        estado = "aceptado";

    } else if (td.classList.contains("approved")) {

        td.classList.remove("approved");
        td.classList.add("rejected");
        estado = "rechazado";

    } else if (td.classList.contains("rejected")) {

        td.classList.remove("rejected");
        estado = "libre";

    } else {

        td.classList.add("selected");
        estado = "solicitado";
    }

    guardarCambio(email, dia, mes, anio, estado);
}

function guardarCambio(email, dia, mes, anio, estado) {

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "guardar.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.send(
        "email=" + encodeURIComponent(email) +
        "&dia=" + dia +
        "&mes=" + mes +
        "&anio=" + anio +
        "&estado=" + estado
    );
}