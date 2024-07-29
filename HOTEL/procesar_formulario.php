<?php
// Verifico si el método de solicitud es POST para asegurarme de que el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluyo el archivo base.php que contiene la conexión a la base de datos
    include 'base.php';

    // Obtengo los datos enviados desde el formulario y los asigno a variables
    $nombre = $_POST['nombre'];
    $ubicacion = $_POST['ubicacion'];
    $habitaciones_disponibles = $_POST['habitaciones_disponibles'];
    $tarifa_noche = $_POST['tarifa_noche'];

    // Preparo la consulta SQL para insertar los datos en la tabla HOTEL
    $sql = "INSERT INTO HOTEL (nombre, ubicacion, habitaciones_disponibles, tarifa_noche)
            VALUES ('$nombre', '$ubicacion', '$habitaciones_disponibles', '$tarifa_noche')";

    // Ejecuto la consulta y verifico si fue exitosa
    if ($conn->query($sql) === TRUE) {
        // Si la consulta fue exitosa, muestro un mensaje de éxito
        echo "Nuevo registro creado exitosamente";
    } else {
        // Si hubo un error, muestro el mensaje de error junto con la consulta SQL
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Cierro la conexión a la base de datos
    $conn->close();
}
?>
