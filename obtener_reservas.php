<?php
// Inicio la sesión para poder acceder a las variables de sesión si es necesario
session_start();

// Incluyo el archivo base.php que contiene la conexión a la base de datos
include 'base.php';

// Verifico si la conexión a la base de datos fue exitosa
if ($conn->connect_error) {
    // Si hay un error de conexión, muestro un mensaje de error y termino la ejecución del script
    die("Error de conexión: " . $conn->connect_error);
}

// Preparo la consulta SQL para obtener todas las reservas
$sql_reservas = "SELECT * FROM RESERVA";
$result_reservas = $conn->query($sql_reservas);

// Creo un array para almacenar las reservas
$reservas = array();

// Verifico si hay resultados en la consulta y los añado al array
if ($result_reservas->num_rows > 0) {
    while ($row = $result_reservas->fetch_assoc()) {
        $reservas[] = $row; // Agrego cada fila al array de reservas
    }
}

// Codifico el array de reservas en formato JSON y lo devuelvo
echo json_encode($reservas);

// Cierro la conexión a la base de datos
$conn->close();
?>

