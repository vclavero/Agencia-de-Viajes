<?php
// Habilito el informe de errores para ayudar en la depuraci車n
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluyo el archivo base.php que contiene la conexi車n a la base de datos
include 'base.php';

// Consulto todos los registros de la tabla VUELO
$sql_vuelos = "SELECT * FROM VUELO";
$result_vuelos = $conn->query($sql_vuelos);

// Consulto todos los registros de la tabla HOTEL
$sql_hoteles = "SELECT * FROM HOTEL";
$result_hoteles = $conn->query($sql_hoteles);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Defino la codificaci車n de caracteres y las propiedades de la ventana gr芍fica -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Vuelos y Hoteles</title>
    <!-- Incluyo el archivo de estilos CSS -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!-- Contenedor de la lista de vuelos -->
    <div class="list-container">
        <h2>Lista de Vuelos</h2>
        <table>
            <tr>
                <th>Origen</th>
                <th>Destino</th>
                <th>Fecha</th>
                <th>Plazas Disponibles</th>
            </tr>
            <?php
            // Verifico si hay registros de vuelos y los muestro en la tabla
            if ($result_vuelos->num_rows > 0) {
                while($row = $result_vuelos->fetch_assoc()) {
                    echo "<tr><td>" . $row["origen"]. "</td><td>" . $row["destino"]. "</td><td>" . $row["fecha"]. "</td><td>" . $row["plazas_disponibles"]. "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No hay vuelos registrados</td></tr>";
            }
            ?>
        </table>
        <!-- Enlace para registrar un nuevo vuelo -->
        <a href="formulario_vuelo.html"><input type="submit" value="Registrar Nuevo Vuelo"></a>
    </div>

    <!-- Contenedor de la lista de hoteles -->
    <div class="list-container">
        <h2>Lista de Hoteles</h2>
        <table>
            <tr>
                <th>Nombre</th>
                <th>Ubicaci車n</th>
                <th>Habitaciones Disponibles</th>
                <th>Tarifa por Noche</th>
            </tr>
            <?php
            // Verifico si hay registros de hoteles y los muestro en la tabla
            if ($result_hoteles->num_rows > 0) {
                while($row = $result_hoteles->fetch_assoc()) {
                    echo "<tr><td>" . $row["nombre"]. "</td><td>" . $row["ubicacion"]. "</td><td>" . $row["habitaciones_disponibles"]. "</td><td>" . $row["tarifa_noche"]. "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No hay hoteles registrados</td></tr>";
            }
            ?>
        </table>
        <!-- Enlace para registrar un nuevo hotel -->
        <a href="formulario_hotel.html"><input type="submit" value="Registrar Nuevo Hotel"></a>
    </div>
</body>
</html>

<?php
// Cierro la conexi車n a la base de datos
$conn->close();
?>
