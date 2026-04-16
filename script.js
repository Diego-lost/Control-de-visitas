// =======================
// MENSAJES PRO
// =======================
function mostrarMensaje(texto, color = "green") {
    let msg = document.getElementById("mensaje");

    if (!msg) return; // evita error si no existe

    msg.textContent = texto;
    msg.style.color = color;
    msg.style.display = "block";

    setTimeout(() => {
        msg.style.display = "none";
    }, 3000);
}

// =======================
// LOADING
// =======================
function loading(show = true) {
    let tabla = document.getElementById("tabla");

    if (!tabla) return;

    if (show) {
        tabla.innerHTML = "<tr><td colspan='9'>⏳ Cargando...</td></tr>";
    }
}

// =======================
// LOGIN
// =======================
function login() {
    let usuario = document.getElementById("usuario");
    let password = document.getElementById("password");

    if (!usuario.value || !password.value) {
        mostrarMensaje("⚠ Completa los campos", "red");
        return;
    }

    let datos = new FormData();
    datos.append("usuario", usuario.value);
    datos.append("password", password.value);

    fetch("login.php", {
        method: "POST",
        body: datos
    })
    .then(res => res.text())
    .then(r => {
        if (r === "ok") {
            window.location.href = "dashboard.php";
        } else {
            mostrarMensaje("❌ Usuario o contraseña incorrecta", "red");
        }
    })
    .catch(() => {
        mostrarMensaje("❌ Error en login", "red");
    });
}

// =======================
// REGISTRAR ENTRADA
// =======================
function registrarEntrada(event) {

    let nombre = document.getElementById("nombre");
    let dni = document.getElementById("dni");
    let visitado = document.getElementById("visitado");
    let despacho = document.getElementById("despacho");

    if (!nombre.value || !dni.value || !visitado.value || !despacho.value) {
        mostrarMensaje("⚠ Completa todos los campos", "red");
        return;
    }

    let datos = new FormData();
    datos.append("nombre", nombre.value);
    datos.append("dni", dni.value);
    datos.append("visitado", visitado.value);
    datos.append("despacho", despacho.value);

    let btn = event?.target;
    if (btn) btn.disabled = true;

    fetch("registrar_entrada.php", {
        method: "POST",
        body: datos
    })
    .then(res => res.text())
    .then(() => {
        mostrarMensaje("✔ Se registró correctamente");
        limpiarCampos();
        cargarVisitas();
    })
    .catch(error => {
        console.error(error);
        mostrarMensaje("❌ Error al registrar", "red");
    })
    .finally(() => {
        if (btn) btn.disabled = false;
    });
}

// =======================
// REGISTRAR SALIDA
// =======================
function registrarSalida(id, event) {

    let btn = event?.target;
    if (btn) btn.disabled = true;

    let datos = new FormData();
    datos.append("id", id);

    fetch("registrar_salida.php", {
        method: "POST",
        body: datos
    })
    .then(() => {
        mostrarMensaje("✔ Salida registrada");
        cargarVisitas();
    })
    .catch(error => {
        console.error(error);
        mostrarMensaje("❌ Error en salida", "red");
    })
    .finally(() => {
        if (btn) btn.disabled = false;
    });
}

// =======================
// CARGAR VISITAS
// =======================
function cargarVisitas() {

    let tabla = document.getElementById("tabla");

    if (!tabla) return;

    loading(true);

    fetch("obtener_visitas.php")
    .then(res => res.json())
    .then(data => {

        tabla.innerHTML = "";

        let activos = 0;
        let finalizados = 0;

        if (data.length === 0) {
            tabla.innerHTML = "<tr><td colspan='9'>Sin registros</td></tr>";
            return;
        }

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
                    ${!v.hora_salida 
                        ? `<button onclick="registrarSalida(${v.id_visita}, event)">Salida</button>` 
                        : "✔"}
                </td>
            </tr>`;
        });

        document.getElementById("total").textContent = data.length;
        document.getElementById("activos").textContent = activos;
        document.getElementById("finalizados").textContent = finalizados;

    })
    .catch(error => {
        console.error(error);
        mostrarMensaje("❌ Error al cargar datos", "red");
    });
}

// =======================
// FILTRAR
// =======================
function filtrar() {

    let fecha = document.getElementById("filtroFecha").value;
    let despacho = document.getElementById("filtroDespacho").value.toLowerCase();

    let tabla = document.getElementById("tabla");
    if (!tabla) return;

    loading(true);

    fetch("obtener_visitas.php")
    .then(res => res.json())
    .then(data => {

        let filtrados = data.filter(v =>
            (fecha === "" || v.fecha === fecha) &&
            (despacho === "" || v.despacho.toLowerCase().includes(despacho))
        );

        tabla.innerHTML = "";

        if (filtrados.length === 0) {
            tabla.innerHTML = "<tr><td colspan='9'>Sin resultados</td></tr>";
            return;
        }

        filtrados.forEach(v => {
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
                <td>-</td>
            </tr>`;
        });

    })
    .catch(error => {
        console.error(error);
        mostrarMensaje("❌ Error al filtrar", "red");
    });
}

// =======================
// EXPORTAR CSV
// =======================
function exportarCSV() {

    fetch("obtener_visitas.php")
    .then(res => res.json())
    .then(data => {

        if (data.length === 0) {
            mostrarMensaje("No hay datos para exportar", "red");
            return;
        }

        let csv = "Nombre,DNI,Visitado,Despacho,Fecha,Entrada,Salida,Tiempo\n";

        data.forEach(v => {
            csv += `${v.nombre},${v.dni},${v.persona_visitada},${v.despacho},${v.fecha},${v.hora_entrada},${v.hora_salida ?? ""},${v.tiempo ?? ""}\n`;
        });

        let blob = new Blob([csv], { type: "text/csv" });
        let url = URL.createObjectURL(blob);

        let a = document.createElement("a");
        a.href = url;
        a.download = "visitas.csv";
        a.click();

        mostrarMensaje("✔ Archivo exportado");

    })
    .catch(error => {
        console.error(error);
        mostrarMensaje("❌ Error al exportar", "red");
    });
}

// =======================
// REPORTE POR DIA
// =======================
function reportePorDia() {

    fetch("obtener_visitas.php")
    .then(res => res.json())
    .then(data => {

        let conteo = {};

        data.forEach(v => {
            conteo[v.fecha] = (conteo[v.fecha] || 0) + 1;
        });

        console.log("Reporte por día:", conteo);
        mostrarMensaje("📊 Revisa la consola");

    })
    .catch(error => console.error(error));
}

// =======================
// TIEMPO PROMEDIO
// =======================
function tiempoPromedio() {

    fetch("obtener_visitas.php")
    .then(res => res.json())
    .then(data => {

        let total = 0;
        let count = 0;

        data.forEach(v => {
            if (v.hora_salida) {
                let entrada = new Date(v.fecha + " " + v.hora_entrada);
                let salida = new Date(v.fecha + " " + v.hora_salida);

                total += (salida - entrada);
                count++;
            }
        });

        if (count === 0) {
            mostrarMensaje("No hay datos", "red");
            return;
        }

        let prom = total / count / 1000;
        let h = Math.floor(prom / 3600);
        let m = Math.floor((prom % 3600) / 60);

        mostrarMensaje(`⏱ Promedio: ${h}h ${m}m`);

    })
    .catch(error => console.error(error));
}

// =======================
// LIMPIAR CAMPOS
// =======================
function limpiarCampos() {
    document.getElementById("nombre").value = "";
    document.getElementById("dni").value = "";
    document.getElementById("visitado").value = "";
    document.getElementById("despacho").value = "";
}

// =======================
// INICIO
// =======================
window.onload = () => {
    if (document.getElementById("tabla")) {
        cargarVisitas();
    }
};