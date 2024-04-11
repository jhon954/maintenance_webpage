<?php
    include("../php/connect.php");

    $query = "SELECT * FROM areas";
    $result = $conn->query($query);
    $areas = array();
    while ($row = $result->fetch_assoc()) {
        $areas[] = $row['area_name'];
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
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Solicitud de Mantenimiento</h3>
                    </div>
                    <div class="card-body">
                        <form action="php/create_task.php" method="POST">
                            <div class="form-group">
                                <label for="area">Área:</label>
                                <select class="form-control" id="area" name="area" required>
                                    <?php foreach ($areas as $area): ?>
                                        <option value="<?php echo $area; ?>"><?php echo $area; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description">Descripción del Problema:</label>
                                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="importance">Urgencia:</label>
                                <select class="form-control" id="importance" name="importance" required>
                                    <option value="urgente">Urgente</option>
                                    <option value="no urgente">No Urgente</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Enviar Solicitud</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<script>
        // Script para actualizar el menú de máquinas cuando se selecciona un área
        $(document).ready(function(){
            $('#area').change(function(){
                var area_id = $(this).val();
                var machines = <?php echo json_encode($areas1); ?>;
                var machine_options = '<option value="">Seleccione una máquina</option>';
                for (var i = 0; i < machines[area_id]['machines'].length; i++) {
                    machine_options += '<option value="' + machines[area_id]['machines'][i] + '">' + machines[area_id]['machines'][i] + '</option>';
                }
                $('#machine').html(machine_options);
                $('#machine').prop('disabled', false);
            });
        });
    </script>