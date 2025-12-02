<?php
//session_start();

// Verificar que exista la sesión
if (!isset($_SESSION['ususario'])) {
    header("Location: index");
    exit();
}

// Verificar que sea administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: index");
    exit();
}

include("header.php");
?>

<div class="users-container">
    <h2 class="users-title">Usuarios Registrados</h2>

    <table class="users-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Rol</th>
                <th>Puesto</th>
                <th>Acciones</th>
                <th>Estatus</th>
            </tr>
        </thead>

        <tbody id="users-body">
            <!-- Ejemplo de usuario (esto luego lo llenas con PHP o JS) -->
            <?php
            // Aquí iría el código PHP para obtener y mostrar los usuarios desde la base de datos
            $query = "SELECT id_usuario,usuario, nombre,apellidoP,apellidoM,puesto, rol,sexo, estatus FROM usuario order by rol asc";
            $result = mysqli_query($con, $query);
            while ($row = mysqli_fetch_assoc($result)) {

                // Construir acciones según estatus
                if ($row['estatus'] == 'Activo') {
                    $acciones = "
            <button value='" . $row['id_usuario'] . "' class='btn-edit'>Editar</button>
            <button value='" . $row['id_usuario'] . "' class='btn-delete'>Eliminar</button>
        ";
                } else {
                    $acciones = "
            <button value='" . $row['id_usuario'] . "' class='btn-activar'>Activar usuario</button>
        ";
                }

                echo "<tr>
        <td>" . $row['id_usuario'] . "</td>
        <td>" . $row['nombre'] . " " . $row['apellidoP'] . " " . $row['apellidoM'] . "</td>
        <td>" . $row['usuario'] . "</td>
        <td>" . ($row['rol'] == 1 ? "Administrador" : "Usuario") . "</td>
        <td>" . $row['puesto'] . "</td>

        <td>$acciones</td>

        <td>" .
                    ($row['estatus'] == 'Activo'
                        ? "<img style='width:35px;' src='imagenes/chek.png'>"
                        : "<img style='width:35px;' src='imagenes/error.png'>"
                    ) .
                    "</td>
    </tr>";
            }

            ?>
        </tbody>
    </table>
</div>
<style>
    .users-container {
        width: 100%;
        padding: 20px;
        background: transparent;
    }

    .users-title {
        font-size: 26px;
        font-weight: 600;
        margin-bottom: 20px;
        color: #fff;
    }

    .users-table {
        width: 100%;
        border-collapse: collapse;
        overflow: hidden;
        border-radius: 12px;
        background: #ffffff10;
        backdrop-filter: blur(6px);
        color: #fff;
    }

    .users-table thead {
        background: #ffffff20;
    }

    .users-table th,
    .users-table td {
        padding: 14px 16px;
        text-align: left;
        font-size: 15px;
    }

    .users-table tbody tr {
        transition: background 0.2s;
    }

    .users-table tbody tr:hover {
        background: #ffffff15;
    }

    /* Botones */
    .btn-activar,
    .btn-edit,
    .btn-delete {
        border: none;
        padding: 8px 14px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        transition: 0.2s;
    }

    .btn-edit {
        background: #4CAF50;
        color: white;
    }

    .btn-edit:hover {
        background: #43a047;
    }

    .btn-delete {
        background: #E53935;
        color: white;
    }

    .btn-delete:hover {
        background: #c62828;
    }
    .btn-activar {
        background: #4c6eddff;
        color: white;
    }

    .btn-activar:hover {
        background: #4c6eddff;
    }

    /* Responsive */
    @media (max-width: 700px) {
        .users-table thead {
            display: none;
        }

        .users-table tr {
            display: block;
            margin-bottom: 15px;
            background: #ffffff10;
            border-radius: 10px;
            padding: 10px;
        }

        .users-table td {
            display: flex;
            justify-content: space-between;
            padding: 10px 5px;
        }

        .users-table td::before {
            content: attr(data-label);
            font-weight: bold;
            color: #ddd;
        }
    }

    .texto-derecha {
        text-align: right !important;
    }
</style>
<script>
    /********************edicion de usuario*************** */
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', () => { //es una funcion callback ya que lleva los parentisis Dentro de una función flecha () => {}, this NO apunta al botón, por eso siempre regresa undefined por eso se cambia this.getAttribute por button.getAttribute
            const idButton = button.getAttribute("value");
            console.log('Editar usuario' + idButton);
            fetch('crud-calendar.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `action=obtnerUsuarioPorId&id_usuario=${idButton}`

                }).then(response => response.json())
                .then(data => {
                    console.table(data.message[0]);
                    // Aquí puedes usar los datos obtenidos para llenar el formulario de edición
                    const {
                        id_usuario,
                        usuario,
                        nombre,
                        apellidoP,
                        apellidoM,
                        sexo,
                        puesto,
                        departamento,
                        contrasena,
                        rol
                    } = data.message[0];
                    Swal.fire({
                        title: "Editar Usuario ",
                        confirmButtonText: "Actualizar",
                        html: `
                    <label for="swal-input1">ID Usuario:</label><input id="swal-input1" class="swal2-input" value='${id_usuario}' disabled><br>
                    <label for="swal-input1">Usuario:</label><input id='usuario' class="swal2-input" value='${usuario}'><br>
                    <label for="swal-input1">Nombre:</label><input id='nombre' class="swal2-input" value='${nombre}'><br>
                    <label for="swal-input1">Apellido Paterno:</label><input id='apellidoP' class="swal2-input" value='${apellidoP}'><br>
                    <label for="swal-input1">Apellido Materno:</label><input id='apellidoM' class="swal2-input" value='${apellidoM}'><br>
                    <label for="swal-input1">Puesto:</label><input id='puesto' class="swal2-input" value='${puesto}'><br>
                    <label for="swal-input1">Departamento:</label><input id='departamento' class="swal2-input" value='${departamento}'><br>
                    <label for="swal-input1">Sexo:</label>
                    <select id="sexo" class="swal2-input" style="width: 40%; padding: 10px; margin-top: 5px;">
                        <option value="M" ${sexo == 'M' ? 'selected' : ''}>Masculino</option>
                        <option value="F" ${sexo == 'F' ? 'selected' : ''}>Femenino</option>
                    </select>
                    <label for="swal-input1">Rol:</label>
                    <select id="rol" class="swal2-input" style="width: 40%; padding: 10px; margin-top: 5px;">
                        <option value="1" ${rol == 1 ? 'selected' : ''}>Administrador</option>
                        <option value="2" ${rol == 2 ? 'selected' : ''}>Usuario</option>
                    </select>
                    <br>
                `,
                        width: '650px',
                        customClass: {
                            htmlContainer: 'texto-derecha'
                        },
                        focusConfirm: false,

                        preConfirm: () => {
                            return {
                                id: id_usuario,
                                usuario: document.getElementById('usuario').value,
                                nombre: document.getElementById('nombre').value,
                                apellidoP: document.getElementById('apellidoP').value,
                                apellidoM: document.getElementById('apellidoM').value,
                                sexo: document.getElementById('sexo').value,
                                puesto: document.getElementById('puesto').value,
                                departamento: document.getElementById('departamento').value,
                                rol: document.getElementById('rol').value
                            };
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const updatedData = result.value;
                            console.table(updatedData);
                            // Aquí puedes enviar los datos actualizados al servidor para guardarlos
                            fetch('crud-calendar.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded'
                                    },
                                    body: `action=actualizarUsuario&id_usuario=${updatedData.id}&usuario=${updatedData.usuario}&nombre=${updatedData.nombre}&apellidoP=${updatedData.apellidoP}&apellidoM=${updatedData.apellidoM}&sexo=${updatedData.sexo}&puesto=${updatedData.puesto}&departamento=${updatedData.departamento}&rol=${updatedData.rol}`
                                }).then(response => response.json())
                                .then(data => {
                                    console.log(data);
                                    if (data.status === 'success') {
                                        Swal.fire('Éxito', 'Usuario actualizado correctamente', 'success').then(() => {
                                            location.reload(); // Recargar la página para ver los cambios
                                        });
                                    } else {
                                        Swal.fire('Error', data.message, 'error');
                                    }
                                }).catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire('Error', 'Hubo un error al actualizar el usuario', 'error');
                                });
                        }
                    });
                }).catch(error => {
                    console.error('Error:', error);
                });
        });
    });
    /*********************Eliminacion de usuario   ***********/
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', () => {
            const idButton = button.getAttribute("value");
            console.log('Eliminar usuario' + idButton);
            // Aquí puedes agregar la lógica para eliminar el usuario
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Lógica para eliminar el usuario
                    fetch('crud-calendar.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `action=eliminarUsuario&id_usuario=${idButton}&estatus=Baja`
                        }).then(response => response.json())
                        .then(data => {
                            console.log(data);
                            if (data.status === 'success') {
                                Swal.fire('Eliminado', 'El usuario ha sido eliminado.', 'success').then(() => {
                                    location.reload(); // Recargar la página para ver los cambios
                                });
                            } else {
                                Swal.fire('Error', data.message, 'error');
                            }
                        }).catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Error', data.message, 'error');
                        });
                }
            });
        });
    });
    document.querySelectorAll('.btn-activar').forEach(button => {
        button.addEventListener('click', () => {
            const idButton = button.getAttribute("value");
            console.log('Activar usuario' + idButton);
            // Aquí puedes agregar la lógica para activar el usuario
            fetch('crud-calendar.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `action=eliminarUsuario&id_usuario=${idButton}&estatus=Activo`
                }).then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.status === 'success') {
                        Swal.fire('Activado', 'El usuario ha sido activado.', 'success').then(() => {
                            location.reload(); // Recargar la página para ver los cambios
                        });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                }).catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', data.message, 'error');
                });
        });
    });
</script>
<?php
include 'footer.php'
?>