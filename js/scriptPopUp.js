document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('.btnPopUp').forEach((btn) => {//este metodo es para actualizar personal ya registrado
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
                        const areas1 = ['DG', 'DF', 'CL', 'AUD', 'CXC', 'CT', 'TA', 'PLD', 'EF', 'RH', 'MK', 'TI', 'CS', 'AA', 'VR', 'SV', 'HYP', 'AV', 'VC', 'VP', 'VS', 'VSN', 'SA', 'SAT', 'ST'];
                        const areaslong1 = ['Dirección General', 'Director Financiero', 'Contraloria ', 'Auditoría', 'Crédito y Cobranza', 'Contabilidad', 'Tesorería', 'PLD', 'Enlace Financiero', 'Recursos Humanos', 'Marketing', 'TI - Sistemas', 'Compras', 'Administración Almacén', 'Ventas de Refacciones', 'Servicio', 'Hojalatería y Pintura', 'Administración Ventas', 'Ventas Carga', 'Ventas Pasaje', 'Ventas Sprinter', 'Ventas Seminuevos', 'Sucursal Apizaco', 'Sucursal Alliance Tehuacán-238 383 8745', 'Sucursal Teziutlán'];

                        Swal.fire({
                            title: "Personal",
                            showDenyButton: true,
                            showCancelButton: true,
                            confirmButtonText: "Actualizar",
                            denyButtonText: "Baja",
                            html: `
                                    <label style="text-align: left; for="#">Nombre:</label>
                                    <input id="nom" class="swal2-input" value="${nom_usu}"><br>
                                    <label style="text-align: left; for="#">Puesto:</label>
                                    <input id="puesto" class="swal2-input" value="${puesto}"><br>
                                    <label style="text-align: left; for="#">Correo:</label>
                                    <input id="email" class="swal2-input" value="${correo}"><br>
                                    <label style="text-align: left; for="#">Extension:</label>
                                    <input id="extension" class="swal2-input" value="${extencion}"><br>
                                    <select id="Narea1" class="form-control">
                                        <option value="0">SELECCIONA UNA AREA</option>
                                    </select>
                                `,
                            didOpen: () => {
                                const select = document.getElementById("Narea1");
                                var i = 0;
                                areas1.forEach(area => {
                                    let option = document.createElement("option");
                                    option.value = area;
                                    option.textContent = areaslong1[i];
                                    select.appendChild(option);
                                    i++;
                                });
                            },
                            preConfirm: () => {
                                return {
                                    id: id_user,
                                    nombre: document.getElementById('nom').value,
                                    puesto: document.getElementById('puesto').value,
                                    correo: document.getElementById('email').value,
                                    extension: document.getElementById('extension').value,
                                    slect1: document.getElementById('Narea1').value
                                };
                            }
                        })
                            .then((result) => {
                                if (result.isConfirmed) {
                                    const { id, nombre, puesto, correo, extension, slect1 } = result.value;

                                    fetch('crud-calendar.php', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/x-www-form-urlencoded'
                                        },
                                        body: `action=updateDir&id=${id}&nombre=${nombre}&puesto=${puesto}&correo=${correo}&extension=${extension}&area=${slect1}`
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
                                    Swal.fire("Esatas seguro de dar de baja al usuario", "", "warning").then(result => {
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
    const areas = ['DG', 'DF', 'CL', 'AUD', 'CXC', 'CT', 'TA', 'PLD', 'EF', 'RH', 'MK', 'TI', 'CS', 'AA', 'VR', 'SV', 'HYP', 'AV', 'VC', 'VP', 'VS', 'VSN', 'SA', 'SAT', 'ST'];
    const areaslong = ['Dirección General', 'Director Financiero', 'Contraloria ', 'Auditoría', 'Crédito y Cobranza', 'Contabilidad', 'Tesorería', 'PLD', 'Enlace Financiero', 'Recursos Humanos', 'Marketing', 'TI - Sistemas', 'Compras', 'Administración Almacén', 'Ventas de Refacciones', 'Servicio', 'Hojalatería y Pintura', 'Administración Ventas', 'Ventas Carga', 'Ventas Pasaje', 'Ventas Sprinter', 'Ventas Seminuevos', 'Sucursal Apizaco', 'Sucursal Alliance Tehuacán - 238 383 8745', 'Sucursal Teziutlán'];
    if (btnAdd) {
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
                    //console.log(nombre, puesto, correo, extension, area);
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
                            else {
                                console.log(data.message)
                            }
                        });
                } else if (result.isDenied) {
                    Swal.fire("Los cambios no se guardaron", "", "info");
                }
            });

        })
    }


    //******************************************funcionalidad para impresoras************************************
    //accedemos a cada btn que se crea en la tabla
    document.querySelectorAll('.btnPopUp2').forEach((btn) => {
        //crramos el eventop click para cada elemento
        btn.addEventListener("click", function () {
            const idimpresora = this.getAttribute("value"); //obtenemos el id del elemento seleccionado
            //console.log(idimpresora);
            fetch('crud-calendar.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `action=obtenerImpresoras&idprint=${idimpresora}`
            })
                .then(response => response.json())//deserializamos la cadena que nos regresa la consulta
                .then(data => {
                    if (data.status === "success") {
                        const { id_impresora, ubicacion, marca, direccion_ip, direccion_mac } = data.message[0];
                        console.log(id_impresora, ubicacion, marca, direccion_ip, direccion_mac);
                        /*Swal.fire({
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
                            <select id="Narea1" class="form-control">
                                <option value="0">SELECCIONA UNA AREA</option>
                            </select>
                        `,
                            didOpen: () => {
                                const select = document.getElementById("Narea1");
                                var i = 0;
                                areas1.forEach(area => {
                                    let option = document.createElement("option");
                                    option.value = area;
                                    option.textContent = areaslong1[i];
                                    select.appendChild(option);
                                    i++;
                                });
                            },
                            preConfirm: () => {
                                return {
                                    id: id_user,
                                    nombre: document.getElementById('nom').value,
                                    puesto: document.getElementById('puesto').value,
                                    correo: document.getElementById('email').value,
                                    extension: document.getElementById('extension').value,
                                    slect1: document.getElementById('Narea1').value
                                };
                            }
                        })*/
                    }
                })
        })
    })
    //***************boton para exportar a excel */
    const btnExxport = document.querySelector("#btnExport");
    if (btnExxport) {
        btnExxport.addEventListener('click', () => {
            fetch('exportDir.php', {
                method: 'POST'
            })
                .then(response => {
                    if (!response.ok) throw new Error('No se pudo generar el archivo');
                    return response.blob();
                })
                .then(blob => {
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = `Directorio Organizacional - ACR.xlsx`;
                    document.body.appendChild(a);
                    a.click();
                    a.remove();

                    Swal.fire({
                        title: "¡Listo!",
                        text: "El directorio se descargó correctamente.",
                        icon: "success"
                    });
                })
                .catch(error => {
                    console.error('Error en la exportación:', error);
                    Swal.fire({
                        title: "Error",
                        text: "No se pudo exportar el archivo.",
                        icon: "error"
                    });
                });
        })
    }
    //******************Boton para exportar inventario */
    const btnExportinventario = document.querySelector("#btnExportinventario");
    if (btnExportinventario) {
        btnExportinventario.addEventListener('click', () => {
            fetch('exportInventario.php', {
                method: 'POST'
            })
                .then(response => {
                    if (!response.ok) throw new Error('No se pudo generar el archivo');
                    return response.blob();
                })
                .then(blob => {
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = `Inventario - ACR.xlsx`;
                    document.body.appendChild(a);
                    a.click();
                    a.remove();

                    Swal.fire({
                        title: "¡Listo!",
                        text: "El inventario se descargó correctamente.",
                        icon: "success"
                    });
                })
                .catch(error => {
                    console.error('Error en la exportación:', error);
                    Swal.fire({
                        title: "Error",
                        text: "No se pudo exportar el archivo.",
                        icon: "error"
                    });
                });
        })
    }
    //***************boton para exportar a BLOC DE NOTAS */
    const btnExxport2 = document.querySelector("#btnExport2");
    if (btnExxport2) {
        btnExxport2.addEventListener('click', () => {
            Swal.fire({
                title: "Directorio",
                showCancelButton: true,
                confirmButtonText: "Actualizar",
                html: `<select id="Nareainv" class="form-control">
                        <option style="color: gray;" value="0">Selecciona una área</option>
                        <option style="color: red;" value="ALL">Todas las áreas</option>
                        <option value="DG">Direccion general</option>
                        <option value="DF">Director Financiero</option>
                        <option value="CL">Contraloria</option>
                        <option value="AUD">Auditoría</option>
                        <option value="CXC">Crédito y Cobranza</option>
                        <option value="CT">Contabilidad</option>
                        <option value="TA">Tesorería</option>
                        <option value="PLD">PLD</option>
                        <option value="EF">Enlace Financiero</option>
                        <option value="RH">Recursos Humanos</option>
                        <option value="MK">Marketing</option>
                        <option value="TI">TI - Sistemas</option>
                        <option value="CS">Compras</option>
                        <option value="AA">Administración Almacén</option>
                        <option value="VR">Ventas de Refacciones</option>
                        <option value="SV">Servicio</option>
                        <option value="HYP">Hojalatería y Pintura</option>
                        <option value="AV">Administración Ventas</option>
                        <option value="VC">Ventas Carga</option>
                        <option value="VP">Ventas Pasaje</option>
                        <option value="VS">Ventas Sprinter</option>
                        <option value="VSN">Ventas Seminuevos</option>
                        <option value="SA">Sucursal Apizaco</option>
                        <option value="SAT">Sucursal Alliance Tehuacán</option>
                        <option value="ST">Sucursal Tehuacán</option>
                    </select>`,
                preConfirm: () => {
                    const area = document.getElementById("Nareainv").value;
                    if (area === "0") {
                        Swal.showValidationMessage("Debes seleccionar una área");
                        return false;
                    }
                    return { area };
                }
            }).then(result => {
                if (result.isConfirmed) {
                    const { area } = result.value;
                    fetch('crud-calendar.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `action=exportarPorArea&area=${area}`
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                Swal.fire({
                                    title: "Éxito",
                                    text: "El archivo se ha generado correctamente.",
                                    icon: "success"
                                }).then(result => {
                                    if (result.isConfirmed) {
                                        const correos = Object.values(data.message)
                                            .map(valor => valor.correo)
                                            .join(", "); // separados por coma para Outlook

                                        // SweetAlert con botón de copiar
                                        Swal.fire({
                                            title: "Correos del área",
                                            html: `
                                        <textarea id="listaCorreos" readonly style="width:100%; height:200px; border-radius:5px;">${correos}</textarea>
                                        <button id="copiarBtn" class="swal2-confirm swal2-styled" style="margin-top:10px;">Copiar correos</button>
                                    `,
                                            showConfirmButton: false,
                                            didOpen: () => {
                                                const copiarBtn = document.getElementById('copiarBtn');
                                                copiarBtn.addEventListener('click', () => {
                                                    const textarea = document.getElementById('listaCorreos');
                                                    textarea.select();
                                                    document.execCommand('copy');
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: '¡Copiado!',
                                                        text: 'Los correos se copiaron al portapapeles. Puedes pegarlos en Outlook.',
                                                        timer: 3000,
                                                        showConfirmButton: false
                                                    });
                                                });
                                            }
                                        });
                                    }
                                });
                            }
                        });
                }
            });
        });
    }
    //******************************************fin de funcionalidad para impresoras************************************


    /*****************************BOTON PARA INGRESAR UN NUEVO HOST AL INVENTARIO********************************** */
    const btnAddinventario = document.querySelector('#btnAddinventario')
    if (btnAddinventario) {
        btnAddinventario.addEventListener('click', () => {
            Swal.fire({
                title: "Nuevo equipo",
                //showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "FINALIZAR",
                //denyButtonText: "CANCELAR",
                html: `
                                    <label style="text-align: left; for="#">Nombre:</label>
                                    <input id="txtname" class="swal2-input" ><br>
                                    <label style="text-align: left; for="#">Equipo:</label>
                                    <input id="txtequipo" class="swal2-input" ><br>
                                    <label style="text-align: left; for="#">Modelo:</label>
                                    <input id="txtmodelo" class="swal2-input" ><br>
                                    <label style="text-align: left; for="#">Marca:</label>
                                    <input id="txtmarca" class="swal2-input" ><br>
                                    <label style="text-align: left; for="#">No. Serie:</label>
                                    <input id="txtno_serie" class="swal2-input" ><br>
                                    <label style="text-align: left; for="#">Nom Host:</label>
                                    <input id="txtnom_host" class="swal2-input" ><br>
                                    <label style="text-align: left; for="#">Area:</label>
                                    <input id="txtdepartamento" class="swal2-input" ><br>
            `,
                preConfirm: () => {
                    const txtname = document.getElementById('txtname').value;
                    const txtequipo = document.getElementById('txtequipo').value;
                    const txtmodelo = document.getElementById('txtmodelo').value;
                    const txtmarca = document.getElementById('txtmarca').value;
                    const txtno_serie = document.getElementById('txtno_serie').value;
                    const txtnom_host = document.getElementById('txtnom_host').value;
                    const txtdepartamento = document.getElementById('txtdepartamento').value;

                    if (!txtname) {
                        Swal.showValidationMessage("Debes ingresar el nombre");
                        return false;
                    }
                    if (!txtequipo) {
                        Swal.showValidationMessage("Debes ingresar el puesto");
                        return false;
                    }
                    if (!txtmodelo) {
                        Swal.showValidationMessage("Debes ingresar el correo");
                        return false;
                    }
                    if (!txtmarca) {
                        Swal.showValidationMessage("Debes ingresar la extensión");
                        return false;
                    }
                    if (!txtno_serie) {
                        Swal.showValidationMessage("Debes seleccionar una área");
                        return false;
                    }
                    if (!txtnom_host) {
                        Swal.showValidationMessage("Debes ingresar el nombre");
                        return false;
                    }
                    if (!txtdepartamento) {
                        Swal.showValidationMessage("Debes ingresar el puesto");
                        return false;
                    }
                    return { txtname, txtequipo, txtmodelo, txtmarca, txtno_serie, txtnom_host, txtdepartamento };
                }
            }).then(result => {
                if (result.isConfirmed) {
                    const { txtname, txtequipo, txtmodelo, txtmarca, txtno_serie, txtnom_host, txtdepartamento } = result.value;
                    //console.log(nombre, puesto, correo, extension, area);
                    fetch('crud-calendar.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `action=insertarInventario&txtname=${txtname}&txtequipo=${txtequipo}&txtmodelo=${txtmodelo}&txtmarca=${txtmarca}&txtno_serie=${txtno_serie}&txtnom_host=${txtnom_host}&txtdepartamento=${txtdepartamento}`
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
                            else {
                                console.log(data.message)
                            }
                        });
                } else if (result.isDenied) {
                    Swal.fire("Los cambios no se guardaron", "", "info");
                }
            });
        })

    }
    /*****************************FIN DEL BOTON HOST*************************************************************** */
    /******************************BOTON PARA EDITAR REGISTROS DE INVENTARIO */
    document.querySelectorAll('.btnPopUpInventario').forEach((btn) => {//este metodo es para actualizar personal ya registrado
        btn.addEventListener('click', function () {
            const idDirec = this.getAttribute("value");
            //console.log('es el id', idDirec);
            fetch('crud-calendar.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `action=obtenerDatosInventario&id=${idDirec}`

            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        //console.log(data.message[0]);
                        const { id_inventario, usuario_asignado, tipo_equipo, modelo, marca, no_serie, nom_host, departamento, estatus } = data.message[0];
                        const estatusInventario = [0, 1];
                        const estatuInvName = ['Baja', 'Activo'];
                        //console.log(id_user, nom_usu, puesto, correo, extencion);
                        //const areas1 = ['DG', 'DF', 'CL', 'AUD', 'CXC', 'CT', 'TA', 'PLD', 'EF', 'RH', 'MK', 'TI', 'CS', 'AA', 'VR', 'SV', 'HYP', 'AV', 'VC', 'VP', 'VS', 'VSN'];
                        //const areaslong1 = ['Dirección General', 'Director Financiero', 'Contraloria ', 'Auditoría', 'Crédito y Cobranza', 'Contabilidad', 'Tesorería', 'PLD', 'Enlace Financiero', 'Recursos Humanos', 'Marketing', 'TI - Sistemas', 'Compras', 'Administración Almacén', 'Ventas de Refacciones', 'Servicio', 'Hojalatería y Pintura', 'Administración Ventas', 'Ventas Carga', 'Ventas Pasaje', 'Ventas Sprinter', 'Ventas Seminuevos'];

                        Swal.fire({
                            title: "Inventario",
                            //showDenyButton: true,
                            showCancelButton: true,
                            confirmButtonText: "Actualizar",
                            //denyButtonText: "Baja",
                            html: `
                                    <label style="text-align: left; for="#">Nombre:</label>
                                    <input id="usr" class="swal2-input" value="${usuario_asignado}"><br>
                                    <label style="text-align: left; for="#">Equipo:</label>
                                    <input id="equipo" class="swal2-input" value="${tipo_equipo}"><br>
                                    <label style="text-align: left; for="#">Modelo:</label>
                                    <input id="modelo" class="swal2-input" value="${modelo}"><br>
                                    <label style="text-align: left; for="#">Marca:</label>
                                    <input id="marca" class="swal2-input" value="${marca}"><br>
                                    <label style="text-align: left; for="#">No. Serie:</label>
                                    <input id="no_serie" class="swal2-input" value="${no_serie}"><br>
                                    <label style="text-align: left; for="#">Nom Host:</label>
                                    <input id="nom_host" class="swal2-input" value="${nom_host}"><br>
                                    <label style="text-align: left; for="#">Area:</label>
                                    <input id="departamento" class="swal2-input" value="${departamento}"><br>
                                    <select id="Nareainv" class="form-control">
                                        <option value=${estatus}>${estatuInvName[estatus]}</option>
                                    </select>
                                `,
                            didOpen: () => {
                                const select = document.getElementById("Nareainv");
                                var i = 0;
                                estatusInventario.forEach(area => {
                                    let option = document.createElement("option");
                                    option.value = area;
                                    option.textContent = estatuInvName[i];
                                    select.appendChild(option);
                                    i++;
                                });
                            },
                            preConfirm: () => {
                                return {
                                    id: id_inventario,
                                    usr: document.getElementById('usr').value,
                                    equipo: document.getElementById('equipo').value,
                                    modelo: document.getElementById('modelo').value,
                                    marca: document.getElementById('marca').value,
                                    no_serie: document.getElementById('no_serie').value,
                                    nom_host: document.getElementById('nom_host').value,
                                    departamento: document.getElementById('departamento').value,
                                    slect2: document.getElementById('Nareainv').value
                                };
                            }
                        })
                            .then((result) => {
                                if (result.isConfirmed) {
                                    const { id, usr, equipo, modelo, marca, no_serie, nom_host, departamento, slect2 } = result.value;
                                    //console.table(result.value);
                                    fetch('crud-calendar.php', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/x-www-form-urlencoded'
                                        },
                                        body: `action=updateInv&id=${id}&usu=${usr}&equipo=${equipo}&modelo=${modelo}&marca=${marca}&noSerie=${no_serie}&host=${nom_host}&depa=${departamento}&estatus=${slect2}`
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
                                    Swal.fire("Esatas seguro de dar de baja al usuario", "", "warning").then(result => {
                                        if (result.isConfirmed) {
                                            fetch('crud-calendar.php', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/x-www-form-urlencoded'
                                                },
                                                body: `action=deleteInv&id=${id_inventario}`
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
    /******************************FIN DEL BOTON */
    // Mover el handler de SweetAlert a un botón dedicado dentro de la tarjeta
    document.querySelectorAll('.update-consumibles').forEach((btn) => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const card = this.closest('.card1');
            if (!card) return;
            const ubicacion = card.getAttribute("data_ubicacion");
            const no_serie = card.getAttribute("data_no_serie");
            const modelo = card.getAttribute("data_modelo");
            const id_consumible = card.getAttribute("data_id_consumible");
            const nombre = card.getAttribute("data_nombre");
            const cantidad_disponible = card.getAttribute("data_cantidad_disponible");
            const id_impresora = card.getAttribute("data_id_impresora");

            Swal.fire({
                title: "¿Que deseas hacer?",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Agregar consumibles",
                denyButtonText: `Quitar consumibles`,
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Agregar consumibles',
                        input: 'number',
                        inputLabel: 'Cantidad a agregar',
                        inputPlaceholder: 'Ingresa la cantidad',
                        showCancelButton: true,
                        confirmButtonText: 'Agregar',
                        cancelButtonText: 'Cancelar',
                        inputAttributes: { min: 1 }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const cantidad = result.value;
                            fetch('crud-calendar.php', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                                body: `action=actualizarConsumibles&id_consumible=${id_consumible}&id_impresora=${id_impresora}&cantidad=${cantidad}&tipo=entrada`
                            }).then(response => response.json())
                                .then(data => {
                                    if (data.status === 'success') {
                                        Swal.fire("Consumibles agregados", "", "success").then(result => { if (result.isConfirmed) location.reload(); });
                                    } else {
                                        Swal.fire("Error", data.message, "error");
                                    }
                                });
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire({
                        title: 'Quitar consumibles',
                        input: 'number',
                        inputLabel: 'Cantidad a quitar',
                        inputPlaceholder: 'Ingresa la cantidad',
                        showCancelButton: true,
                        confirmButtonText: 'Quitar',
                        cancelButtonText: 'Cancelar',
                        inputAttributes: { min: 1 },
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const cantidad = result.value;
                            fetch('crud-calendar.php', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                                body: `action=actualizarConsumibles&id_consumible=${id_consumible}&id_impresora=${id_impresora}&cantidad=${cantidad}&tipo=salida`
                            }).then(response => response.json())
                                .then(data => {
                                    if (data.status === 'success') {
                                        Swal.fire("Consumibles quitados", "", "success").then(result => { if (result.isConfirmed) location.reload(); });
                                    } else {
                                        Swal.fire("Error", data.message, "error");
                                    }
                                });
                        }
                    });
                }
            });
        });
    });
});// fin del DOM