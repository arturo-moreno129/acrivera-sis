<?php
include "header.php";

/* =========================================================
   DASHBOARD DE INVENTARIO
   ========================================================= */


/* =========================================================
   1. FILTROS
   ========================================================= */

$where = [];


/* Usuario */

if (isset($_GET['usuario']) && $_GET['usuario'] !== '') {

    $usuario = mysqli_real_escape_string(
        $con,
        $_GET['usuario']
    );

    $where[] = "usuario_asignado = '$usuario'";
}


/* Tipo de equipo */

if (isset($_GET['tipo']) && $_GET['tipo'] !== '') {

    $tipo = mysqli_real_escape_string(
        $con,
        $_GET['tipo']
    );

    $where[] = "tipo_equipo = '$tipo'";
}


/* Departamento */

if (isset($_GET['departamento']) && $_GET['departamento'] !== '') {

    $departamento = mysqli_real_escape_string(
        $con,
        $_GET['departamento']
    );

    $where[] = "departamento = '$departamento'";
}


/* Estatus */

if (isset($_GET['estatus']) && $_GET['estatus'] !== '') {

    $estatus = (int) $_GET['estatus'];

    $where[] = "estatus = $estatus";
}


/* Buscador */

if (isset($_GET['q']) && trim($_GET['q']) !== '') {

    $q = mysqli_real_escape_string(
        $con,
        trim($_GET['q'])
    );

    $where[] = "(
        usuario_asignado LIKE '%$q%'
        OR modelo LIKE '%$q%'
        OR marca LIKE '%$q%'
        OR no_serie LIKE '%$q%'
        OR nom_host LIKE '%$q%'
        OR departamento LIKE '%$q%'
        OR Ubicacion LIKE '%$q%'
    )";
}


/* Construcción del WHERE */

$whereSQL = '';

if (!empty($where)) {

    $whereSQL = 'WHERE ' . implode(' AND ', $where);
}


/* =========================================================
   2. MÉTRICAS
   ========================================================= */

// Use the current filters ($whereSQL) for metrics and charts
$totalQ = "SELECT COUNT(*) AS total FROM inventario " . $whereSQL;


// Active count inside the filtered set
$activeFilter = ($whereSQL !== '')
    ? $whereSQL . ' AND estatus = 1'
    : 'WHERE estatus = 1';

$activeQ = "SELECT COUNT(*) AS total FROM inventario " . $activeFilter;


// Datos por tipo: aplicar filtros y además excluir valores vacíos
$byTypeQ = "SELECT tipo_equipo, COUNT(*) AS total FROM inventario ";
$byTypeQ .= ($whereSQL !== '') ? $whereSQL . " AND tipo_equipo IS NOT NULL AND tipo_equipo != ''" : "WHERE tipo_equipo IS NOT NULL AND tipo_equipo != ''";
$byTypeQ .= " GROUP BY tipo_equipo ORDER BY total DESC LIMIT 10";


// Datos por departamento: aplicar filtros y excluir vacíos
$byDeptQ = "SELECT departamento, COUNT(*) AS total FROM inventario ";
$byDeptQ .= ($whereSQL !== '') ? $whereSQL . " AND departamento IS NOT NULL AND departamento != ''" : "WHERE departamento IS NOT NULL AND departamento != ''";
$byDeptQ .= " GROUP BY departamento ORDER BY total DESC LIMIT 10";


/* =========================================================
   3. EJECUTAR MÉTRICAS
   ========================================================= */

$total = 0;
$active = 0;


$totalResult = mysqli_query(
    $con,
    $totalQ
);


if ($totalResult) {

    $row = mysqli_fetch_assoc(
        $totalResult
    );

    $total = (int) ($row['total'] ?? 0);
}


$activeResult = mysqli_query(
    $con,
    $activeQ
);


if ($activeResult) {

    $row = mysqli_fetch_assoc(
        $activeResult
    );

    $active = (int) ($row['total'] ?? 0);
}


$inactive = max(
    0,
    $total - $active
);


/* Porcentajes */

$activePercent = $total > 0
    ? round(($active / $total) * 100)
    : 0;


$inactivePercent = $total > 0
    ? round(($inactive / $total) * 100)
    : 0;


/* =========================================================
   4. DATOS POR TIPO
   ========================================================= */

$typeLabels = [];
$typeData = [];


$typesRes = mysqli_query(
    $con,
    $byTypeQ
);


if ($typesRes) {

    while (
        $r = mysqli_fetch_assoc($typesRes)
    ) {

        $typeLabels[] =
            $r['tipo_equipo'];

        $typeData[] =
            (int) $r['total'];
    }
}


/* =========================================================
   5. DATOS POR DEPARTAMENTO
   ========================================================= */

$deptLabels = [];
$deptData = [];


$deptRes = mysqli_query(
    $con,
    $byDeptQ
);


if ($deptRes) {

    while (
        $r = mysqli_fetch_assoc($deptRes)
    ) {

        $deptLabels[] =
            $r['departamento'];

        $deptData[] =
            (int) $r['total'];
    }
}


/* =========================================================
   6. CONSULTA PRINCIPAL DEL INVENTARIO
   ========================================================= */

$listQ = "
    SELECT *
    FROM inventario
    $whereSQL
    ORDER BY id_inventario DESC
";


$res = mysqli_query(
    $con,
    $listQ
);


/* =========================================================
   7. OPCIONES DE FILTROS
   ========================================================= */

$usersOpt = mysqli_query(
    $con,
    "
    SELECT DISTINCT usuario_asignado
    FROM inventario
    WHERE usuario_asignado IS NOT NULL
    AND usuario_asignado != ''
    ORDER BY usuario_asignado
    "
);


$tipoOpt = mysqli_query(
    $con,
    "
    SELECT DISTINCT tipo_equipo
    FROM inventario
    WHERE tipo_equipo IS NOT NULL
    AND tipo_equipo != ''
    ORDER BY tipo_equipo
    "
);


$deptOpt = mysqli_query(
    $con,
    "
    SELECT DISTINCT departamento
    FROM inventario
    WHERE departamento IS NOT NULL
    AND departamento != ''
    ORDER BY departamento
    "
);


/* =========================================================
   8. VALORES ACTUALES DE LOS FILTROS
   ========================================================= */

$currentUsuario =
    $_GET['usuario'] ?? '';

$currentTipo =
    $_GET['tipo'] ?? '';

$currentDepartamento =
    $_GET['departamento'] ?? '';

$currentEstatus =
    $_GET['estatus'] ?? '';

$currentSearch =
    $_GET['q'] ?? '';

?>

<style>

/* =========================================================
   VARIABLES
   ========================================================= */

:root {

    --primary: #2563eb;
    --primary-hover: #1d4ed8;

    --success: #16a34a;
    --success-light: #dcfce7;

    --danger: #dc2626;
    --danger-light: #fee2e2;

    --warning: #d97706;
    --warning-light: #fef3c7;

    --text: #1e293b;
    --text-secondary: #64748b;

    --border: #e2e8f0;

    --background: #f8fafc;

    --white: #ffffff;

    --radius: 14px;

    --shadow:
        0 4px 12px rgba(15, 23, 42, 0.06);

    --shadow-hover:
        0 10px 25px rgba(15, 23, 42, 0.10);
}


/* =========================================================
   GENERAL
   ========================================================= */

html,
body {

    overflow-x: hidden;
}

body {

    background:
        var(--background);
}


.dashboard-container {

    width: 100%;

    max-width: 1500px;

    margin: 0 auto;

    padding: 24px;

    box-sizing: border-box;
}


/* =========================================================
   HEADER
   ========================================================= */

.dashboard-header {

    display: flex;

    align-items: center;

    justify-content: space-between;

    margin-bottom: 25px;
}


.dashboard-title {

    margin: 0;

    color: var(--text);

    font-size: 28px;

    font-weight: 700;

    letter-spacing: -0.5px;
}


.dashboard-subtitle {

    margin: 6px 0 0;

    color: var(--text-secondary);

    font-size: 14px;
}


/* =========================================================
   FILTROS
   ========================================================= */

.filters-card {

    background: var(--white);

    border: 1px solid var(--border);

    border-radius: var(--radius);

    padding: 20px;

    margin-bottom: 24px;

    box-shadow: var(--shadow);
}


.filters-header {

    display: flex;

    align-items: center;

    gap: 10px;

    margin-bottom: 16px;
}


.filters-header i {

    color: var(--primary);

    font-size: 17px;
}


.filters-title {

    color: var(--text);

    font-size: 15px;

    font-weight: 700;
}


.filters-grid {

    display: grid;

    grid-template-columns:
        repeat(4, minmax(150px, 1fr))
        minmax(200px, 1.5fr)
        auto
        auto;

    gap: 10px;

    align-items: center;
}


.filter-control {

    width: 100%;

    height: 42px;

    box-sizing: border-box;

    padding: 0 13px;

    border: 1px solid var(--border);

    border-radius: 9px;

    background: #fff;

    color: var(--text);

    font-family: inherit;

    font-size: 13px;

    outline: none;

    transition: all .2s;
}


.filter-control:hover {

    border-color: #cbd5e1;
}


.filter-control:focus {

    border-color: var(--primary);

    box-shadow:
        0 0 0 3px rgba(37, 99, 235, .10);
}


/* BUSCADOR */

.search-wrapper {

    position: relative;

    width: 100%;
}


.search-wrapper i {

    position: absolute;

    left: 13px;

    top: 50%;

    transform: translateY(-50%);

    color: #94a3b8;

    pointer-events: none;
}


.search-wrapper input {

    padding-left: 38px;
}


/* =========================================================
   BOTONES
   ========================================================= */

.btn {

    height: 42px;

    padding: 0 16px;

    border: none;

    border-radius: 9px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 8px;

    font-family: inherit;

    font-size: 13px;

    font-weight: 600;

    text-decoration: none;

    cursor: pointer;

    white-space: nowrap;

    transition: all .2s;
}


.btn-primary {

    background: var(--primary);

    color: #fff;
}


.btn-primary:hover {

    background: var(--primary-hover);

    transform: translateY(-1px);

    box-shadow:
        0 4px 10px rgba(37, 99, 235, .25);
}


.btn-secondary {

    background: #f1f5f9;

    color: #475569;

    border: 1px solid var(--border);
}


.btn-secondary:hover {

    background: #e2e8f0;
}


/* =========================================================
   KPI
   ========================================================= */

.kpi-grid {

    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 18px;

    margin-bottom: 24px;
}


.kpi-card {

    background: var(--white);

    border: 1px solid var(--border);

    border-radius: var(--radius);

    padding: 20px;

    box-shadow: var(--shadow);

    transition: all .25s;
}


.kpi-card:hover {

    transform: translateY(-3px);

    box-shadow: var(--shadow-hover);
}


.kpi-content {

    display: flex;

    align-items: center;

    justify-content: space-between;
}


.kpi-label {

    color: var(--text-secondary);

    font-size: 13px;

    margin-bottom: 8px;
}


.kpi-value {

    color: var(--text);

    font-size: 30px;

    line-height: 1;

    font-weight: 750;
}


.kpi-description {

    margin-top: 8px;

    color: var(--text-secondary);

    font-size: 12px;
}


.kpi-icon {

    width: 52px;

    height: 52px;

    border-radius: 13px;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 21px;
}


.kpi-total .kpi-icon {

    color: var(--primary);

    background: #dbeafe;
}


.kpi-active .kpi-icon {

    color: var(--success);

    background: var(--success-light);
}


.kpi-inactive .kpi-icon {

    color: var(--danger);

    background: var(--danger-light);
}


/* =========================================================
   GRÁFICAS
   ========================================================= */

.charts-grid {

    display: grid;

    grid-template-columns:
        1fr 1fr;

    gap: 18px;

    margin-bottom: 18px;
}


.chart-card {

    min-width: 0;

    background: var(--white);

    border: 1px solid var(--border);

    border-radius: var(--radius);

    padding: 20px;

    box-shadow: var(--shadow);
}


.chart-card-full {

    margin-bottom: 24px;
}


.chart-header {

    margin-bottom: 18px;
}


.chart-title {

    margin: 0;

    color: var(--text);

    font-size: 16px;

    font-weight: 700;
}

.chart-header-icon {
    font-size: 18px;
    color: var(--primary);
    margin-right: 8px;
    vertical-align: middle;
}


.chart-description {

    margin-top: 5px;

    color: var(--text-secondary);

    font-size: 12px;
}


.chart-wrapper {

    position: relative;

    height: 280px;
}


/* =========================================================
   TABLA
   ========================================================= */

.inventory-section {

    background: var(--white);

    border: 1px solid var(--border);

    border-radius: var(--radius);

    overflow: hidden;

    box-shadow: var(--shadow);
}


.inventory-header {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;

    padding: 20px;

    border-bottom: 1px solid var(--border);
}


.inventory-title {

    margin: 0;

    color: var(--text);

    font-size: 17px;

    font-weight: 700;
}


.inventory-count {

    margin-top: 5px;

    color: var(--text-secondary);

    font-size: 12px;
}


.table-wrapper {

    width: 100%;

    overflow-x: auto;
}


#invTable {

    width: 100%;

    min-width: 1100px;

    border-collapse: collapse;

    background: #fff;
}


#invTable thead {

    background: #f8fafc;
}


#invTable th {

    padding: 13px 15px;

    color: #64748b;

    font-size: 11px;

    font-weight: 700;

    text-align: left;

    text-transform: uppercase;

    letter-spacing: .04em;

    white-space: nowrap;

    border-bottom: 1px solid var(--border);
}


#invTable td {

    padding: 14px 15px;

    color: #334155;

    font-size: 13px;

    white-space: nowrap;

    border-bottom: 1px solid #f1f5f9;
}


#invTable tbody tr {

    transition: background .15s;
}


#invTable tbody tr:hover {

    background: #f8fafc;
}


#invTable tbody tr:last-child td {

    border-bottom: none;
}


#invTable td:first-child {

    color: var(--primary);

    font-weight: 700;
}


/* =========================================================
   ESTATUS
   ========================================================= */

.status-badge {

    display: inline-flex;

    align-items: center;

    gap: 6px;

    padding: 5px 10px;

    border-radius: 999px;

    font-size: 11px;

    font-weight: 700;
}


.status-badge::before {

    content: "";

    width: 6px;

    height: 6px;

    border-radius: 50%;
}


.status-active {

    color: #15803d;

    background: var(--success-light);
}


.status-active::before {

    background: #22c55e;
}


.status-inactive {

    color: #64748b;

    background: #f1f5f9;
}


.status-inactive::before {

    background: #94a3b8;
}


/* =========================================================
   PAGINACIÓN
   ========================================================= */

.pagination {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;

    padding: 15px 20px;

    background: #fcfcfd;

    border-top: 1px solid var(--border);
}


.pagination-info {

    color: var(--text-secondary);

    font-size: 12px;
}


.pagination-buttons {

    display: flex;

    gap: 7px;
}


.pagination button {

    height: 34px;

    padding: 0 12px;

    border: 1px solid var(--border);

    border-radius: 8px;

    background: #fff;

    color: #475569;

    font-family: inherit;

    font-size: 12px;

    font-weight: 600;

    cursor: pointer;

    transition: all .2s;
}


.pagination button:hover:not(:disabled) {

    color: var(--primary);

    border-color: var(--primary);

    background: #eff6ff;
}


.pagination button:disabled {

    opacity: .45;

    cursor: not-allowed;
}


/* =========================================================
   RESPONSIVE
   ========================================================= */

@media (max-width: 1200px) {

    .filters-grid {

        grid-template-columns:
            repeat(2, 1fr);
    }
}


@media (max-width: 850px) {

    .dashboard-container {

        padding: 15px;
    }


    .dashboard-header {

        align-items: flex-start;

        flex-direction: column;
    }


    .dashboard-title {

        font-size: 24px;
    }


    .kpi-grid {

        grid-template-columns:
            1fr;
    }


    .charts-grid {

        grid-template-columns:
            1fr;
    }
}


@media (max-width: 600px) {

    .dashboard-container {

        padding: 10px;
    }


    .filters-card {

        padding: 14px;
    }


    .filters-grid {

        grid-template-columns:
            1fr;
    }


    .inventory-header {

        align-items: flex-start;

        flex-direction: column;
    }


    .inventory-header .btn {

        width: 100%;
    }


    .pagination {

        align-items: stretch;

        flex-direction: column;
    }


    .pagination-buttons {

        justify-content: flex-end;
    }


    .chart-wrapper {

        height: 240px;
    }
}

</style>


<!-- =========================================================
     CONTENEDOR PRINCIPAL
========================================================= -->

<div class="dashboard-container">


    <!-- =====================================================
         ENCABEZADO
    ====================================================== -->

    <div class="dashboard-header">

        <div>

            <h1 class="dashboard-title">

                Dashboard de Inventario

            </h1>

            <p class="dashboard-subtitle">

                Consulta y monitorea el estado de los equipos registrados.

            </p>

        </div>

    </div>


    <!-- =====================================================
         FILTROS
    ====================================================== -->

    <div class="filters-card">

        <div class="filters-header">

            <i class="fas fa-sliders-h"></i>

            <span class="filters-title">

                Filtros de búsqueda

            </span>

        </div>


        <!--

            IMPORTANTE:

            NO usamos <form> aquí.

            El botón Filtrar utiliza JavaScript
            para construir la URL.

            Esto evita problemas si header.php
            contiene otro formulario.

        -->

        <div class="filters-grid">


            <!-- USUARIO -->

            <select
                id="filterUsuario"
                class="filter-control"
            >

                <option value="">

                    Todos los usuarios

                </option>


                <?php

                if ($usersOpt) {

                    while (
                        $u = mysqli_fetch_assoc(
                            $usersOpt
                        )
                    ) {

                        $value =
                            $u['usuario_asignado'];

                        $selected =
                            ($currentUsuario === $value)
                            ? 'selected'
                            : '';

                        echo '
                            <option
                                value="' .
                                htmlspecialchars($value) .
                                '"
                                ' . $selected . '
                            >
                                ' .
                                htmlspecialchars($value) .
                            '
                            </option>
                        ';
                    }
                }

                ?>

            </select>


            <!-- TIPO -->

            <select
                id="filterTipo"
                class="filter-control"
            >

                <option value="">

                    Todos los equipos

                </option>


                <?php

                if ($tipoOpt) {

                    while (
                        $t = mysqli_fetch_assoc(
                            $tipoOpt
                        )
                    ) {

                        $value =
                            $t['tipo_equipo'];

                        $selected =
                            ($currentTipo === $value)
                            ? 'selected'
                            : '';

                        echo '
                            <option
                                value="' .
                                htmlspecialchars($value) .
                                '"
                                ' . $selected . '
                            >
                                ' .
                                htmlspecialchars($value) .
                            '
                            </option>
                        ';
                    }
                }

                ?>

            </select>


            <!-- DEPARTAMENTO -->

            <select
                id="filterDepartamento"
                class="filter-control"
            >

                <option value="">

                    Todos los departamentos

                </option>


                <?php

                if ($deptOpt) {

                    while (
                        $d = mysqli_fetch_assoc(
                            $deptOpt
                        )
                    ) {

                        $value =
                            $d['departamento'];

                        $selected =
                            ($currentDepartamento === $value)
                            ? 'selected'
                            : '';

                        echo '
                            <option
                                value="' .
                                htmlspecialchars($value) .
                                '"
                                ' . $selected . '
                            >
                                ' .
                                htmlspecialchars($value) .
                            '
                            </option>
                        ';
                    }
                }

                ?>

            </select>


            <!-- ESTATUS -->

            <select
                id="filterEstatus"
                class="filter-control"
            >

                <option value="">

                    Todos los estatus

                </option>


                <option
                    value="1"
                    <?= $currentEstatus === '1'
                        ? 'selected'
                        : '' ?>
                >

                    Activo

                </option>


                <option
                    value="0"
                    <?= $currentEstatus === '0'
                        ? 'selected'
                        : '' ?>
                >

                    Inactivo

                </option>

            </select>


            <!-- BUSCADOR -->

            <div class="search-wrapper">

                <i class="fas fa-search"></i>

                <input
                    id="filterSearch"
                    type="text"
                    class="filter-control"
                    placeholder="Buscar usuario, modelo, serie..."
                    value="<?= htmlspecialchars($currentSearch) ?>"
                >

            </div>


            <!-- FILTRAR -->

            <button
                type="button"
                id="btnFiltrar"
                class="btn btn-primary"
            >

                <i class="fas fa-filter"></i>

                Filtrar

            </button>


            <!-- LIMPIAR -->

            <button
                type="button"
                id="btnLimpiar"
                class="btn btn-secondary"
            >

                <i class="fas fa-undo"></i>

                Limpiar

            </button>


        </div>

    </div>


    <!-- =====================================================
         KPI
    ====================================================== -->

    <div class="kpi-grid">


        <!-- TOTAL -->

        <div class="kpi-card kpi-total">

            <div class="kpi-content">

                <div>

                    <div class="kpi-label">

                        Total de equipos

                    </div>

                    <div class="kpi-value">

                        <?= number_format($total) ?>

                    </div>

                    <div class="kpi-description">

                        Equipos registrados

                    </div>

                </div>


                <div class="kpi-icon">

                    <i class="fas fa-box-open"></i>

                </div>

            </div>

        </div>


        <!-- ACTIVOS -->

        <div class="kpi-card kpi-active">

            <div class="kpi-content">

                <div>

                    <div class="kpi-label">

                        Equipos activos

                    </div>

                    <div class="kpi-value">

                        <?= number_format($active) ?>

                    </div>

                    <div class="kpi-description">

                        <?= $activePercent ?>%
                        del inventario

                    </div>

                </div>


                <div class="kpi-icon">

                    <i class="fas fa-check-circle"></i>

                </div>

            </div>

        </div>


        <!-- INACTIVOS -->

        <div class="kpi-card kpi-inactive">

            <div class="kpi-content">

                <div>

                    <div class="kpi-label">

                        Equipos inactivos

                    </div>

                    <div class="kpi-value">

                        <?= number_format($inactive) ?>

                    </div>

                    <div class="kpi-description">

                        <?= $inactivePercent ?>%
                        del inventario

                    </div>

                </div>


                <div class="kpi-icon">

                    <i class="fas fa-times-circle"></i>

                </div>

            </div>

        </div>


    </div>


    <!-- =====================================================
         GRÁFICAS
    ====================================================== -->

    <div class="charts-grid">


        <!-- ESTATUS -->

        <div class="chart-card">

            <div class="chart-header">

                <i class="chart-header-icon fas fa-chart-pie" aria-hidden="true"></i>

                <h3 class="chart-title">

                    Estado del inventario

                </h3>

                <div class="chart-description">

                    Equipos activos e inactivos

                </div>

            </div>


            <div class="chart-wrapper">

                <canvas
                    id="invStatusDonut"
                ></canvas>

            </div>

        </div>


        <!-- TIPOS -->

        <div class="chart-card">

            <div class="chart-header">

                <i class="chart-header-icon fas fa-th-list" aria-hidden="true"></i>

                <h3 class="chart-title">

                    Tipos de equipo

                </h3>

                <div class="chart-description">

                    Equipos con mayor presencia

                </div>

            </div>


            <div class="chart-wrapper">

                <canvas
                    id="invTypeBar"
                ></canvas>

            </div>

        </div>


    </div>


    <!-- =====================================================
         DEPARTAMENTOS
    ====================================================== -->

    <div class="chart-card chart-card-full">

        <div class="chart-header">

            <i class="chart-header-icon fas fa-building" aria-hidden="true"></i>

            <h3 class="chart-title">

                Distribución por departamento

            </h3>

            <div class="chart-description">

                Cantidad de equipos por departamento

            </div>

        </div>


        <div class="chart-wrapper">

            <canvas
                id="invDeptPie"
            ></canvas>

        </div>

    </div>


    <!-- =====================================================
         TABLA
    ====================================================== -->

    <div class="inventory-section">


        <!-- CABECERA -->

        <div class="inventory-header">

            <div>

                <h2 class="inventory-title">

                    Detalle de inventario

                </h2>

                <div class="inventory-count">

                    <?= number_format($total) ?>
                    equipos encontrados

                </div>

            </div>


            <button
                type="button"
                id="exportInv"
                class="btn btn-secondary"
            >

                <i class="fas fa-file-csv"></i>

                Exportar CSV

            </button>

        </div>


        <!-- TABLA -->

        <div class="table-wrapper">

            <table id="invTable">

                <thead>

                    <tr>

                        <th>ID</th>

                        <th>Usuario</th>

                        <th>Tipo</th>

                        <th>Modelo</th>

                        <th>Marca</th>

                        <th>No. Serie</th>

                        <th>Host</th>

                        <th>Departamento</th>

                        <th>Ubicación</th>

                        <th>Estatus</th>

                        <th>Editar</th>
                    </tr>

                </thead>


                <tbody>

                    <?php

                    if (
                        $res &&
                        mysqli_num_rows($res) > 0
                    ) {

                        while (
                            $r = mysqli_fetch_assoc($res)
                        ) {


                            $statusClass =
                                ((int)$r['estatus'] === 1)
                                ? 'status-active'
                                : 'status-inactive';


                            $statusText =
                                ((int)$r['estatus'] === 1)
                                ? 'Activo'
                                : 'Inactivo';


                            echo '<tr>';


                            echo '<td>';

                            echo (int)
                                $r['id_inventario'];

                            echo '</td>';


                            echo '<td>';

                            echo htmlspecialchars(
                                $r['usuario_asignado'] ?? ''
                            );

                            echo '</td>';


                            echo '<td>';

                            echo htmlspecialchars(
                                $r['tipo_equipo'] ?? ''
                            );

                            echo '</td>';


                            echo '<td>';

                            echo htmlspecialchars(
                                $r['modelo'] ?? ''
                            );

                            echo '</td>';


                            echo '<td>';

                            echo htmlspecialchars(
                                $r['marca'] ?? ''
                            );

                            echo '</td>';


                            echo '<td>';

                            echo htmlspecialchars(
                                $r['no_serie'] ?? ''
                            );

                            echo '</td>';


                            echo '<td>';

                            echo htmlspecialchars(
                                $r['nom_host'] ?? ''
                            );

                            echo '</td>';


                            echo '<td>';

                            echo htmlspecialchars(
                                $r['departamento'] ?? ''
                            );

                            echo '</td>';


                            echo '<td>';

                            echo htmlspecialchars(
                                $r['Ubicacion'] ?? ''
                            );

                            echo '</td>';



                            echo '<td>';

                            echo '
                                <span
                                    class="status-badge ' .
                                    $statusClass .
                                '"
                                >
                                    ' .
                                    $statusText .
                                '
                                </span>
                            ';

                            echo '</td>';

                            // EDITAR (solo para rol 1)
                            echo '<td>';
                            if (isset($_SESSION['rol']) && $_SESSION['rol'] == 1) {
                                echo '<a href="#" style="pointer-events:auto" rel="noopener noreferrer">'
                                    . '<img value="' . (int)$r['id_inventario'] . '" class="btnPopUpInventario" src="imagenes/edit.png" alt="Editar" style="width: 28px;">'
                                    . '</a>';
                            } else {
                                echo '-';
                            }
                            echo '</td>';

                            echo '</tr>';
                        }

                    } else {

                        echo '
                            <tr>

                                <td
                                    colspan="10"
                                    style="
                                        text-align:center;
                                        padding:45px;
                                        color:#94a3b8;
                                    "
                                >

                                    <i
                                        class="fas fa-box-open"
                                        style="
                                            font-size:32px;
                                            display:block;
                                            margin-bottom:12px;
                                        "
                                    ></i>

                                    No se encontraron
                                    registros.

                                </td>

                            </tr>
                        ';
                    }

                    ?>

                </tbody>

            </table>

        </div>


        <!-- PAGINACIÓN -->

        <div class="pagination">

            <span
                id="invPageInfo"
                class="pagination-info"
            ></span>


            <div class="pagination-buttons">

                <button
                    type="button"
                    id="prevInv"
                >

                    <i class="fas fa-chevron-left"></i>

                    Anterior

                </button>


                <button
                    type="button"
                    id="nextInv"
                >

                    Siguiente

                    <i class="fas fa-chevron-right"></i>

                </button>

            </div>

        </div>


    </div>


</div>


<script>

/* =========================================================
   1. DATOS PHP
   ========================================================= */

const statusData = [

    <?= (int)$active ?>,

    <?= (int)$inactive ?>

];


const typeLabels =

    <?= json_encode(
        $typeLabels,
        JSON_UNESCAPED_UNICODE
    ) ?>;


const typeData =

    <?= json_encode(
        $typeData
    ) ?>;


const deptLabels =

    <?= json_encode(
        $deptLabels,
        JSON_UNESCAPED_UNICODE
    ) ?>;


const deptData =

    <?= json_encode(
        $deptData
    ) ?>;


/* =========================================================
   2. FILTRAR
   ========================================================= */

const btnFiltrar = document.getElementById('btnFiltrar');
if (btnFiltrar) {
    btnFiltrar.addEventListener('click', function () {


            const usuario =
                document
                    .getElementById(
                        'filterUsuario'
                    )
                    .value;


            const tipo =
                document
                    .getElementById(
                        'filterTipo'
                    )
                    .value;


            const departamento =
                document
                    .getElementById(
                        'filterDepartamento'
                    )
                    .value;


            const estatus =
                document
                    .getElementById(
                        'filterEstatus'
                    )
                    .value;


            const search =
                document
                    .getElementById(
                        'filterSearch'
                    )
                    .value
                    .trim();


            /*
             * Construimos la URL.
             */

            const params =
                new URLSearchParams();


            if (usuario !== '') {

                params.set(
                    'usuario',
                    usuario
                );
            }


            if (tipo !== '') {

                params.set(
                    'tipo',
                    tipo
                );
            }


            if (departamento !== '') {

                params.set(
                    'departamento',
                    departamento
                );
            }


            if (estatus !== '') {

                params.set(
                    'estatus',
                    estatus
                );
            }


            if (search !== '') {

                params.set(
                    'q',
                    search
                );
            }


            /*
             * Obtener la página actual.
             */

            const currentPage =
                window.location.pathname;


            /*
             * Recargar con filtros.
             */

            if (params.toString() !== '') {

                window.location.href =
                    currentPage +
                    '?' +
                    params.toString();

            } else {

                window.location.href =
                    currentPage;
            }

        });
    }


/* =========================================================
   3. ENTER EN EL BUSCADOR
   ========================================================= */

const filterSearch = document.getElementById('filterSearch');
if (filterSearch) {
    filterSearch.addEventListener('keydown', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            if (btnFiltrar) btnFiltrar.click();
        }
    });
}


/* =========================================================
   4. LIMPIAR FILTROS
   ========================================================= */

const btnLimpiar = document.getElementById('btnLimpiar');
if (btnLimpiar) {
    btnLimpiar.addEventListener('click', function () {
        window.location.href = window.location.pathname;
    });
}


/* =========================================================
   5. GRÁFICA DE ESTATUS
   ========================================================= */

new Chart(

    document.getElementById(
        'invStatusDonut'
    ),

    {

        type: 'doughnut',

        data: {

            labels: [

                'Activos',

                'Inactivos'

            ],

            datasets: [

                {

                    data:
                        statusData,

                    backgroundColor: [

                        '#16a34a',

                        '#cbd5e1'

                    ],

                    borderWidth: 0,

                    hoverOffset: 7

                }

            ]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            cutout: '70%',

            plugins: {

                legend: {

                    position: 'bottom',

                    labels: {

                        usePointStyle: true,

                        padding: 18

                    }

                }

            }

        }

    }

);


/* =========================================================
   6. GRÁFICA DE TIPOS
   ========================================================= */

new Chart(

    document.getElementById(
        'invTypeBar'
    ),

    {

        type: 'bar',

        data: {

            labels:
                typeLabels,

            datasets: [

                {

                    label:
                        'Cantidad',

                    data:
                        typeData,

                    backgroundColor:
                        'rgba(37, 99, 235, .75)',

                    borderRadius: 6,

                    borderSkipped: false

                }

            ]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {

                    display: false

                }

            },

            scales: {

                y: {

                    beginAtZero: true,

                    ticks: {

                        precision: 0

                    },

                    grid: {

                        color:
                            '#f1f5f9'

                    }

                },

                x: {

                    grid: {

                        display: false

                    }

                }

            }

        }

    }

);


/* =========================================================
   7. GRÁFICA DE DEPARTAMENTOS
   ========================================================= */

new Chart(

    document.getElementById(
        'invDeptPie'
    ),

    {

        type: 'pie',

        data: {

            labels:
                deptLabels,

            datasets: [

                {

                    data:
                        deptData,

                    backgroundColor: [

                        '#2563eb',

                        '#7c3aed',

                        '#d97706',

                        '#dc2626',

                        '#16a34a',

                        '#0891b2',

                        '#db2777',

                        '#4f46e5'

                    ],

                    borderWidth: 2,

                    borderColor:
                        '#ffffff'

                }

            ]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {

                    position: 'right',

                    labels: {

                        usePointStyle: true,

                        padding: 15

                    }

                }

            }

        }

    }

);


/* =========================================================
   8. PAGINACIÓN
   ========================================================= */

(function () {


    const rows = Array.from(

        document.querySelectorAll(
            '#invTable tbody tr'
        )

    );


    const perPage = 10;


    let page = 1;


    const totalPages = Math.max(

        1,

        Math.ceil(
            rows.length / perPage
        )

    );


    const info =

        document.getElementById(
            'invPageInfo'
        );


    const prev =

        document.getElementById(
            'prevInv'
        );


    const next =

        document.getElementById(
            'nextInv'
        );


    function render() {


        const start =
            (page - 1) *
            perPage;


        const end =
            page *
            perPage;


        rows.forEach(

            function (
                row,
                index
            ) {

                row.style.display =

                    index >= start &&
                    index < end

                        ? ''

                        : 'none';

            }

        );


        if (rows.length === 0) {

            info.textContent =
                'Sin registros';

        } else {

            info.textContent =

                `Mostrando ${
                    start + 1
                } a ${
                    Math.min(
                        end,
                        rows.length
                    )
                } de ${
                    rows.length
                } (Página ${
                    page
                }/${
                    totalPages
                })`;

        }


        prev.disabled =
            page === 1;


        next.disabled =
            page === totalPages;

    }


    prev.addEventListener(

        'click',

        function () {

            if (page > 1) {

                page--;

                render();

            }

        }

    );


    next.addEventListener(

        'click',

        function () {

            if (
                page <
                totalPages
            ) {

                page++;

                render();

            }

        }

    );


    render();


})();


/* =========================================================
   9. EXPORTAR CSV
   ========================================================= */

document
    .getElementById('exportInv')
    .addEventListener(
        'click',
        function () {


            const table =
                document.getElementById(
                    'invTable'
                );


            const rows =
                Array.from(
                    table.querySelectorAll(
                        'tr'
                    )
                );


            const csv = [];


            rows.forEach(
                function (row) {


                    const columns =
                        Array.from(
                            row.querySelectorAll(
                                'th, td'
                            )
                        );


                    const values =
                        columns.map(
                            function (
                                column
                            ) {


                                const value =
                                    column
                                        .textContent
                                        .trim()
                                        .replace(
                                            /"/g,
                                            '""'
                                        );


                                return `"${value}"`;

                            }
                        );


                    csv.push(
                        values.join(',')
                    );

                }
            );


            const blob =

                new Blob(

                    [

                        '\uFEFF' +
                        csv.join('\n')

                    ],

                    {

                        type:
                            'text/csv;charset=utf-8;'

                    }

                );


            const url =

                URL.createObjectURL(
                    blob
                );


            const link =

                document.createElement(
                    'a'
                );


            link.href =
                url;


            link.download =
                'inventario.csv';


            document.body.appendChild(
                link
            );


            link.click();


            document.body.removeChild(
                link
            );


            URL.revokeObjectURL(
                url
            );

        }
    );

</script>

<script src="js/scriptPopUp.js"></script>

<?php
include "footer.php";
?>