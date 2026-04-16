// REGISTRAR ENTRADA
function registrarEntrada() {
    let datos = new FormData();
    datos.append("nombre", document.getElementById("nombre").value);
    datos.append("dni", document.getElementById("dni").value);
    datos.append("visitado", document.getElementById("visitado").value);
    datos.append("despacho", document.getElementById("despacho").value);

    fetch("registrar_entrada.php", {
        method: "POST",
        body: datos
    })
    .then(res => res.text())
    .then(respuesta => {
    let msg = document.getElementById("mensaje");
    msg.style.display = "block";

    setTimeout(() => {
        msg.style.display = "none";
    }, 3000);

    cargarVisitas();
});
}

// REGISTRAR SALIDA
function registrarSalida(id) {
    let datos = new FormData();
    datos.append("id", id);

    fetch("registrar_salida.php", {
        method: "POST",
        body: datos
    })
    .then(() => cargarVisitas());
}

// CARGAR DATOS DESDE MYSQL
function cargarVisitas() {
    fetch("obtener_visitas.php")
    .then(res => res.json())
    .then(data => {

        let tabla = document.getElementById("tabla");
        tabla.innerHTML = "";

        let activos = 0;
        let finalizados = 0;

        data.forEach(v => {
            if (!v.hora_salida) activos++;
            else finalizados++;

            tabla.innerHTML += `
            <tr>
                <td>${v.nombre}</td>
                <td>${v.dni}</td>
                <td>${v.persona_visitada}</td>
                <td>${v.despacho}</td>
                <td>${v.fecha}</td>
                <td>${v.hora_entrada}</td>
                <td>${v.hora_salida ?? "-"}</td>
                <td>${v.tiempo ?? "-"}</td>
                <td>
                    ${!v.hora_salida ? `<button onclick="registrarSalida(${v.id_visita})">Salida</button>` : "✔"}
                </td>
            </tr>`;
        });

        document.getElementById("total").textContent = data.length;
        document.getElementById("activos").textContent = activos;
        document.getElementById("finalizados").textContent = finalizados;

    });
}

// CARGAR AL INICIO
window.onload = cargarVisitas;