
<?php

$servername = "localhost"; 
$username = "root";
$password = "";
$dbname = "exploratec";

try {
    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Verificar la conexión
    if ($conn->connect_error) {
        throw new Exception("Error de conexión: " . $conn->connect_error);
    }
} catch (Exception $e) {
    echo "<div class=text-center>
    <h1 class=mt-5>¡Vaya!</h1>
    <h5 class=my-5>Lo sentimos, no hemos podido cargar la pagina. Por favor, inténtelo más tarde.</h5>
    </div>";
    
    // error_log($e->getMessage());
    die();
}
?>
