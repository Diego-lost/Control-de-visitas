<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Sistema de Control de Visitantes</title>

<link rel="stylesheet" href="styles.css">

<!-- ICONOS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>

<div id="mensaje" style="display:none; color: green; font-weight: bold;">
    ✔ Se registró correctamente
</div>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>Control</h2>
    <ul>
        <li onclick="mostrarSeccion('inicio')"><i class="fa fa-home"></i> Inicio</li>
        <li onclick="mostrarSeccion('registros')"><i class="fa fa-file"></i> Registros</li>
        <li onclick="mostrarSeccion('reportes')"><i class="fa fa-chart-bar"></i> Reportes</li>
    </ul>
</div>

<!-- MAIN -->
<div class="main">

    <!-- TOP -->
    <div class="topbar">
        <input type="text" id="buscarNombre" placeholder="Buscar visitante...">
        <span>Admin</span>
    </div>

    <!-- ================= INICIO ================= -->
    <div id="inicio">

        <!-- CARDS -->
        <div class="cards">
            <div class="card purple">Total <span id="total">0</span></div>
            <div class="card orange">Activos <span id="activos">0</span></div>
            <div class="card blue">Finalizados <span id="finalizados">0</span></div>
        </div>

        <!-- FORM -->
        <div class="formulario">
            <h3>Registrar Visitante</h3>

            <input type="text" id="nombre" placeholder="Nombre completo">
            <input type="text" id="dni" placeholder="DNI">
            <input type="text" id="visitado" placeholder="Persona a visitar">
            <input type="text" id="despacho" placeholder="Despacho">

            <button onclick="registrarEntrada(event)">Registrar Entrada</button>
        </div>

    </div>

    <!-- ================= REGISTROS ================= -->
    <div id="registros" style="display:none;">

        <!-- FILTROS -->
        <div class="filtros">
            <input type="date" id="filtroFecha">
            <input type="text" id="filtroDespacho" placeholder="Filtrar despacho">
            <button onclick="filtrar()">Filtrar</button>
            <button onclick="exportarCSV()">Exportar CSV</button>
        </div>

        <!-- TABLA -->
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>DNI</th>
                    <th>Visitado</th>
                    <th>Despacho</th>
                    <th>Fecha</th>
                    <th>Entrada</th>
                    <th>Salida</th>
                    <th>Tiempo</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody id="tabla"></tbody>
        </table>

    </div>

    <!-- ================= REPORTES ================= -->
    <div id="reportes" style="display:none;">
        <div class="reportes">
            <button onclick="reportePorDia()">Visitas por día</button>
            <button onclick="tiempoPromedio()">Tiempo promedio</button>
        </div>
    </div>

</div>

<script src="script.js"></script>

<script>
// =======================
// CAMBIO DE SECCIONES
// =======================
function mostrarSeccion(seccion) {

    document.getElementById("inicio").style.display = "none";
    document.getElementById("registros").style.display = "none";
    document.getElementById("reportes").style.display = "none";

    document.getElementById(seccion).style.display = "block";

    if (seccion === "registros") {
        cargarVisitas();
    }
}
</script>

</body>
</html>