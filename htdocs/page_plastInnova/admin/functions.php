<?php
    function generateAreaHTML($area, $num_machines){
        $encodedArea = urlencode($area);
        $modalId = "editAreaModal$area";

        // HTML del área
        $areaHTML = <<<HTML
            <section class="col-md-4">
                <section class="card mb-3">
                    <section class="card-body">
                        <h5 class="card-title">$area</h5>
                        <p class="card-text">Máquinas: $num_machines</p>
                        <a href="admin_machines.php?area=$encodedArea" class="btn btn-primary mr-2">Ver Máquinas</a>
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#$modalId">Editar Área</button>
                    </section>
                </section>
            </section>
        HTML;

        // HTML del modal edit
        $modal_edit_areaHTML = <<<HTML
            <section class="modal fade" id="$modalId" tabindex="-1" role="dialog" aria-labelledby="editAreaModalLabel$area" aria-hidden="true">
                <section class="modal-dialog" role="document">
                    <section class="modal-content">
                        <section class="modal-header">
                            <h5 class="modal-title" id="editAreaModalLabel$area">Editar Área $area</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </section>
                        <section class="modal-body">
                            <form action="../php/edit_area.php" method="post">
                                <section class="form-group">
                                    <label for="new_area_id">Nuevo Nombre del Área:</label>
                                    <input type="text" class="form-control" id="new_area_id" name="new_area_id" required>
                                    <input type="hidden" name="old_area_id" value="$area">
                                </section>
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
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
                                <button type="submit" class="btn btn-primary">Agregar</button>
                            </form>
                        </section>
                    </section>
                </section>
            </section>
        HTML;

        return ['areaHTML' => $areaHTML, 'modalEditHTML' => $modal_edit_areaHTML,
                'modalAddHTML'=>$modal_add_areaHTML];
    }