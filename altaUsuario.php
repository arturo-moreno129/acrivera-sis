<?php
include 'header.php';
?>
<section class="card-1" role="region" aria-labelledby="titulo-form">
    <header class="card__header-1">
        <h1 class="card__title-1" id="titulo-form">Alta de Usuarios</h1>
        <p class="card__subtitle-1">Completa los campos requeridos</p>
    </header>
    <form class="user-form-1" action="#" method="post" autocomplete="off">
        <div class="grid-1">
            <!-- Usuario -->
            <div class="field col-6">
                <label class="label req" for="usuario">Usuario</label>
                <div class="control">
                    <input id="usuario" name="usuario" type="text" placeholder="ej. amoreno" minlength="3" maxlength="32" pattern="[a-zA-Z0-9_.-]+" title="Solo letras, números y . _ -" required />
                </div>
                <small class="hint">De 3 a 32 caracteres. Sin espacios.</small>
            </div>

            <!-- Nombre -->
            <div class="field col-6">
                <label class="label req" for="nombre">Nombre</label>
                <div class="control">
                    <input id="nombre" name="nombre" type="text" placeholder="Nombre" required />
                </div>
            </div>

            <!-- Apellido Paterno -->
            <div class="field col-6">
                <label class="label req" for="ap_paterno">Apellido paterno</label>
                <div class="control">
                    <input id="ap_paterno" name="apellido_paterno" type="text" placeholder="Apellido paterno" required />
                </div>
            </div>

            <!-- Apellido Materno -->
            <div class="field col-6">
                <label class="label" for="ap_materno">Apellido materno</label>
                <div class="control">
                    <input id="ap_materno" name="apellido_materno" type="text" placeholder="Apellido materno" />
                </div>
            </div>

            <!-- Puesto -->
            <div class="field col-6">
                <label class="label req" for="puesto">Puesto</label>
                <div class="control">
                    <input id="puesto" name="puesto" type="text" placeholder="ej. Analista, Ventas" required />
                </div>
            </div>

            <!-- Departamento -->
            <div class="field col-6">
                <label class="label req" for="departamento">Departamento</label>
                <div class="control">
                    <input id="departamento" name="departamento" type="text" placeholder="ej. TI, Finanzas, Compras" required />
                </div>
            </div>

            <!-- Contraseña -->
            <div class="field col-6 important">
                <label class="label req" for="password">Contraseña</label>
                <div class="control">
                    <input id="password" name="contrasena" type="password" placeholder="Mínimo 8 caracteres" minlength="8" required />
                </div>
                <small class="hint">Usa al menos 8 caracteres. Recomendado: mayúsculas, minúsculas y números.</small>
            </div>

            <!-- Rol -->
            <div class="field col-6 important">
                <label class="label req" for="rol">Rol</label>
                <div class="control">
                    <select id="rol" name="rol" required>
                        <option value="" disabled selected>Selecciona un rol</option>
                        <option value="admin">Administrador</option>
                        <option value="editor">Editor</option>
                        <option value="usuario">Usuario</option>
                    </select>
                </div>
                <small class="hint">Define los permisos del usuario en el sistema.</small>
            </div>
        </div>

        <div class="actions">
            <button type="reset" class="btn btn--ghost">Limpiar</button>
            <button type="submit" class="btn btn--primary" id="btnNewuser">Guardar usuario</button>
        </div>
    </form>
</section>
<?php
include 'footer.php';
?>