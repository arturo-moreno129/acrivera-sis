<?php
include 'header.php';
?>

<div class="module-page">
    <div class="module-header">
        <div>
            <h1>Módulo Consumibles</h1>
            <p>Gestión de consumibles de la tabla <strong>consumibles</strong>. Crea, edita y elimina los registros del inventario.</p>
        </div>
        <button id="btnAddConsumible" class="btn-action primary-btn">Nuevo consumible</button>
    </div>

    <div class="module-controls">
        <div class="control-group">
            <input id="inputSearch" type="search" placeholder="Buscar por nombre o descripción" class="module-input" />
        </div>
        <div class="control-group control-group-inline">
            <label for="selectPageSize" class="control-label">Registros por página</label>
            <select id="selectPageSize" class="module-select">
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="20">20</option>
                <option value="50">50</option>
            </select>
        </div>
    </div>

    <div class="table-wrapper module-table-wrapper">
        <table id="consumiblesTable" class="module-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="consumiblesBody"></tbody>
        </table>

        <div id="paginationControls" class="pagination-controls"></div>
    </div>
</div>

<script src="js/consumibles_crud.js"></script>

<?php
include 'footer.php';
?>
