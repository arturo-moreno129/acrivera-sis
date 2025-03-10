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
                            showCancelButton: false,
                            confirmButtonText: "FINALIZAR",
                            denyButtonText: "CANCELAR",
                            html: `
                                    <label style="text-align: left; for="#">Personal:</label>
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

                                }
                            });
                    } else {
                        console.log("error de consulta", data.message)
                    }
                })

        });
    });
});