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

        // Verifica la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Consulta para obtener todas las carreras
        $sql = "SELECT * FROM carreras WHERE Id_carrera <> 4 ORDER BY Id_campus";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
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
                echo "<p>No se encontraron carreras.</p>";
            }

            $stmt->close();
        } else {
            echo "Error en la consulta: " . $conn->error;
        }

        $conn->close();
        ?>
    </div>

    <?php include '../includes/footer.html'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
</body>

</html>
