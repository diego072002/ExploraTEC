<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carreras</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/vistas.css" rel="stylesheet">
</head>

<body>
    <?php include '../includes/navbar.html'; ?>
    <div class="mb-5">
        <?php
        include '../BD/config.php';

        if (isset($_POST['campus'])) {
            $campus = $_POST['campus'];

            // Obtener datos del campus para el encabezado
            $campus_sql = "SELECT Nombre, Nom_ext FROM campus WHERE Id_campus= ?";
            $campus_stmt = $conn->prepare($campus_sql);
            $campus_stmt->bind_param("s", $campus);
            $campus_stmt->execute();
            $campus_result = $campus_stmt->get_result();

            if ($campus_result->num_rows > 0) {
                $campus_data = $campus_result->fetch_assoc();
                echo '<h1 class="text-center mt-4">' . htmlspecialchars($campus_data['Nombre']) . '</h1>';
                echo '<h5 class="text-center text-muted mb-5 pb-3">' . htmlspecialchars($campus_data['Nom_ext']) . '</h5>';
            }



            // Consulta para obtener las carreras
            $sql = "SELECT * FROM carreras WHERE Id_campus = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $campus);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo '<div class="row row-cols-1 row-cols-md-2 g-4 mt-4 mx-3">';
                while ($row = $result->fetch_assoc()) {
        ?>
                    <div class="col">
                        <div class="card border-dark mb-4 shadow-sm">
                            <div class="card-body text-center pb-5">
                                <div class="pb-3 contor d-flex align-items-center justify-content-evenly">
                                    <img src="iconos/<?= htmlspecialchars($row['Icono']) ?>" alt="Icono" class="icon">
                                    <h5 class="card-title mb-0"><?= htmlspecialchars($row['Nombre']) ?></h5>
                                </div>
                                <p class="card-text my-5"><?= htmlspecialchars($row['Descripcion']) ?></p>
                                <form method="POST" action="laboratorios.php">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($row['Id_carrera']) ?>">
                                    <button type="submit" class="btn btn-marino">Ver laboratorios</button>
                                </form>
                            </div>
                        </div>
                    </div>
        <?php
                }
                echo '</div>';
            } else {
                echo "<p>No se encontraron carreras para el campus seleccionado.</p>";
            }

            $campus_stmt->close();
            $stmt->close();
            $conn->close();
        } else {
            echo "No se recibió el campus.";
        }
        ?>
    </div>

    <?php include '../includes/footer.html'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>