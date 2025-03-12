document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('.btnPopUp').forEach((btn) => {
        btn.addEventListener('click', function () {
            const idDirec = this.getAttribute("value");
            console.log('es el id', idDirec);
            fetch('crud-calendar.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `action=obtenerDatos&id=${idDirec}`

            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        console.log(data.message[0]);
                        const { id_user, nom_usu, puesto, correo, extencion } = data.message[0];
                        console.log(id_user, nom_usu, puesto, correo, extencion);
                        Swal.fire({
                            title: "Personal",
                            showDenyButton: true,
                            showCancelButton: true,
                            confirmButtonText: "Actualizar",
                            denyButtonText: "Eliminar",
                            html: `
                                    <label style="text-align: left; for="#">Nombre:</label>
                                    <input id="nom" class="swal2-input" value="${nom_usu}"><br>
                                    <label style="text-align: left; for="#">Puesto:</label>
                                    <input id="puesto" class="swal2-input" value="${puesto}"><br>
                                    <label style="text-align: left; for="#">Correo:</label>
                                    <input id="email" class="swal2-input" value="${correo}"><br>
                                    <label style="text-align: left; for="#">Extension:</label>
                                    <input id="extension" class="swal2-input" value="${extencion}"><br>
                                `,
                            preConfirm: () => {
                                return {
                                    id: id_user,
                                    nombre: document.getElementById('nom').value,
                                    puesto: document.getElementById('puesto').value,
                                    correo: document.getElementById('email').value,
                                    extension: document.getElementById('extension').value
                                };
                            }
                        })
                            .then((result) => {
                                if (result.isConfirmed) {
                                    const { id, nombre, puesto, correo, extension } = result.value;
                                    
                                    fetch('crud-calendar.php', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/x-www-form-urlencoded'
                                        },
                                        body: `action=updateDir&id=${id}&nombre=${nombre}&puesto=${puesto}&correo=${correo}&extension=${extension}`
                                    })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.status === 'success') {
                                                Swal.fire({
                                                    title: "Listo!",
                                                    text: data.message,
                                                    icon: "success"
                                                }).then(result => {
                                                    if (result.isConfirmed) {
                                                        location.reload();
                                                    }
                                                })
                                            }
                                        })
                                } else if (result.isDenied) {
                                    Swal.fire("Esatas seguro de eliminar al usuario", "", "warning").then(result => {
                                        if (result.isConfirmed) {
                                            fetch('crud-calendar.php', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/x-www-form-urlencoded'
                                                },
                                                body: `action=deleteDir&id=${id_user}`
                                            })
                                                .then(response => response.json())
                                                .then(data => {
                                                    if (data.status === 'success') {
                                                        Swal.fire({
                                                            title: "Listo!",
                                                            text: data.message,
                                                            icon: "success"
                                                        }).then(result => {
                                                            if (result.isConfirmed) {
                                                                location.reload();
                                                            }
                                                        })
                                                    }
                                                })
                                        }
                                    })
                                }

                            });
                    } else {
                        console.log("error de consulta", data.message)
                    }
                })

        });
    });


    //boton para agregar unusauario
    const btnAdd = document.querySelector('#btnAdd')
    const areas = ['DG', 'DF', 'CL', 'AUD', 'CXC', 'CT', 'TA', 'PLD', 'EF', 'RH', 'MK', 'TI', 'CS', 'AA', 'VR', 'SV', 'HYP', 'AV', 'VC', 'VP', 'VS', 'VSN'];
    const areaslong = ['Dirección General', 'Director Financiero', 'Contraloria ', 'Auditoría', 'Crédito y Cobranza', 'Contabilidad', 'Tesorería', 'PLD', 'Enlace Financiero', 'Recursos Humanos', 'Marketing', 'TI - Sistemas', 'Compras', 'Administración Almacén', 'Ventas de Refacciones', 'Servicio', 'Hojalatería y Pintura', 'Administración Ventas', 'Ventas Carga', 'Ventas Pasaje', 'Ventas Sprinter', 'Ventas Seminuevos'];
    btnAdd.addEventListener('click', () => {
        Swal.fire({
            title: "Nuevo personal",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "FINALIZAR",
            denyButtonText: "CANCELAR",
            html: `
                <label style="text-align: left;">Nombre:</label>
                <input id="Nnom" class="swal2-input"><br>
                <label style="text-align: left;">Puesto:</label>
                <input id="Npuesto" class="swal2-input"><br>
                <label style="text-align: left;">Correo:</label>
                <input id="Nemail" class="swal2-input"><br>
                <label style="text-align: left;">Extensión:</label>
                <input type="number" id="Nextension" class="swal2-input"><br>
                <label style="text-align: left;">Área:</label>
                <select id="Narea" class="form-control">
                    <option value="0">SELECCIONA UNA AREA</option>
                </select>
            `,
            didOpen: () => {
                const select = document.getElementById("Narea");
                var i = 0;
                areas.forEach(area => {
                    let option = document.createElement("option");
                    option.value = area;
                    option.textContent = areaslong[i];
                    select.appendChild(option);
                    i++;
                });
            },
            preConfirm: () => {
                const nombre = document.getElementById('Nnom').value;
                const puesto = document.getElementById('Npuesto').value;
                const correo = document.getElementById('Nemail').value;
                const extension = document.getElementById('Nextension').value;
                const slect = document.getElementById('Narea').value;

                if (!nombre) {
                    Swal.showValidationMessage("Debes ingresar el nombre");
                    return false;
                }
                if (!puesto) {
                    Swal.showValidationMessage("Debes ingresar el puesto");
                    return false;
                }
                if (!correo) {
                    Swal.showValidationMessage("Debes ingresar el correo");
                    return false;
                }
                if (!extension) {
                    Swal.showValidationMessage("Debes ingresar la extensión");
                    return false;
                }
                if (slect == '0') {
                    Swal.showValidationMessage("Debes seleccionar una área");
                    return false;
                }
                return { nombre, puesto, correo, extension, area: slect };
            }
        }).then(result => {
            if (result.isConfirmed) {
                const { nombre, puesto, correo, extension, area } = result.value;
                console.log(nombre, puesto, correo, extension, area);
                fetch('crud-calendar.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `action=insertDir&nombre=${nombre}&puesto=${puesto}&correo=${correo}&extension=${extension}&area=${area}`
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire({
                                title: "Listo!",
                                text: data.message,
                                icon: "success"
                            }).then(result => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        }
                    });
            } else if (result.isDenied) {
                Swal.fire("Los cambios no se guardaron", "", "info");
            }
        });

    })
});