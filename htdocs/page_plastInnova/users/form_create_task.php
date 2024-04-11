<?php
    include("../php/connect.php");

    // Crear arrays para almacenar áreas y máquinas
    $areas1 = array();
    $machines1 = array();

    // Ejecutar la consulta
    $query1 = "SELECT areas.id AS area_id, machines.* FROM areas
                JOIN machines ON areas.id = machines.id_area";
    $result1 = $conn->query($query1);

    // Recorrer los resultados y almacenarlos en los arrays correspondientes
    while ($row1 = $result1->fetch_assoc()) {
        $area_id = $row1['area_id']; 
        
        // Agregar el área al array de áreas si aún no está presente
        if (!isset($areas1[$area_id])) {
            $areas1[$area_id] = array(
                'id' => $area_id, // Suponiendo que el nombre del área está en la columna 'id'
                'machines' => array() // Inicializar un array para almacenar las máquinas de esta área
            );
        }

        $machine_data = array(
            'id' => $row1['id'], // ID de la máquina
            'model' => $row1['model'] // Modelo de la máquina
        );
        
        $areas1[$area_id]['machines'][] = $machine_data;
    }
    $conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de Mantenimiento</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <section class="container mt-5">
        <section class="row justify-content-center">
            <section class="col-md-6">
                <section class="card">
                    <section class="card-header">
                        <h3 class="text-center">Solicitud de Mantenimiento</h3>
                    </section>
                    <section class="card-body">
                        <form action="../php/create_task.php" method="POST" enctype="multipart/form-data">
                            <section class="form-group">
                                <label for="area">Área:</label>
                                <select class="form-control" id="area" name="area" required>
                                    <option value="" disabled selected>Seleccione un área</option>
                                    <?php foreach ($areas1 as $area): ?>
                                        <option value="<?php echo $area['id']; ?>"><?php echo $area['id']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </section>
                            <section class="form-group">
                                <label for="machine">Máquina:</label>
                                <select class="form-control" id="machine" name="machine" required disabled>
                                    <option value="">Seleccione un área primero</option>
                                </select>
                            </section>
                            <section class="form-group">
                                <label for="description">Descripción del Problema:</label>
                                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                            </section>
                            <section class="form-group">
                                <label for="importance">Urgencia:</label>
                                <select class="form-control" id="importance" name="importance" required>
                                    <option value="urgente">Urgente</option>
                                    <option value="no urgente">No Urgente</option>
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
    </section>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script>
    // Script para actualizar el menú de máquinas cuando se selecciona un área
    $(document).ready(function(){
        $('#area').change(function(){
            var area_id = $(this).val();
            var machines = <?php echo json_encode($areas1); ?>;
            var machine_options = '<option value="">Seleccione una máquina</option>';
            for (var i = 0; i < machines[area_id]['machines'].length; i++) {
                var machine_id = machines[area_id]['machines'][i]['id'];
                var machine_model = machines[area_id]['machines'][i]['model'];
                machine_options += '<option value="' + machine_id + '">' + machine_model + '</option>';
            }
            $('#machine').html(machine_options);
            $('#machine').prop('disabled', false);
        });
    });
</script>


</body>
</html>
