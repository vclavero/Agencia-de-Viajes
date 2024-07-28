<?php
$servername = "localhost"; // Aquí configuro el nombre del servidor
$username = "cvi92628_vclavero"; // Aquí configuro el nombre de usuario para la base de datos
$password = "Fantasma3973"; // Aquí configuro la contraseña para la base de datos
$dbname = "cvi92628_iacc"; // Aquí configuro el nombre de la base de datos

// Creo la conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifico si la conexión fue exitosa
if ($conn->connect_error) {
    // Si la conexión falla, muestro un mensaje de error y detengo el script
    die("Connection failed: " . $conn->connect_error);
}
?>
