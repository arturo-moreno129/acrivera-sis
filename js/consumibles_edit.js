document.addEventListener('DOMContentLoaded', function () {
  let tonersList = [];

  // Cargar lista de tóners al cargar la página
  fetch('consumibles_api.php?action=list')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        tonersList = data.data;
      }
    })
    .catch(error => console.error('Error cargando tóners:', error));

  // Reemplaza el modal por un SweetAlert al hacer click en el botón 'Editar'
  document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', function (e) {
      e.stopPropagation();
      const card = this.closest('.card1');
      const id_impresora = this.getAttribute('data-id-impresora');
      const id_consumible = this.getAttribute('data-id-consumible');

      const ubicacionVal = card.getAttribute('data_ubicacion') || '';
      const noSerieVal = card.getAttribute('data_no_serie') || '';
      const modeloVal = card.getAttribute('data_modelo') || '';
      const nombreVal = card.getAttribute('data_nombre') || '';
      const direccionIpAttr = card.getAttribute('data_direccion_ip') || '';
      const cantidadVal = card.getAttribute('data_cantidad_disponible') || 0;
      const marcaEl = Array.from(card.querySelectorAll('.info1')).find(i => i.textContent.includes('Marca'));
      let marcaVal = '';
      if (marcaEl) {
        const v = marcaEl.querySelector('.value1');
        if (v) marcaVal = v.textContent.trim();
      }
      const ipEl = Array.from(card.querySelectorAll('.info1')).find(i => i.textContent.toLowerCase().includes('ip') || i.textContent.toLowerCase().includes('dirección'));
      let ipVal = '';
      if (ipEl) {
        const v = ipEl.querySelector('.value1');
        if (v) ipVal = v.textContent.trim();
      }

      // Generar opciones de tóner
      const tonerOptions = tonersList.map(toner => `
        <option value="${toner.id_consumible}" ${toner.id_consumible == id_consumible ? 'selected' : ''}>
          ${toner.nombre}
        </option>
      `).join('');

      Swal.fire({
        title: 'Editar impresora / consumible',
        showCancelButton: true,
        confirmButtonText: 'Guardar',
        cancelButtonText: 'Cancelar',
        html: `
          <div style="text-align:left;margin-bottom:8px;"><label style="display:block;margin-bottom:4px;font-weight:600;color:#333;font-size:14px;">Ubicación</label><input id="sw_ubicacion" class="swal2-input" placeholder="Ubicación"></div>
          <div style="text-align:left;margin-bottom:8px;"><label style="display:block;margin-bottom:4px;font-weight:600;color:#333;font-size:14px;">Marca</label><input id="sw_marca" class="swal2-input" placeholder="Marca"></div>
          <div style="text-align:left;margin-bottom:8px;"><label style="display:block;margin-bottom:4px;font-weight:600;color:#333;font-size:14px;">Número de serie</label><input id="sw_no_serie" class="swal2-input" placeholder="Número de serie"></div>
          <div style="text-align:left;margin-bottom:8px;"><label style="display:block;margin-bottom:4px;font-weight:600;color:#333;font-size:14px;">Modelo</label><input id="sw_modelo" class="swal2-input" placeholder="Modelo"></div>
          <div style="text-align:left;margin-bottom:8px;"><label style="display:block;margin-bottom:4px;font-weight:600;color:#333;font-size:14px;">Tóner</label><select id="sw_toner" class="swal2-select" style="width:100%; padding:8px; font-size:14px; border:1px solid #ddd; border-radius:4px;">${tonerOptions}</select></div>
          <div style="text-align:left;margin-bottom:8px;"><label style="display:block;margin-bottom:4px;font-weight:600;color:#333;font-size:14px;">Dirección IP</label><input id="sw_direccion_ip" class="swal2-input" placeholder="Dirección IP"></div>
        `,
        didOpen: () => {
          document.getElementById('sw_ubicacion').value = ubicacionVal;
          document.getElementById('sw_marca').value = marcaVal;
          document.getElementById('sw_no_serie').value = noSerieVal;
          document.getElementById('sw_modelo').value = modeloVal;
          const swIp = document.getElementById('sw_direccion_ip');
          if (swIp) swIp.value = direccionIpAttr || ipVal || '';
        },
        preConfirm: () => {
          const newTonerSelect = document.getElementById('sw_toner');
          const selectedTonerValue = newTonerSelect ? parseInt(newTonerSelect.value, 10) : id_consumible;
          
          const resultData = {
            id_impresora,
            id_consumible,
            ubicacion: document.getElementById('sw_ubicacion').value,
            marca: document.getElementById('sw_marca').value,
            no_serie: document.getElementById('sw_no_serie').value,
            modelo: document.getElementById('sw_modelo').value,
            cantidad_disponible: cantidadVal,
            direccion_ip: (document.getElementById('sw_direccion_ip') && document.getElementById('sw_direccion_ip').value) || ''
          };

          // Si cambió el tóner, agregar selected_consumible_id
          if (selectedTonerValue !== id_consumible) {
            resultData.selected_consumible_id = selectedTonerValue;
          }

          return resultData;
        }
      }).then(result => {
        if (result.isConfirmed) {
          const data = result.value;
          fetch('update_consumible.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
          }).then(r => r.json()).then(res => {
            if (res.success) {
              // Actualizar la tarjeta sin hacer reload
              if (card) {
                card.setAttribute('data_ubicacion', data.ubicacion);
                card.setAttribute('data_no_serie', data.no_serie);
                card.setAttribute('data_modelo', data.modelo);
                card.setAttribute('data_direccion_ip', data.direccion_ip);

                // Si cambió el tóner, actualizar data_nombre y data_id_consumible
                if (data.selected_consumible_id) {
                  const newTonerName = tonersList.find(t => t.id_consumible == data.selected_consumible_id)?.nombre || '';
                  card.setAttribute('data_nombre', newTonerName);
                  card.setAttribute('data_id_consumible', data.selected_consumible_id);

                  // Actualizar data-id-consumible en los botones
                  const editBtn = card.querySelector('.edit-btn');
                  const updateConsBtn = card.querySelector('.update-consumibles');
                  if (editBtn) editBtn.setAttribute('data-id-consumible', data.selected_consumible_id);
                  if (updateConsBtn) updateConsBtn.setAttribute('data-id-consumible', data.selected_consumible_id);
                }

                // Actualizar los valores visibles en la tarjeta
                const infoElements = card.querySelectorAll('.info1');
                infoElements.forEach((info, index) => {
                  const value = info.querySelector('.value1');
                  if (!value) return;

                  if (info.textContent.includes('Área') && index === 0) {
                    value.textContent = data.ubicacion;
                  } else if (info.textContent.includes('Marca')) {
                    value.textContent = data.marca;
                  } else if (info.textContent.includes('Número de serie')) {
                    value.textContent = data.no_serie;
                  } else if (info.textContent.includes('Modelo')) {
                    value.textContent = data.modelo;
                  } else if (info.textContent.toLowerCase().includes('dirección') || info.textContent.toLowerCase().includes('ip')) {
                    value.textContent = data.direccion_ip;
                  } else if (info.textContent.includes('Tóner')) {
                    if (data.selected_consumible_id) {
                      const newTonerName = tonersList.find(t => t.id_consumible == data.selected_consumible_id)?.nombre || '';
                      value.textContent = newTonerName;
                    }
                  }
                });
              }

              Swal.fire('Listo', 'Impresora actualizada', 'success').then(() => {
                location.reload();
              });
            } else {
              Swal.fire('Error', res.message || 'No se pudo actualizar', 'error');
            }
          }).catch(err => { console.error(err); Swal.fire('Error', 'Error en la petición', 'error'); });
        }
      });
    });
  });
});