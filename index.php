<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Sistema de Visitantes</title>
<link rel="stylesheet" href="styles.css">

<!-- ICONOS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

<?php if (!isset($_SESSION['usuario'])) { ?>

<!-- LOGIN -->
<div class="login">
    <h2>Login</h2>
    <input id="usuario" placeholder="Usuario">
    <input id="password" type="password" placeholder="Password">
    <button onclick="login()">Ingresar</button>
</div>

<?php } else { ?>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>Control</h2>
    <ul>
        <li><i class="fa fa-home"></i> Inicio</li>
        <li><i class="fa fa-file"></i> Registros</li>
        <li><i class="fa fa-chart-bar"></i> Reportes</li>
    </ul>
</div>

<!-- MAIN -->
<div class="main">

    <!-- TOPBAR -->
    <div class="topbar">
        <input type="text" placeholder="Buscar...">
        <span><?=$_SESSION['usuario']?></span>
        <a href="logout.php">Salir</a>
    </div>

    <!-- MENSAJE -->
    <div id="mensaje" style="display:none; color:green;">
        ✔ Se registró correctamente
    </div>

    <!-- CARDS -->
    <div class="cards">
        <div class="card purple">Total <span id="total">0</span></div>
        <div class="card orange">Activos <span id="activos">0</span></div>
        <div class="card blue">Finalizados <span id="finalizados">0</span></div>
    </div>

    <!-- FORMULARIO -->
    <div class="formulario">
        <h3>Registrar Visitante</h3>

        <input id="nombre" placeholder="Nombre completo">
        <input id="dni" placeholder="DNI">
        <input id="visitado" placeholder="Persona a visitar">
        <input id="despacho" placeholder="Despacho">

        <button onclick="registrarEntrada()">Registrar Entrada</button>
    </div>

    <!-- FILTROS -->
    <div class="filtros">
        <input type="date" id="filtroFecha">
        <input type="text" id="filtroDespacho" placeholder="Despacho">
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

    <!-- REPORTES -->
    <div class="reportes">
        <button onclick="reportePorDia()">Visitas por día</button>
        <button onclick="tiempoPromedio()">Tiempo promedio</button>
    </div>

</div>

<?php } ?>

<script src="script.js"></script>
</body>
</html>