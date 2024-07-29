<?php
// Defino las credenciales y el nombre de la base de datos a la que quiero conectar
$servername = "localhost";
$username = "cvi92628_vclavero";
$password = "Fantasma3973";
$dbname = "cvi92628_AGENCIA";

// Creo la conexión a la base de datos utilizando las credenciales definidas anteriormente
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifico si la conexión fue exitosa, de lo contrario, muestro un mensaje de error y termino la ejecución del script
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
