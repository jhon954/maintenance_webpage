<?php
function renderNavbar($session_id) {
    ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <section class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo ($session_id=='admin'?'../admin/admin_personal_page.php':'../colab/colab_personal_page.php')?>">Mi cuenta</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo ($session_id=='admin'?"../admin/admin_areas.php":"../colab/colab_areas.php")?>">Máquinas</a>
            </li>
            <li class="nav-item">
                    <a class="nav-link" href="<?php echo ($session_id=='admin'?"../admin/admin_collaborators.php":"../colab/colab_collaborators.php")?>">Colaboradores</a>
            </li>
            <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Tareas
                </a>
                <section class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="<?php echo ($session_id=='admin'?"../admin/tasks_admin_unassigned.php":"../colab/tasks_colab_unassigned.php")?>">Tareas sin asignar</a>
                    <a class="dropdown-item" href="<?php echo ($session_id=='admin'?"../admin/tasks_admin.php":"../colab/tasks_colab.php")?>">Tareas pendientes</a>
                    <a class="dropdown-item" href="<?php echo ($session_id=='admin'?"../admin/tasks_completed_admin.php":"../colab/tasks_colab_completed.php")?>">Tareas completadas</a>
                    <a class="dropdown-item" href="<?php echo ($session_id=='admin'?"calendar_tasks.php":"calendar_tasks.php")?>">Calendario</a>
                </section>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="../php/close_sesion.php">Cerrar Sesión</a>
            </li>
        </ul>
    </section>
    <?php
}
?>