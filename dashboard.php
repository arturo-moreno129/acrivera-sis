<?php
include "header.php";

/*
|--------------------------------------------------------------------------
| DASHBOARD DE EVIDENCIAS Y RESGUARDOS
|--------------------------------------------------------------------------
| Requiere:
| - $con : conexión mysqli definida en header.php
| - Chart.js disponible por CDN (se carga al final)
|--------------------------------------------------------------------------
*/

/* =========================
   1. FILTROS
========================= */
$usuario    = trim($_GET['usuario'] ?? '');
$dispositivo = trim($_GET['dispositivo'] ?? '');
$estatus    = $_GET['estatus'] ?? '';
$mant       = $_GET['mant'] ?? '';
$start      = $_GET['start'] ?? '';
$end        = $_GET['end'] ?? '';
$q          = trim($_GET['q'] ?? '');

$where = [];
$params = [];
$types = '';

if ($usuario !== '') {
    $where[] = "nombre = ?";
    $params[] = $usuario;
    $types .= 's';
}

if ($dispositivo !== '') {
    $where[] = "dispositivo = ?";
    $params[] = $dispositivo;
    $types .= 's';
}

if ($estatus === '1' || $estatus === '0') {
    $where[] = "estatus = ?";
    $params[] = (int)$estatus;
    $types .= 'i';
}

if ($mant === 'with') {
    $where[] = "url_mantenimiento IS NOT NULL AND url_mantenimiento <> ''";
} elseif ($mant === 'without') {
    $where[] = "(url_mantenimiento IS NULL OR url_mantenimiento = '')";
}

if ($start !== '') {
    $where[] = "STR_TO_DATE(fecha, '%d/%m/%Y') >= STR_TO_DATE(?, '%Y-%m-%d')";
    $params[] = $start;
    $types .= 's';
}

if ($end !== '') {
    $where[] = "STR_TO_DATE(fecha, '%d/%m/%Y') <= STR_TO_DATE(?, '%Y-%m-%d')";
    $params[] = $end;
    $types .= 's';
}

if ($q !== '') {
    $where[] = "(nombre LIKE ? OR dispositivo LIKE ?)";
    $search = '%' . $q . '%';
    $params[] = $search;
    $params[] = $search;
    $types .= 'ss';
}

$whereSQL = $where ? 'WHERE ' . implode(' AND ', $where) : '';

/* =========================
   2. FUNCIONES
========================= */
function fetchCount($con, $sql, $types = '', $params = []) {
    $stmt = mysqli_prepare($con, $sql);

    if (!$stmt) {
        return 0;
    }

    if ($types !== '') {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    return (int)($row['total'] ?? 0);
}

function fetchRows($con, $sql, $types = '', $params = []) {
    $stmt = mysqli_prepare($con, $sql);

    if (!$stmt) {
        return [];
    }

    if ($types !== '') {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    mysqli_stmt_close($stmt);

    return $rows;
}

/* =========================
   3. MÉTRICAS
   Ahora respetan los filtros
========================= */
$totUsers = fetchCount(
    $con,
    "SELECT COUNT(DISTINCT nombre) AS total FROM evidencia $whereSQL",
    $types,
    $params
);

$totEquip = fetchCount(
    $con,
    "SELECT COUNT(DISTINCT dispositivo) AS total FROM evidencia $whereSQL",
    $types,
    $params
);

$resguardos = fetchCount(
    $con,
    "SELECT COUNT(*) AS total FROM evidencia $whereSQL AND url_resguardo IS NOT NULL AND url_resguardo <> ''",
    $types,
    $params
);

$withMant = fetchCount(
    $con,
    "SELECT COUNT(*) AS total FROM evidencia $whereSQL AND url_mantenimiento IS NOT NULL AND url_mantenimiento <> ''",
    $types,
    $params
);

$withoutMant = fetchCount(
    $con,
    "SELECT COUNT(*) AS total FROM evidencia $whereSQL AND (url_mantenimiento IS NULL OR url_mantenimiento = '')",
    $types,
    $params
);

$active = fetchCount(
    $con,
    "SELECT COUNT(*) AS total FROM evidencia $whereSQL AND estatus = 1",
    $types,
    $params
);

$totalRecords = fetchCount(
    $con,
    "SELECT COUNT(*) AS total FROM evidencia $whereSQL",
    $types,
    $params
);

/* Activos / inactivos */
$inactive = max(0, $totalRecords - $active);

/* Porcentajes */
$activePercent = $totalRecords > 0 ? round(($active / $totalRecords) * 100) : 0;
$mantPercent = $totalRecords > 0 ? round(($withMant / $totalRecords) * 100) : 0;

/* =========================
   4. GRÁFICA POR MES
========================= */
$lineQuery = "
    SELECT
        DATE_FORMAT(STR_TO_DATE(fecha, '%d/%m/%Y'), '%Y-%m') AS ym,
        COUNT(*) AS total
    FROM evidencia
    $whereSQL
    GROUP BY ym
    ORDER BY ym
";

$lineRows = fetchRows($con, $lineQuery, $types, $params);

$lineLabels = [];
$lineData = [];

foreach ($lineRows as $row) {
    $date = DateTime::createFromFormat('!Y-m', $row['ym']);

    if ($date) {
        $lineLabels[] = $date->format('M Y');
    } else {
        $lineLabels[] = $row['ym'];
    }

    $lineData[] = (int)$row['total'];
}

/* =========================
   5. EQUIPOS POR TIPO
========================= */
$deviceQuery = "
    SELECT dispositivo, COUNT(*) AS total
    FROM evidencia
    $whereSQL
    GROUP BY dispositivo
    ORDER BY total DESC
    LIMIT 10
";

$deviceRows = fetchRows($con, $deviceQuery, $types, $params);

$deviceLabels = [];
$deviceData = [];

foreach ($deviceRows as $row) {
    $deviceLabels[] = $row['dispositivo'];
    $deviceData[] = (int)$row['total'];
}

/* =========================
   6. TABLA
========================= */
$listQuery = "
    SELECT
        id_evidencia,
        nombre,
        fecha,
        dispositivo,
        url_resguardo,
        url_mantenimiento,
        estatus,
        estatus_mant
    FROM evidencia
    $whereSQL
    ORDER BY STR_TO_DATE(fecha, '%d/%m/%Y') DESC
";

$rows = fetchRows($con, $listQuery, $types, $params);

/* =========================
   7. OPCIONES DE FILTROS
========================= */
$usersOpt = mysqli_query(
    $con,
    "SELECT DISTINCT nombre FROM evidencia WHERE nombre IS NOT NULL AND nombre <> '' ORDER BY nombre"
);

$dispoOpt = mysqli_query(
    $con,
    "SELECT DISTINCT dispositivo FROM evidencia WHERE dispositivo IS NOT NULL AND dispositivo <> '' ORDER BY dispositivo"
);
?>

<style>
/* =========================================================
   DASHBOARD - ESTILO MODERNO
========================================================= */


html, body {
    margin: 0;
    padding: 0;
}

.dashboard-main {
    margin-left: 0 !important;
}

:root {
    --dash-primary: #2563eb;
    --dash-primary-dark: #0f172a;
    --dash-bg: #f6f8fc;
    --dash-card: #ffffff;
    --dash-text: #0f172a;
    --dash-muted: #64748b;
    --dash-border: #e5e7eb;
    --dash-success: #16a34a;
    --dash-success-bg: #dcfce7;
    --dash-danger: #dc2626;
    --dash-danger-bg: #fee2e2;
    --dash-warning: #d97706;
    --dash-warning-bg: #fef3c7;
}

* {
    box-sizing: border-box;
}

.dashboard-app {
    display: flex;
    min-height: calc(100vh - 60px);
    background: var(--dash-bg);
    color: var(--dash-text);
    font-family: Inter, "Segoe UI", Arial, sans-serif;
}











.side-menu a:hover,
.side-menu a.active {
    background: #2563eb;
    color: #fff;
}



.dashboard-main {
    width: 100%;
    min-width: 0;
    padding: 28px 0;
}

.dashboard-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 22px;
}

.dashboard-title h1 {
    margin: 0;
    font-size: 27px;
    font-weight: 700;
    letter-spacing: -.5px;
}

.dashboard-title p {
    margin: 6px 0 0;
    color: var(--dash-muted);
    font-size: 14px;
}

.header-actions {
    display: flex;
    gap: 10px;
    align-items: center;
}

.date-box,
.export-btn {
    height: 42px;
    background: #fff;
    border: 1px solid var(--dash-border);
    border-radius: 8px;
    padding: 0 13px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.export-btn {
    color: var(--dash-primary);
    border-color: var(--dash-primary);
    cursor: pointer;
    font-weight: 600;
}

/* FILTROS */
.filter-card {
    background: #fff;
    border: 1px solid var(--dash-border);
    border-radius: 10px;
    padding: 13px;
    margin-bottom: 18px;
}

.filters {
    display: grid;
    grid-template-columns: repeat(4, minmax(150px, 1fr)) minmax(200px, 1.2fr) auto;
    gap: 10px;
}

.filter-control {
    width: 100%;
    height: 42px;
    border: 1px solid #dbe1ea;
    border-radius: 8px;
    background: #fff;
    color: #334155;
    padding: 0 12px;
    outline: none;
}

.filter-control:focus {
    border-color: var(--dash-primary);
    box-shadow: 0 0 0 3px rgba(37,99,235,.08);
}

.filter-date {
    display: flex;
    align-items: center;
    gap: 6px;
}

.filter-date input {
    flex: 1;
}

.filter-actions {
    display: flex;
    gap: 8px;
}

.btn-primary,
.btn-secondary {
    border: 0;
    height: 42px;
    border-radius: 8px;
    padding: 0 15px;
    cursor: pointer;
    font-weight: 600;
}

.btn-primary {
    background: var(--dash-primary);
    color: #fff;
}

.btn-secondary {
    background: #eef2f7;
    color: #334155;
    text-decoration: none;
    display: flex;
    align-items: center;
}

/* KPI */
.kpi-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 12px;
    margin-bottom: 18px;
}

.kpi-card {
    background: var(--dash-card);
    border: 1px solid var(--dash-border);
    border-radius: 10px;
    padding: 17px;
    min-height: 105px;
    display: flex;
    gap: 12px;
    align-items: center;
}

.kpi-icon {
    width: 45px;
    height: 45px;
    min-width: 45px;
    border-radius: 50%;
    display: grid;
    place-items: center;
    font-size: 19px;
}

.kpi-blue { background: #dbeafe; color: #2563eb; }
.kpi-green { background: var(--dash-success-bg); color: var(--dash-success); }
.kpi-purple { background: #f3e8ff; color: #9333ea; }
.kpi-orange { background: var(--dash-warning-bg); color: var(--dash-warning); }
.kpi-red { background: var(--dash-danger-bg); color: var(--dash-danger); }

.kpi-label {
    color: #475569;
    font-size: 12px;
    margin-bottom: 4px;
}

.kpi-value {
    font-size: 25px;
    font-weight: 700;
}

.kpi-help {
    color: var(--dash-muted);
    font-size: 11px;
    margin-top: 3px;
}

/* CHARTS */
.charts-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1.6fr;
    gap: 14px;
    margin-bottom: 18px;
}

.chart-card {
    background: #fff;
    border: 1px solid var(--dash-border);
    border-radius: 10px;
    padding: 18px;
    min-width: 0;
}

.chart-card h3 {
    font-size: 15px;
    margin: 0 0 15px;
}

.chart-wrapper {
    height: 230px;
    position: relative;
}

/* TABLA */
.table-card {
    background: #fff;
    border: 1px solid var(--dash-border);
    border-radius: 10px;
    overflow: hidden;
}

.table-header {
    padding: 18px 20px;
    border-bottom: 1px solid var(--dash-border);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.table-header h2 {
    font-size: 17px;
    margin: 0;
}

.table-wrapper {
    overflow-x: auto;
}

#resguardosTable {
    width: 100%;
    border-collapse: collapse;
    min-width: 1050px;
}

#resguardosTable th {
    background: #f8fafc;
    color: #334155;
    font-size: 12px;
    font-weight: 700;
    text-align: left;
    padding: 13px 12px;
    white-space: nowrap;
}

#resguardosTable td {
    padding: 13px 12px;
    border-top: 1px solid #eef2f7;
    color: #334155;
    font-size: 12px;
    white-space: nowrap;
}

#resguardosTable tbody tr:hover {
    background: #f8fbff;
}

.pdf-link {
    color: var(--dash-primary);
    text-decoration: none;
    font-weight: 600;
}

.status {
    display: inline-flex;
    align-items: center;
    padding: 5px 9px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 600;
}

.status-active,
.status-maint {
    background: var(--dash-success-bg);
    color: #15803d;
}

.status-inactive {
    background: #f1f5f9;
    color: #64748b;
}

.status-no-maint {
    background: var(--dash-danger-bg);
    color: #b91c1c;
}

.action-btn {
    width: 32px;
    height: 32px;
    border: 0;
    border-radius: 7px;
    background: #eff6ff;
    color: var(--dash-primary);
    cursor: pointer;
}

.table-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 13px 18px;
    border-top: 1px solid var(--dash-border);
    color: var(--dash-muted);
    font-size: 12px;
}

.pagination {
    display: flex;
    gap: 6px;
}

.pagination button {
    width: 34px;
    height: 32px;
    border: 1px solid var(--dash-border);
    background: #fff;
    border-radius: 6px;
    cursor: pointer;
}

.pagination button.active {
    background: var(--dash-primary);
    color: #fff;
    border-color: var(--dash-primary);
}

/* RESPONSIVE */
@media (max-width: 1350px) {
    .kpi-grid {
        grid-template-columns: repeat(3, 1fr);
    }

    .charts-grid {
        grid-template-columns: 1fr 1fr;
    }

    .charts-grid .chart-card:last-child {
        grid-column: 1 / -1;
    }

    .filters {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 900px) {
    .dashboard-main {
        padding: 18px;
    }

    .dashboard-header {
        flex-direction: column;
    }

    .kpi-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .filters {
        grid-template-columns: 1fr 1fr;
    }
}

@media (max-width: 600px) {
    .dashboard-main {
        padding: 12px;
    }

    .kpi-grid,
    .charts-grid,
    .filters {
        grid-template-columns: 1fr;
    }

    .charts-grid .chart-card:last-child {
        grid-column: auto;
    }

    .header-actions {
        width: 100%;
    }

    .date-box,
    .export-btn {
        flex: 1;
    }
}
</style>

<main class="dashboard-main">


        <!-- HEADER -->
        <div class="dashboard-header">
            <div class="dashboard-title">
                <h1>Dashboard de Evidencias y Resguardos</h1>
                <p>Resumen general de resguardos, mantenimientos y evidencias de activos.</p>
            </div>

            <div class="header-actions">
                <div class="date-box">
                    <i class="fa-regular fa-calendar"></i>
                    <?php
                    if ($start || $end) {
                        echo htmlspecialchars(($start ?: 'Inicio') . ' - ' . ($end ?: 'Hoy'));
                    } else {
                        echo 'Todos los registros';
                    }
                    ?>
                </div>

                <button class="export-btn" type="button" id="exportBtn">
                    <i class="fa-solid fa-download"></i>
                    Exportar
                </button>
            </div>
        </div>

        <!-- FILTROS -->
        <div class="filter-card">
            <form id="filters" method="get" class="filters">

                <select name="usuario" class="filter-control">
                    <option value="">Todos los usuarios</option>
                    <?php if ($usersOpt): ?>
                        <?php while ($u = mysqli_fetch_assoc($usersOpt)): ?>
                            <option value="<?php echo htmlspecialchars($u['nombre']); ?>"
                                <?php echo $usuario === $u['nombre'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($u['nombre']); ?>
                            </option>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </select>

                <select name="dispositivo" class="filter-control">
                    <option value="">Todos los dispositivos</option>
                    <?php if ($dispoOpt): ?>
                        <?php while ($d = mysqli_fetch_assoc($dispoOpt)): ?>
                            <option value="<?php echo htmlspecialchars($d['dispositivo']); ?>"
                                <?php echo $dispositivo === $d['dispositivo'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($d['dispositivo']); ?>
                            </option>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </select>

                <select name="estatus" class="filter-control">
                    <option value="">Todos los estatus</option>
                    <option value="1" <?php echo $estatus === '1' ? 'selected' : ''; ?>>Activo</option>
                    <option value="0" <?php echo $estatus === '0' ? 'selected' : ''; ?>>Inactivo</option>
                </select>

                <select name="mant" class="filter-control">
                    <option value="">Todos los mantenimientos</option>
                    <option value="with" <?php echo $mant === 'with' ? 'selected' : ''; ?>>Con registro</option>
                    <option value="without" <?php echo $mant === 'without' ? 'selected' : ''; ?>>Sin registro</option>
                </select>

                <div class="filter-date">
                    <input class="filter-control" type="date" name="start"
                           value="<?php echo htmlspecialchars($start); ?>">
                    <input class="filter-control" type="date" name="end"
                           value="<?php echo htmlspecialchars($end); ?>">
                </div>

                <div class="filter-actions">
                    <input class="filter-control" type="text" name="q"
                           placeholder="Buscar usuario..."
                           value="<?php echo htmlspecialchars($q); ?>">

                    <button class="btn-primary" type="submit">
                        <i class="fa-solid fa-filter"></i>
                    </button>

                    <a class="btn-secondary" href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                </div>

            </form>
        </div>

        <!-- KPI -->
        <section class="kpi-grid">

            <div class="kpi-card">
                <div class="kpi-icon kpi-blue">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <div class="kpi-label">Total de usuarios</div>
                    <div class="kpi-value"><?php echo $totUsers; ?></div>
                    <div class="kpi-help">Usuarios registrados</div>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-icon kpi-green">
                    <i class="fa-solid fa-desktop"></i>
                </div>
                <div>
                    <div class="kpi-label">Total de equipos</div>
                    <div class="kpi-value"><?php echo $totEquip; ?></div>
                    <div class="kpi-help">Equipos registrados</div>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-icon kpi-purple">
                    <i class="fa-solid fa-file-lines"></i>
                </div>
                <div>
                    <div class="kpi-label">Resguardos registrados</div>
                    <div class="kpi-value"><?php echo $resguardos; ?></div>
                    <div class="kpi-help">Con evidencia</div>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-icon kpi-orange">
                    <i class="fa-solid fa-wrench"></i>
                </div>
                <div>
                    <div class="kpi-label">Con mantenimiento</div>
                    <div class="kpi-value"><?php echo $withMant; ?></div>
                    <div class="kpi-help"><?php echo $mantPercent; ?>% del total</div>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-icon kpi-red">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div>
                    <div class="kpi-label">Sin mantenimiento</div>
                    <div class="kpi-value"><?php echo $withoutMant; ?></div>
                    <div class="kpi-help">Requieren atención</div>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-icon kpi-green">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div>
                    <div class="kpi-label">Equipos activos</div>
                    <div class="kpi-value"><?php echo $active; ?></div>
                    <div class="kpi-help"><?php echo $activePercent; ?>% activos</div>
                </div>
            </div>

        </section>

        <!-- GRÁFICAS -->
        <section class="charts-grid">

            <div class="chart-card">
                <h3>Estatus de activos</h3>
                <div class="chart-wrapper">
                    <canvas id="statusDonut"></canvas>
                </div>
            </div>

            <div class="chart-card">
                <h3>Mantenimientos</h3>
                <div class="chart-wrapper">
                    <canvas id="mantDonut"></canvas>
                </div>
            </div>

            <div class="chart-card">
                <h3>Equipos por fecha de registro</h3>
                <div class="chart-wrapper">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>

        </section>

        <!-- TABLA -->
        <section class="table-card">

            <div class="table-header">
                <h2>Detalle de resguardos</h2>
                <span><?php echo $totalRecords; ?> registros</span>
            </div>

            <div class="table-wrapper">
                <table id="resguardosTable">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Fecha</th>
                            <th>Dispositivo</th>
                            <th>URL Resguardo</th>
                            <th>URL Mantenimiento</th>
                            <th>Estatus</th>
                            <th>Estatus Mant.</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php foreach ($rows as $row): ?>

                        <tr>

                            <td><?php echo (int)$row['id_evidencia']; ?></td>

                            <td>
                                <strong><?php echo htmlspecialchars($row['nombre']); ?></strong>
                            </td>

                            <td><?php echo htmlspecialchars($row['fecha']); ?></td>

                            <td><?php echo htmlspecialchars($row['dispositivo']); ?></td>

                            <td>
                                <?php if (!empty($row['url_resguardo'])): ?>
                                    <a class="pdf-link"
                                       target="_blank"
                                       href="view_pdf.php?file=<?php
                                       echo urlencode($row['nombre'] . '/' . $row['url_resguardo']);
                                       ?>">
                                        <i class="fa-solid fa-file-pdf"></i>
                                        RESGUARDO
                                    </a>
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if (!empty($row['url_mantenimiento'])): ?>
                                    <a class="pdf-link"
                                       target="_blank"
                                       href="view_pdf.php?file=<?php
                                       echo urlencode($row['nombre'] . '/' . $row['url_mantenimiento']);
                                       ?>">
                                        <i class="fa-solid fa-file-pdf"></i>
                                        MANTENIMIENTO
                                    </a>
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if ((int)$row['estatus'] === 1): ?>
                                    <span class="status status-active">Activo</span>
                                <?php else: ?>
                                    <span class="status status-inactive">Inactivo</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if ((int)$row['estatus_mant'] === 1): ?>
                                    <span class="status status-maint">Con mantenimiento</span>
                                <?php else: ?>
                                    <span class="status status-no-maint">Sin mantenimiento</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <button
                                    type="button"
                                    class="action-btn"
                                    title="Ver registro"
                                    onclick="verRegistro(<?php echo (int)$row['id_evidencia']; ?>)">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                    <?php if (!$rows): ?>
                        <tr>
                            <td colspan="9" style="text-align:center;padding:35px;">
                                No se encontraron registros.
                            </td>
                        </tr>
                    <?php endif; ?>

                    </tbody>
                </table>
            </div>

            <div class="table-footer">
                <span id="pageInfo"></span>

                <div class="pagination">
                    <button id="prevPage">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>

                    <button id="currentPage" class="active">1</button>

                    <button id="nextPage">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </div>
            </div>

        </section>

</main>

<!-- Font Awesome -->
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
/* =========================================================
   DATOS PHP -> JAVASCRIPT
========================================================= */

const statusData = [
    <?php echo (int)$active; ?>,
    <?php echo (int)$inactive; ?>
];

const mantData = [
    <?php echo (int)$withMant; ?>,
    <?php echo (int)$withoutMant; ?>
];

const lineLabels = <?php echo json_encode($lineLabels, JSON_UNESCAPED_UNICODE); ?>;
const lineData = <?php echo json_encode($lineData); ?>;

const deviceLabels = <?php echo json_encode($deviceLabels, JSON_UNESCAPED_UNICODE); ?>;
const deviceData = <?php echo json_encode($deviceData); ?>;


/* =========================================================
   CONFIGURACIÓN GENERAL CHART.JS
========================================================= */

Chart.defaults.font.family = '"Segoe UI", Arial, sans-serif';
Chart.defaults.color = '#64748b';


/* =========================================================
   DONUT - ESTATUS
========================================================= */

new Chart(document.getElementById('statusDonut'), {
    type: 'doughnut',

    data: {
        labels: ['Activos', 'Inactivos'],

        datasets: [{
            data: statusData,
            backgroundColor: ['#16a34a', '#e2e8f0'],
            borderWidth: 0,
            hoverOffset: 5
        }]
    },

    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '72%',

        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});


/* =========================================================
   DONUT - MANTENIMIENTO
========================================================= */

new Chart(document.getElementById('mantDonut'), {
    type: 'doughnut',

    data: {
        labels: ['Con registro', 'Sin registro'],

        datasets: [{
            data: mantData,
            backgroundColor: ['#f59e0b', '#ef4444'],
            borderWidth: 0,
            hoverOffset: 5
        }]
    },

    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '72%',

        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});


/* =========================================================
   LÍNEA - REGISTROS POR MES
========================================================= */

new Chart(document.getElementById('lineChart'), {
    type: 'line',

    data: {
        labels: lineLabels,

        datasets: [{
            label: 'Registros',
            data: lineData,

            borderColor: '#2563eb',
            backgroundColor: 'rgba(37, 99, 235, .10)',

            borderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6,

            fill: true,
            tension: .35
        }]
    },

    options: {
        responsive: true,
        maintainAspectRatio: false,

        interaction: {
            intersect: false,
            mode: 'index'
        },

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
                    color: '#edf1f5'
                }
            },

            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});


/* =========================================================
   PAGINACIÓN
========================================================= */

(function () {

    const rows = Array.from(
        document.querySelectorAll('#resguardosTable tbody tr')
    );

    const perPage = 6;
    let page = 1;

    const realRows = rows.filter(row =>
        row.children.length > 1
    );

    const totalPages = Math.max(
        1,
        Math.ceil(realRows.length / perPage)
    );

    const pageInfo = document.getElementById('pageInfo');
    const currentPage = document.getElementById('currentPage');

    function render() {

        realRows.forEach((row, index) => {

            const visible =
                index >= (page - 1) * perPage &&
                index < page * perPage;

            row.style.display = visible ? '' : 'none';
        });

        if (realRows.length === 0) {
            pageInfo.textContent = '0 registros';
        } else {
            const from = (page - 1) * perPage + 1;
            const to = Math.min(page * perPage, realRows.length);

            pageInfo.textContent =
                `Mostrando ${from} a ${to} de ${realRows.length} registros`;
        }

        currentPage.textContent = page;
    }

    document.getElementById('prevPage')
        .addEventListener('click', function () {

            if (page > 1) {
                page--;
                render();
            }

        });

    document.getElementById('nextPage')
        .addEventListener('click', function () {

            if (page < totalPages) {
                page++;
                render();
            }

        });

    render();

})();


/* =========================================================
   EXPORTAR CSV
========================================================= */

document.getElementById('exportBtn')
    .addEventListener('click', function () {

        const rows = Array.from(
            document.querySelectorAll('#resguardosTable tr')
        );

        const csv = rows.map(row => {

            const cols = Array.from(
                row.querySelectorAll('th, td')
            );

            return cols.map(col => {

                return '"' +
                    col.innerText
                        .replace(/"/g, '""')
                        .replace(/\n/g, ' ')
                    +
                    '"';

            }).join(',');

        }).join('\n');

        const blob = new Blob(
            ['\ufeff' + csv],
            {
                type: 'text/csv;charset=utf-8;'
            }
        );

        const url = URL.createObjectURL(blob);

        const a = document.createElement('a');

        a.href = url;
        a.download = 'resguardos.csv';

        document.body.appendChild(a);
        a.click();
        a.remove();

        URL.revokeObjectURL(url);
    });


/* =========================================================
   VER REGISTRO
========================================================= */

function verRegistro(id) {

    /*
     * Puedes reemplazar esta acción por:
     * window.location.href = 'detalle.php?id=' + id;
     */

    window.location.href = 'detalle.php?id=' + encodeURIComponent(id);
}
</script>

<?php include "footer.php"; ?>
