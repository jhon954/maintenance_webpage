<?php function renderNavbar($activePage) { ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <section class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link <?php echo ($activePage == 'admin_personal_page.php') ? 'active' : ''; ?>" href="admin_personal_page.php">Mi cuenta</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($activePage == 'admin_areas.php' || $activePage == 'admin_machines.php' || $activePage == 'admin_description_machine.php') ? 'active' : ''; ?>" href="admin_areas.php">Máquinas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($activePage == 'admin_collaborators.php') ? 'active' : ''; ?>" href="admin_collaborators.php">Colaboradores</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Tareas
                </a>
                <section class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="tasks_admin_unassigned.php">Tareas sin asignar</a>
                    <a class="dropdown-item" href="tasks_admin.php">Tareas pendientes</a>
                    <a class="dropdown-item" href="tasks_completed_admin.php">Tareas completadas</a>
                    <a class="dropdown-item" href="../everyone/calendar_tasks.php">Calendario</a>
                </section>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($activePage == 'close_sesion.php') ? 'active' : ''; ?>" href="../php/close_sesion.php">Cerrar Sesión</a>
            </li>
        </ul>
    </section>
<?php } ?>
