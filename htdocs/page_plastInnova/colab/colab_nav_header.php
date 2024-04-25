<?php
function renderNavbar($activePage) {
    ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <section class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link <?php echo ($activePage == 'colab_personal_page.php') ? 'active' : ''; ?>" href="colab_personal_page.php">Mi cuenta</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($activePage == 'colab_areas.php' || $activePage == 'colab_machines.php' || $activePage == 'colab_description_machine.php') ? 'active' : ''; ?>" href="colab_areas.php">Máquinas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($activePage == 'colab_collaborators.php') ? 'active' : ''; ?>" href="colab_collaborators.php">Colaboradores</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php echo ($activePage == 'tasks_colab_unassigned.php' || $activePage == 'tasks_colab.php' || $activePage == 'tasks_colab_completed.php' || $activePage == 'calendar_tasks.php') ? 'active' : ''; ?>" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Tareas
                </a>
                <section class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="tasks_colab_unassigned.php">Tareas sin asignar</a>
                    <a class="dropdown-item" href="tasks_colab.php">Tareas pendientes</a>
                    <a class="dropdown-item" href="tasks_colab_completed.php">Tareas completadas</a>
                    <a class="dropdown-item" href="../everyone/calendar_tasks.php">Calendario</a>
                </section>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($activePage == 'close_sesion.php') ? 'active' : ''; ?>" href="../php/close_sesion.php">Cerrar Sesión</a>
            </li>
        </ul>
    </section>
    <?php
}
?>
