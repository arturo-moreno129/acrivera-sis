document.addEventListener('DOMContentLoaded', function () {
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
          <div style="text-align:left;margin-bottom:8px;"><label style="display:block;margin-bottom:4px;font-weight:600;color:#333;font-size:14px;">Tóner (nombre)</label><input id="sw_nombre" class="swal2-input" placeholder="Tóner (nombre)"></div>
          <!-- Campo 'Cantidad disponible' eliminado del modal (se actualiza con 'Actualizar consumibles') -->
          <div style="text-align:left;margin-bottom:8px;"><label style="display:block;margin-bottom:4px;font-weight:600;color:#333;font-size:14px;">Dirección IP</label><input id="sw_direccion_ip" class="swal2-input" placeholder="Dirección IP"></div>
        `,
        didOpen: () => {
          document.getElementById('sw_ubicacion').value = ubicacionVal;
          document.getElementById('sw_marca').value = marcaVal;
          document.getElementById('sw_no_serie').value = noSerieVal;
          document.getElementById('sw_modelo').value = modeloVal;
          document.getElementById('sw_nombre').value = nombreVal;
          // `cantidad disponible` se gestiona por separado; no se inicializa aquí
          // establecer IP si existe
          const swIp = document.getElementById('sw_direccion_ip');
          if (swIp) swIp.value = direccionIpAttr || ipVal || '';
        },
        preConfirm: () => {
          return {
            id_impresora,
            id_consumible,
            ubicacion: document.getElementById('sw_ubicacion').value,
            marca: document.getElementById('sw_marca').value,
            no_serie: document.getElementById('sw_no_serie').value,
            modelo: document.getElementById('sw_modelo').value,
            nombre: document.getElementById('sw_nombre').value,
            direccion_ip: (document.getElementById('sw_direccion_ip') && document.getElementById('sw_direccion_ip').value) || ''
          };
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
              // update card in DOM
              const selector = `.card1[data_id_impresora="${data.id_impresora}"]`;
              const cardEl = document.querySelector(selector);
              if (cardEl) {
                cardEl.setAttribute('data_ubicacion', data.ubicacion);
                cardEl.setAttribute('data_no_serie', data.no_serie);
                cardEl.setAttribute('data_modelo', data.modelo);
                cardEl.setAttribute('data_nombre', data.nombre);
                // `cantidad_disponible` no se actualiza desde este modal; se mantiene el valor actual en la card
                // actualizar atributo de IP
                if (data.direccion_ip !== undefined) cardEl.setAttribute('data_direccion_ip', data.direccion_ip);
                const values = cardEl.querySelectorAll('.value1');
                if (values.length >= 5) {
                  values[0].textContent = data.ubicacion;
                  values[1].textContent = res.marca || data.marca || values[1].textContent;
                  values[2].textContent = data.no_serie;
                  values[3].textContent = data.modelo;
                  values[4].textContent = data.nombre;
                }
                // si existe elemento para IP en la card, actualizar su valor
                const ipElCard = Array.from(cardEl.querySelectorAll('.info1')).find(i => i.textContent.toLowerCase().includes('ip') || i.textContent.toLowerCase().includes('dirección'));
                if (ipElCard) {
                  const v = ipElCard.querySelector('.value1');
                  if (v && data.direccion_ip !== undefined) v.textContent = data.direccion_ip;
                }
              }
              Swal.fire('Listo', 'Consumible actualizado', 'success');
            } else {
              Swal.fire('Error', res.message || 'No se pudo actualizar', 'error');
            }
          }).catch(err => { console.error(err); Swal.fire('Error', 'Error en la petición', 'error'); });
        }
      });
    });
  });
});