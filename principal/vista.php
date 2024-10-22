<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laboratorio</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <style>
        .bg-marino {
            background-color: rgb(27, 57, 106) !important;
        }
    </style>
</head>

<body>
    <?php include '../includes/navbar.html'; ?>
    <div class="text-center py-2">
        <?php
        include '../BD/config.php';

        // Obtener el id del laboratorio de la URL
        $id_laboratorio = isset($_POST['id']) ? $_POST['id'] : 0;

        
        $stmt = $conn->prepare("SELECT l.*, c.Nombre AS carrera_nombre 
                                 FROM laboratorios l 
                                 JOIN carreras c ON l.Id_carrera = c.Id_carrera 
                                 WHERE l.Id_laboratorio = ?");
        $stmt->bind_param("s", $id_laboratorio); // Vincula el parámetro
        $stmt->execute();
        $laboratorio = $stmt->get_result()->fetch_assoc();

        if ($laboratorio) {
        ?>
            <h1><?php echo htmlspecialchars($laboratorio['carrera_nombre']); ?></h1>
            <h2 class="mt-3 mb-3"><?php echo htmlspecialchars($laboratorio['Nombre']); ?></h2>
        <?php
        } else {
            echo "<h1>No se encontró el laboratorio.</h1>";
        }
        ?>
    </div>

    <div class="container-fluid p-0 text-center py-3">
        <?php if ($laboratorio) { ?>
            <iframe src="<?php echo htmlspecialchars($laboratorio['Recorrido']); ?>" class="w-75" height="480" allow="xr-spatial-tracking"></iframe>
        <?php } ?>
    </div>

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-6">
                <div class="card text-bg bg-marino mb-3">
                    <div class="card-header text-white">Caracteristicas del laboratorio</div>
                    <div class="card-body">
                        <p class="card-text text-white"><?php echo htmlspecialchars($laboratorio['Info']); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-bg bg-marino mb-3">
                    <div class="card-header text-white">Prácticas Realizables</div>
                    <div class="card-body text-white">
                        <p class="card-text">
                            <?php
                            echo htmlspecialchars($laboratorio['Practicas']);
                            ?>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php
    // Cerrar conexiones
    $stmt->close();
    $conn->close();
    ?>
    <?php include '../includes/footer.html'; ?>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>