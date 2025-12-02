<?php
include 'header.php';
?>
<style>
    :root {
        --bg: #0f172a;
        /* slate-900 */
        --card: #111827;
        /* slate-800 */
        --muted: #94a3b8;
        /* slate-400 */
        --text: #e5e7eb;
        /* gray-200 */
        --accent: #22c55e;
        /* green-500 */
        --accent-600: #16a34a;
        /* green-600 */
        --ring: rgba(34, 197, 94, .45);
        --border: #1f2937;
        /* slate-700 */
        --danger: #ef4444;
        /* red-500 */
    }

    .card-1 {
        width: 100%;
        max-width: 1000px;
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.04), rgba(255, 255, 255, 0.02));
        border: 1px solid var(--border);
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
        overflow: hidden;
    }

    .card__header-1 {
        padding: 22px 24px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 12px;
        background: rgba(17, 24, 39, .65);
        backdrop-filter: blur(6px);
    }

    .card__title-1 {
        margin: 0;
        font-size: clamp(18px, 2vw, 22px);
        font-weight: 700;
        letter-spacing: .3px;
    }

    .card__subtitle-1 {
        margin-left: auto;
        font-size: 12px;
        color: var(--muted);
    }

    form.user-form-1 {
        padding: 22px;
        display: grid;
        gap: 18px;
    }

    .grid-1 {
        display: grid;
        gap: 16px;
        grid-template-columns: repeat(12, minmax(0, 1fr));
    }

    /* 2-column layout on md+, full width on mobile */
    .col-6 {
        grid-column: span 12;
    }

    @media (min-width: 760px) {
        .col-6 {
            grid-column: span 6;
        }
    }

    .field {
        display: grid;
        gap: 8px;
    }

    .label {
        font-size: 13px;
        color: var(--muted);
    }

    .control {
        position: relative;
    }

    input[type="text"],
    input[type="password"],
    select {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid var(--border);
        border-radius: 12px;
        background: #0b1220;
        color: var(--text);
        outline: none;
        transition: border-color .18s ease, box-shadow .18s ease, transform .06s ease;
    }

    input::placeholder {
        color: #64748b;
    }

    .field:focus-within input,
    .field:focus-within select {
        border-color: var(--text);
        box-shadow: 0 0 0 4px var(--text);
    }

    .hint {
        font-size: 12px;
        color: var(--muted);
    }

    .actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        border-top: 1px solid var(--border);
        padding-top: 16px;
        margin-top: 8px;
    }

    .btn {
        appearance: none;
        border: none;
        border-radius: 12px;
        padding: 12px 16px;
        font-weight: 600;
        cursor: pointer;
        transition: transform .06s ease, box-shadow .18s ease, background .18s ease;
    }

    .btn:active {
        transform: translateY(1px);
    }

    .btn--primary {
        background: linear-gradient(180deg, var(--accent), var(--accent-600));
        color: white;
        box-shadow: 0 8px 16px rgba(34, 197, 94, .25);
    }

    .btn--ghost {
        background: transparent;
        color: var(--text);
        border: 1px solid var(--border);
    }

    /* Small required asterisk */
    .req::after {
        content: " *";
        color: var(--danger);
    }

    /* Make password field and role select stand out slightly */
    .important input,
    .important select {
        background: linear-gradient(180deg, #0c1427, #0b1220);
    }

    .rol {
        color: black;
    }
</style>
<?php if (isset($_SESSION['mensaje']) && $_SESSION['mensaje'] != null): ?>
    <script>
        swal.fire({
            title: 'Éxito',
            text: '<?php echo $_SESSION['mensaje'] ?? '' ?>',
            icon: 'success',
            confirmButtonText: 'Aceptar'
        });
    </script>
<?php elseif (isset($_SESSION['mensaje']) && $_SESSION['mensaje'] == null): ?>
    <script>
        swal.fire({
            title: 'Error',
            text: 'No se pudo crear el usuario. Verifica que todos los campos requeridos estén completos.',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    </script>
<?php endif; ?>

<section class="card-1" role="region" aria-labelledby="titulo-form">
    <header class="card__header-1">
        <h1 class="card__title-1" id="titulo-form">Alta de Usuarios</h1>
        <p class="card__subtitle-1">Completa los campos requeridos</p>
    </header>
    <form class="user-form-1" action="newUsuario.php" method="post" autocomplete="off" novalidate>
        <div class="grid-1">
            <!-- Usuario -->
            <div class="field col-6">
                <label class="label req" for="usuario">Usuario</label>
                <div class="control">
                    <input id="usuario" name="usuario" type="text" placeholder="ej. amoreno" minlength="3" maxlength="32" pattern="[a-zA-Z0-9_.-]+" title="Solo letras, números y . _ -" required autocomplete="off" />
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
            
            <div class="field col-6 important">
                <label class="label req" for="sexo">Sexo</label>
                <div class="control">
                    <select id="sexo" name="sexo" required>
                        <option value="" disabled selected>Selecciona un sexo</option>
                        <option class="rol" value="M">Masculino</option>
                        <option class="rol" value="F">Femenino</option>
                    </select>
                </div>
                <small class="hint">Define los permisos del usuario en el sistema.</small>
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
                        <option class="rol" value="1">Administrador</option>
                        <option class="rol" value="2">Usuario</option>
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