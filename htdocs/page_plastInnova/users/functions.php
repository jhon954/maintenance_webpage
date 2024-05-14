<?php
function generateCreateTaskModalHTML($id_machine, $area_id){
    $modal_create_taskHTML = <<<HTML
        <section class="modal fade" id="modal_reservas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <section class="modal-dialog">
            <section class="modal-content">
                <section class="modal-header">
                <h3 class="modal-title fs-5" id="exampleModalLabel">Programar mantenimiento</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </section>
                <section class="modal-body">
                <!-- Aquí irá el formulario -->
                <form id="maintenance_form" action="../php/create_task_user.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_machine" value="$id_machine">
                    <input type="hidden" name="area" value="$area_id">
                    <section class="form-group">
                    <label for="maintenance_date">Fecha de Mantenimiento:</label>
                    <input type="text" class="form-control" id="maintenance_date" name="maintenance_date" required readonly>
                    </section>
                    <section class="form-group">
                    <label for="maintenance_type">Tipo de mantenimiento:</label>
                    <select class="form-control" id="maintenance_type" name="maintenance_type" required>
                        <option value="" disabled selected>Seleccione tipo de mantenimiento</option>
                        <option value="preventive">Preventivo</option>
                        <option value="corrective">Correctivo</option>
                        <option value="calibration">Calibración</option>
                        <option value="other">Otro</option>
                    </select>
                    </section>
                    <section class="form-group">
                    <label for="description">Descripción del Problema:</label>
                    <textarea class="form-control" id="description" name="description" rows="2" required></textarea>
                    </section>
                    <section class="form-group">
                    <label for="priority">Prioridad:</label>
                    <select class="form-control" id="priority" name="priority" required>
                        <option value="high">Alta</option>
                        <option value="medium">Media</option>
                        <option value="low" selected>Baja</option>
                    </select>
                    </section>
                    <section class="form-group">
                    <label for="images_task">Imágenes:</label>
                    <input type="file" class="form-control-file" id="images_task" name="images_task[]" accept="image/*" multiple>
                    </section>
                    <button type="submit" class="btn btn-primary btn-block">Enviar Solicitud</button>
                </form>
                </section>
            </section>
            </section>
        </section>
    HTML;
    return ['modal_create_task'=> $modal_create_taskHTML];
}
