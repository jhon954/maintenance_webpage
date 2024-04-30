<?php
    function generateAreaHTML($area, $num_machines){
        $encodedArea = urlencode($area);
        $modalId = "editAreaModal$area";

        // HTML del área
        $areaHTML = <<<HTML
            <section class="col-md-4">
                <section class="card my-3">
                    <section class="card-body">
                        <h3 class="card-title-area">$area</h3>
                        <p class="card-text">Máquinas: $num_machines</p>
                        <a href="admin_machines.php?area=$encodedArea" class="button-blue">Ver Máquinas</a>
                        <button type="button" class="button-red" data-toggle="modal" data-target="#$modalId">Editar Área</button>
                    </section>
                </section>
            </section>
        HTML;

        // HTML del modal edit
        $modal_edit_areaHTML = <<<HTML
            <section class="modal fade" id="$modalId" tabindex="-1" role="dialog" aria-labelledby="editAreaModalLabel$area" aria-hidden="true">
                <section class="modal-dialog" role="document">
                    <section class="modal-content">
                        <section class="modal-header" id="modal_header">
                            <h4 class="modal-title" id="editAreaModalLabel$area">Editar Área: <strong><em>$area</em></strong></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </section>
                        <section class="modal-body">
                            <form action="../php/edit_area.php" method="post">
                                <section class="form-group" >
                                    <label for="new_area_id">Nuevo Nombre del Área</label>
                                    <input type="text" class="form-control" id="new_area_id" name="new_area_id" required>
                                    <input type="hidden" name="old_area_id" value="$area">
                                </section>
                                <button type="submit" class="button-red">Guardar Cambios</button>
                            </form>
                        </section>
                    </section>
                </section>
            </section>
        HTML;

        $modal_add_areaHTML = <<<HTML
            <!-- Modal para agregar nueva área -->
            <section class="modal fade" id="addAreaModal" tabindex="-1" role="dialog" aria-labelledby="addAreaModalLabel" aria-hidden="true">
                <section class="modal-dialog" role="document">
                    <section class="modal-content">
                        <section class="modal-header" id="modal_header">
                            <h4 class="modal-title" id="addAreaModalLabel">Agregar Nueva Área</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </section>
                        <section class="modal-body">
                            <form action="../php/add_area.php" method="post">
                                <section class="form-group">
                                    <label for="newAreaName">Nombre del Área</label>
                                    <input type="text" class="form-control" id="newAreaName" name="newAreaName" required>
                                </section>
                                <button type="submit" class="button-red">Agregar</button>
                            </form>
                        </section>
                    </section>
                </section>
            </section>
        HTML;

        return ['areaHTML' => $areaHTML, 'modalEditHTML' => $modal_edit_areaHTML,
                'modalAddHTML'=>$modal_add_areaHTML];
    }
    function generateCollaboratosModalHTML(){
        $modal_add_collaboratorHTML = <<<HTML
            <section class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                <section class="modal-dialog" role="document">
                    <section class="modal-content">
                        <section class="modal-header">
                            <h5 class="modal-title" id="addModalLabel">Agregar Colaborador</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </section>
                        <section class="modal-body">
                            <form action=" ../php/add_collaborator.php" method="post">
                                <section class="form-group">
                                    <label for="name_add">Nombre:</label>
                                    <input type="text" class="form-control" id="name_add" name="name_add" placeholder="Nombre">
                                </section>
                                <section class="form-group">
                                    <label for="surname_add">Apellido:</label>
                                    <input type="text" class="form-control" id="surname_add" name="surname_add" placeholder="Apellido">
                                </section>
                                <section class="form-group">
                                    <label for="job_title_add">Título:</label>
                                    <input type="text" class="form-control" id="job_title_add" name="job_title_add" placeholder="Título">
                                </section>
                                <section class="form-group">
                                    <label for="state_add">Estado:</label>
                                    <select class="form-control" id="state_add" name="state_add">
                                        <option value="active">Activo</option>
                                        <option value="inactive">Inactivo</option>
                                        <option value="retired">Retirado</option>
                                    </select>
                                </section>
                                <section class="form-group">
                                    <label for="password_add">Contraseña:</label>
                                    <input type="password" class="form-control" id="password_add" name="password_add" placeholder="Contraseña">
                                </section>
                                <section class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                </section>
                            </form>
                        </section>
                    </section>
                </section>
            </section>
        HTML;

        $modal_edit_collaboratorHTML = <<<HTML
            <section class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                <section class="modal-dialog" role="document">
                    <section class="modal-content">
                        <section class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Editar Colaborador</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </section>
                        <section class="modal-body">
                            <form action=" ../php/edit_collaborator.php" method="post">
                                <input type="hidden" id="id_collaborator" name="id_collaborator"> <!-- Campo de entrada oculto para el ID del colaborador -->
                                <section class="form-group">
                                    <label for="name">Nombre:</label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </section>
                                <section class="form-group">
                                    <label for="surname">Apellido:</label>
                                    <input type="text" class="form-control" id="surname" name="surname">
                                </section>
                                <section class="form-group">
                                    <label for="job_title">Título:</label>
                                    <input type="text" class="form-control" id="job_title" name="job_title">
                                </section>
                                <section class="form-group">
                                    <label for="state">Estado:</label>
                                    <select class="form-control" id="state" name="state">
                                        <option value="active">Activo</option>
                                        <option value="inactive">Inactivo</option>
                                        <option value="retired">Retirado</option>
                                    </select>
                                </section>
                                <section class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                </section>
                            </form>
                        </section>
                    </section>
                </section>
            </section>
        HTML;
        $modal_edit_password_collaboratorHTML = <<<HTML
        <section class="modal fade" id="editPasswordModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <section class="modal-dialog" role="document">
                <section class="modal-content">
                    <section class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Editar Colaborador</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </section>
                    <section class="modal-body">
                        <form action=" ../php/edit_password_collaborator.php" method="post">
                            <input type="hidden" id="id_collaborator_password" name="id_collaborator_password"> <!-- Campo de entrada oculto para el ID del colaborador -->
                            <section class="form-group">
                                <label for="password">Nueva contraseña:</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
                            </section>
                            <section class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                            </section>
                        </form>
                    </section>
                </section>
            </section>
        </section>
    HTML;
        return [
            'modal_add_collaborator' => $modal_add_collaboratorHTML, 
            'modal_edit_collaborator' => $modal_edit_collaboratorHTML,
            'modal_edit_password_collaborator'=> $modal_edit_password_collaboratorHTML
        ];
    }
    function generateCreateTaskModalHTML($id_machine, $area_id){
        $modal_create_taskHTML = <<<HTML
            <div class="modal fade" id="modal_reservas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Programar mantenimiento</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                    <!-- Aquí irá el formulario -->
                    <form id="maintenance_form" action="../php/create_task.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_machine" value="$id_machine">
                        <input type="hidden" name="area" value="$area_id">
                        <div class="form-group">
                        <label for="maintenance_date">Fecha de Mantenimiento:</label>
                        <input type="text" class="form-control" id="maintenance_date" name="maintenance_date" required readonly>
                        </div>
                        <div class="form-group">
                        <label for="maintenance_type">Tipo de mantenimiento:</label>
                        <select class="form-control" id="maintenance_type" name="maintenance_type" required>
                            <option value="" disabled selected>Seleccione tipo de mantenimiento</option>
                            <option value="preventive">Preventivo</option>
                            <option value="corrective">Correctivo</option>
                            <option value="calibration">Calibración</option>
                            <option value="other">Otro</option>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="description">Descripción del Problema:</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                        <label for="priority">Prioridad:</label>
                        <select class="form-control" id="priority" name="priority" required>
                            <option value="high">Alta</option>
                            <option value="medium">Media</option>
                            <option value="low" selected>Baja</option>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="images_task">Imágenes:</label>
                        <input type="file" class="form-control-file" id="images_task" name="images_task[]" accept="image/*" multiple>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Enviar Solicitud</button>
                    </form>
                    </div>
                </div>
                </div>
            </div>
        HTML;
        return ['modal_create_task'=> $modal_create_taskHTML];
    }
    function createMachineImageDirectory($machine_id, $machine_data){
    $img_dir_machine = "../img/machines/machineid{$machine_id}";
    if (!is_dir($img_dir_machine)) {
        mkdir($img_dir_machine, 0777, true); // 0777 permite todos los permisos
    }
    $directory_content = scandir($img_dir_machine);
    $directory_content = array_diff($directory_content, array('.', '..'));

    return [
        'directory_exists' => (!empty($machine_data['image_path']) && !empty($directory_content)),
        'directory_path' => $img_dir_machine
    ];
    }
    function CreateMachineModal($area){
        $modal_create_machineHTML = <<<HTML
             <!-- Modal -->
            <section class="modal fade" id="addMachineModal" tabindex="-1" role="dialog" aria-labelledby="addMachineModalLabel" aria-hidden="true">
                <section class="modal-dialog" role="document">
                    <section class="modal-content">
                        <section class="modal-header">
                            <h5 class="modal-title" id="addMachineModalLabel">Agregar Nueva Área</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </section>
                        <section class="modal-body">
                            <!-- Formulario para agregar nueva área -->
                            <form action="../php/add_machine.php" method="post">
                            <input type="hidden" name="area_id" value="$area">
                            <section class="form-group">
                                <label for="state_machine">Estado de la máquina:</label>
                                <select class="form-control" id="state_machine" name="state_machine">
                                    <option value="active">Activa</option>
                                    <option value="inactive">Inactiva</option>
                                </select>
                            </section>
                            <section class="form-group">
                                <label for="machine_number">Número máquina:</label>
                                <input type="text" class="form-control" id="machine_number" name="machine_number">
                            </section>
                            <section class="form-group">
                                <label for="brand">Marca:</label>
                                <input type="text" class="form-control" id="brand" name="brand">
                            </section>
                            <section class="form-group">
                                <label for="model">Modelo:</label>
                                <input type="text" class="form-control" id="model" name="model">
                            </section>
                            <section class="form-group">
                                <label for="serial_number">Número de Serie:</label>
                                <input type="text" class="form-control" id="serial_number" name="serial_number">
                            </section>
                            <section class="form-group">
                                <label for="description">Descripción:</label>
                                <input type="text" class="form-control" id="description" rows="4" name="description">
                            </section>
                            <section class="form-group">
                                <label for="datasheet">URL de los datos técnicos:</label>
                                <input type="text" class="form-control" id="datasheet" name="datasheet">
                            </section>
                                <button type="submit" class="btn btn-primary">Agregar</button>
                            </form>
                        </section>
                    </section>
                </section>
            </section>
        HTML;
        return $modal_create_machineHTML;
    }
    function generateAreaHTMLWithoutMachines(){
        // $encodedArea = urlencode($area);
        // $modalId = "editAreaModal$area";

        // HTML del área
        $areaHTML = <<<HTML
            <section class="col-md-4">
                <section class="card mb-3">
                    <section class="card-body">
                        <h5 class="card-title">No hay áreas</h5>
                    </section>
                </section>
            </section>
        HTML;

        $modal_add_areaHTML = <<<HTML
            <!-- Modal para agregar nueva área -->
            <section class="modal fade" id="addAreaModal" tabindex="-1" role="dialog" aria-labelledby="addAreaModalLabel" aria-hidden="true">
                <section class="modal-dialog" role="document">
                    <section class="modal-content">
                        <section class="modal-header">
                            <h5 class="modal-title" id="addAreaModalLabel">Agregar Nueva Área</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </section>
                        <section class="modal-body">
                            <form action="../php/add_area.php" method="post">
                                <section class="form-group">
                                    <label for="newAreaName">Nombre del Área:</label>
                                    <input type="text" class="form-control" id="newAreaName" name="newAreaName" required>
                                </section>
                                <button type="submit" class="button-red">Agregar</button>
                            </form>
                        </section>
                    </section>
                </section>
            </section>
        HTML;

        return ['areaHTML' => $areaHTML,
                'modalAddHTML'=>$modal_add_areaHTML];
    }