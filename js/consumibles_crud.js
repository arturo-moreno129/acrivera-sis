document.addEventListener('DOMContentLoaded', () => {
  const tableBody = document.getElementById('consumiblesBody');
  const addButton = document.getElementById('btnAddConsumible');
  const searchInput = document.getElementById('inputSearch');
  const pageSizeSelect = document.getElementById('selectPageSize');
  const paginationControls = document.getElementById('paginationControls');

  let consumiblesData = [];
  let currentPage = 1;
  let pageSize = parseInt(pageSizeSelect.value, 10);

  const loadConsumibles = () => {
    fetch('consumibles_api.php?action=list')
      .then(res => res.json())
      .then(response => {
        if (!response.success) throw new Error(response.message || 'Error al cargar consumibles');
        consumiblesData = response.data;
        currentPage = 1;
        renderTable();
      })
      .catch(error => {
        Swal.fire('Error', error.message, 'error');
      });
  };

  const getFilteredData = () => {
    const term = searchInput.value.trim().toLowerCase();
    if (!term) return consumiblesData;
    return consumiblesData.filter(item => {
      return item.nombre.toLowerCase().includes(term) || (item.descripcion || '').toLowerCase().includes(term);
    });
  };

  const renderTable = () => {
    const filtered = getFilteredData();
    const totalRows = filtered.length;
    const totalPages = Math.max(1, Math.ceil(totalRows / pageSize));
    if (currentPage > totalPages) currentPage = totalPages;

    const startIndex = (currentPage - 1) * pageSize;
    const pageRows = filtered.slice(startIndex, startIndex + pageSize);

    if (pageRows.length === 0) {
      tableBody.innerHTML = `
        <tr>
          <td colspan="5" style="padding:20px 14px; text-align:center; color:#64748b;">No hay consumibles que coincidan con la búsqueda.</td>
        </tr>
      `;
    } else {
      tableBody.innerHTML = pageRows.map(row => htmlRow(row)).join('');
    }

    bindRowActions();
    renderPagination(totalPages, totalRows);
  };

  const htmlRow = ({ id_consumible, nombre, cantidad_disponible, descripcion }) => {
    return `
      <tr style="border-bottom:1px solid #e2e8f0;">
        <td style="padding:12px 14px;">${id_consumible}</td>
        <td style="padding:12px 14px;">${escapeHtml(nombre)}</td>
        <td style="padding:12px 14px;">${cantidad_disponible}</td>
        <td style="padding:12px 14px;">${escapeHtml(descripcion)}</td>
        <td style="padding:12px 14px;">
          <button class="action-btn edit-btn" data-id="${id_consumible}" style="margin-right:8px;">Editar</button>
          <button class="action-btn delete-btn" data-id="${id_consumible}">Eliminar</button>
        </td>
      </tr>
    `;
  };

  const escapeHtml = (text) => {
    if (text === null || text === undefined) return '';
    return text.toString().replace(/[&<>\"]/g, match => ({ '&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;' })[match]);
  };

  const renderPagination = (totalPages, totalRows) => {
    const start = totalRows === 0 ? 0 : (currentPage - 1) * pageSize + 1;
    const end = Math.min(currentPage * pageSize, totalRows);

    const pageButtons = [];
    for (let i = 1; i <= totalPages; i += 1) {
      pageButtons.push(`
        <button class="page-button" data-page="${i}" style="padding:8px 12px; margin-right:6px; border:1px solid ${i === currentPage ? '#4f46e5' : '#cbd5e1'}; background:${i === currentPage ? '#eef2ff' : '#fff'}; color:${i === currentPage ? '#3730a3' : '#0f172a'}; border-radius:8px; cursor:pointer;">${i}</button>
      `);
    }

    paginationControls.innerHTML = `
      <div style="color:#475569;">Mostrando ${start} - ${end} de ${totalRows} registros</div>
      <div style="display:flex; flex-wrap:wrap; align-items:center; gap:6px;">${pageButtons.join('')}</div>
    `;

    paginationControls.querySelectorAll('.page-button').forEach(btn => {
      btn.addEventListener('click', () => {
        currentPage = parseInt(btn.dataset.page, 10);
        renderTable();
      });
    });
  };

  const bindRowActions = () => {
    tableBody.querySelectorAll('.edit-btn').forEach(btn => {
      btn.addEventListener('click', () => showEditModal(btn.dataset.id));
    });
    tableBody.querySelectorAll('.delete-btn').forEach(btn => {
      btn.addEventListener('click', () => confirmDelete(btn.dataset.id));
    });
  };

  const showEditModal = (id) => {
    const consumible = consumiblesData.find(item => item.id_consumible == id);
    if (!consumible) {
      return Swal.fire('Error', 'Consumible no encontrado', 'error');
    }

    Swal.fire({
      title: 'Editar consumible',
      html: formHtml(consumible),
      showCancelButton: true,
      confirmButtonText: 'Guardar',
      cancelButtonText: 'Cancelar',
      focusConfirm: false,
      preConfirm: () => {
        const nombre = document.getElementById('sw_nombre').value.trim();
        const cantidad = document.getElementById('sw_cantidad').value;
        const descripcion = document.getElementById('sw_descripcion').value.trim();
        if (!nombre) {
          Swal.showValidationMessage('El nombre es obligatorio');
          return false;
        }
        return { id_consumible: id, nombre, cantidad_disponible: parseInt(cantidad, 10) || 0, descripcion };
      }
    }).then(result => {
      if (result.isConfirmed) {
        saveConsumible('update', result.value).then(() => loadConsumibles());
      }
    });
  };

  const confirmDelete = (id) => {
    Swal.fire({
      title: 'Eliminar consumible',
      text: '¿Estás seguro que deseas eliminar este registro?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar'
    }).then(result => {
      if (result.isConfirmed) {
        saveConsumible('delete', { id_consumible: id }).then(() => {
          Swal.fire('Eliminado', 'El consumible fue eliminado', 'success');
          loadConsumibles();
        });
      }
    });
  };

  const saveConsumible = (action, data) => {
    const formData = new FormData();
    formData.append('action', action);
    Object.entries(data).forEach(([key, value]) => formData.append(key, value));

    return fetch('consumibles_api.php', {
      method: 'POST',
      body: formData
    })
      .then(res => res.json())
      .then(response => {
        if (!response.success) throw new Error(response.message || 'Error en la operación');
        return response;
      })
      .catch(error => Swal.fire('Error', error.message, 'error'));
  };

  const showNewModal = () => {
    Swal.fire({
      title: 'Nuevo consumible',
      html: formHtml({ nombre: '', cantidad_disponible: 0, descripcion: '' }),
      showCancelButton: true,
      confirmButtonText: 'Crear',
      cancelButtonText: 'Cancelar',
      focusConfirm: false,
      preConfirm: () => {
        const nombre = document.getElementById('sw_nombre').value.trim();
        const cantidad = document.getElementById('sw_cantidad').value;
        const descripcion = document.getElementById('sw_descripcion').value.trim();
        if (!nombre) {
          Swal.showValidationMessage('El nombre es obligatorio');
          return false;
        }
        return { nombre, cantidad_disponible: parseInt(cantidad, 10) || 0, descripcion };
      }
    }).then(result => {
      if (result.isConfirmed) {
        saveConsumible('create', result.value).then(() => {
          Swal.fire('Creado', 'El consumible fue creado', 'success');
          loadConsumibles();
        });
      }
    });
  };

  const formHtml = ({ nombre, cantidad_disponible, descripcion }) => {
    return `
      <div style="text-align:left; margin-top:10px;">
        <label style="display:block; margin-bottom:4px; font-weight:600; color:#0f172a;">Nombre</label>
        <input id="sw_nombre" class="swal2-input" value="${escapeHtml(nombre)}" placeholder="Nombre del consumible">
      </div>
      <div style="text-align:left; margin-top:10px;">
        <label style="display:block; margin-bottom:4px; font-weight:600; color:#0f172a;">Cantidad disponible</label>
        <input id="sw_cantidad" type="number" min="0" class="swal2-input" value="${escapeHtml(cantidad_disponible)}" placeholder="Cantidad disponible">
      </div>
      <div style="text-align:left; margin-top:10px;">
        <label style="display:block; margin-bottom:4px; font-weight:600; color:#0f172a;">Descripción</label>
        <textarea id="sw_descripcion" class="swal2-textarea" placeholder="Descripción del consumible" style="min-height:100px;">${escapeHtml(descripcion)}</textarea>
      </div>
    `;
  };

  addButton.addEventListener('click', showNewModal);
  searchInput.addEventListener('input', () => {
    currentPage = 1;
    renderTable();
  });
  pageSizeSelect.addEventListener('change', () => {
    pageSize = parseInt(pageSizeSelect.value, 10);
    currentPage = 1;
    renderTable();
  });

  loadConsumibles();
});
