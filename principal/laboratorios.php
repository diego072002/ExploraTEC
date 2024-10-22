<?php
include '../BD/config.php';

$id_carrera = isset($_POST['id']) ? $_POST['id'] : 0;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <title>Laboratorios</title>
    <style>
        .contor {
            border-bottom: 2px solid;
        }

        .icon-lab {
            height: 150px;
            width: auto;
            /* Asegúrate de que la imagen mantenga su proporción */
        }

        .btn-marino {
            background-color: rgb(27, 57, 106) !important;
            font-weight: bold !important;
            text-decoration: none !important;
            color: white !important;
            padding: 10px 30px !important;
            border-radius: 15px !important;
            transition: background-color 0.3s, transform 0.3s !important;
            margin-top: 10px !important;
        }

        .btn-marino:hover {
            background-color: rgb(71, 132, 230) !important;
        }
    </style>
</head>

<body>
    <?php include '../includes/navbar.html'; ?>
    <div class="mb-5">
        <div class="text-center py-2">
            <?php
            $stmt = $conn->prepare("SELECT c.Nombre AS carrera_nombre 
                      FROM laboratorios l 
                      JOIN carreras c ON l.Id_carrera = c.Id_carrera 
                      WHERE c.Id_carrera = ?");
            $stmt->bind_param("s", $id_carrera);
            $stmt->execute();
            $laboratorio = $stmt->get_result()->fetch_assoc();

            if ($laboratorio) {
            ?>
                <h1 class="mb-5"><?php echo htmlspecialchars($laboratorio['carrera_nombre']); ?></h1>
                <?php
            } else {
            }

            $sql = "SELECT Id_laboratorio, Nombre, Icono FROM laboratorios WHERE Id_carrera = ?";
            $lab_stmt = $conn->prepare($sql);
            $lab_stmt->bind_param("s", $id_carrera);
            $lab_stmt->execute();
            $result = $lab_stmt->get_result();

            if ($result->num_rows > 0) {
                echo '<div class="row mx-3 justify-content-center">'; // Centra las tarjetas
                while ($row = $result->fetch_assoc()) {
                ?>
                    <div class="col-auto"> <!-- Cambia 'col' a 'col-auto' para ajustar el tamaño -->
                        <div class="card border-dark mb-4 shadow-sm">
                            <div class="card-body text-center">
                                <div class="pb-3 contor align-items-center">
                                    <img src="iconos/<?= htmlspecialchars($row['Icono']) ?>" alt="icono" class="icon-lab">
                                    <h5 class="card-title mb-0 mt-3"><?= htmlspecialchars($row['Nombre']) ?></h5>
                                </div>

                                <form method="POST" action="vista.php">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($row['Id_laboratorio']) ?>">
                                    <button type="submit" class="btn btn-marino">Explorar</button>
                                </form>

                            </div>
                        </div>
                    </div>
            <?php
                }
                echo '</div>';
            } else {
                echo "
            <div>
            <h3 class=mt-5 >Actualmente no hay laboratorios registrados en esta sección. </h3>
            <p class=mb-5>¡Vuelve a consultar pronto para ver nuevas actualizaciones!</p>
            </div>";
            }

            $stmt->close();
            $conn->close();
            ?>
        </div>
    </div>
    <?php include '../includes/footer.html'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>