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
                    a.download = `directorio_actualizado.xlsx`;
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



});// fin del DOM