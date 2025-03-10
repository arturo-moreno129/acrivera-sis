


document.addEventListener("DOMContentLoaded", function () {
    const rowsPerPage = 7; // Número de filas por página
    const table = document.getElementById("myTableResguardo");
    const tbody = table.querySelector("tbody");
    const rows = Array.from(tbody.rows);
    const pagination = document.getElementById("pagination");
    let currentPage = 1;

    function showPage(page) {
        tbody.innerHTML = "";
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        rows.slice(start, end).forEach(row => tbody.appendChild(row));

        currentPage = page;
        renderPagination();
    }

    function renderPagination() {
        pagination.innerHTML = "";
        const totalPages = Math.ceil(rows.length / rowsPerPage);
        const maxVisiblePages = 3; // Número de páginas visibles antes de mostrar "..."

        const createButton = (text, page) => {
            const btn = document.createElement("button");
            btn.textContent = text;
            btn.className = `px-3 py-2 border rounded-md ${page === currentPage ? "bg-blue-600 text-white" : ""}`;
            btn.onclick = () => showPage(page);
            return btn;
        };

        // Botón "Anterior"
        if (currentPage > 1) {
            pagination.appendChild(createButton("«", currentPage - 1));
        }

        // Primera página
        pagination.appendChild(createButton(1, 1));

        // Puntos suspensivos si hay más páginas antes
        if (currentPage > maxVisiblePages + 1) {
            pagination.appendChild(document.createTextNode("..."));
        }

        // Páginas centrales
        for (let i = Math.max(2, currentPage - 1); i <= Math.min(totalPages - 1, currentPage + 1); i++) {
            pagination.appendChild(createButton(i, i));
        }

        // Puntos suspensivos si hay más páginas después
        if (currentPage < totalPages - maxVisiblePages) {
            pagination.appendChild(document.createTextNode("..."));
        }

        // Última página (si hay más de una)
        if (totalPages > 1) {
            pagination.appendChild(createButton(totalPages, totalPages));
        }

        // Botón "Siguiente"
        if (currentPage < totalPages) {
            pagination.appendChild(createButton("»", currentPage + 1));
        }
    }

    showPage(1);
});
