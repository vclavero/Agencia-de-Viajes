<?php
// Inicio mi sesión
session_start();

// Verifico si estoy logueado
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    echo "<div class='logout-container'>
            <a href='logout.php' class='logout-button'>Cerrar sesión</a>
          </div>";
} else {
    header("Location: login.php");
    exit();
}

include 'base.php';

// Verifica la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consultar vuelos
$sql_vuelos = "SELECT * FROM VUELO";
$result_vuelos = $conn->query($sql_vuelos);

// Verificar si la consulta de vuelos tuvo éxito
if (!$result_vuelos) {
    die("Error en la consulta de vuelos: " . $conn->error);
}

// Consultar hoteles
$sql_hoteles = "SELECT * FROM HOTEL";
$result_hoteles = $conn->query($sql_hoteles);

// Verificar si la consulta de hoteles tuvo éxito
if (!$result_hoteles) {
    die("Error en la consulta de hoteles: " . $conn->error);
}

// Manejar la reserva
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id']; // Asegúrate de que el user_id esté en la sesión
    $id_vuelo = $_POST['id_vuelo'];
    $id_hotel = $_POST['id_hotel'];
    $fecha_reserva = date('Y-m-d');

    // Debugging: Verifica los valores recibidos
    // echo "ID Cliente: " . $user_id . "<br>";
    // echo "ID Vuelo: " . $id_vuelo . "<br>";
    // echo "ID Hotel: " . $id_hotel . "<br>";

    $sql_reserva = "INSERT INTO RESERVA (id_cliente, fecha_reserva, id_vuelo, id_hotel) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_reserva);
    $stmt->bind_param("isii", $user_id, $fecha_reserva, $id_vuelo, $id_hotel);

    if ($stmt->execute()) {
        //echo "Reserva realizada con éxito.";
    } else {
        echo "Error al realizar la reserva: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/cpanel.css">
    <link rel="stylesheet" href="css/listado_vuelos.css">
    <link rel="stylesheet" href="css/registro.css">
    <title>Cpanel</title>
    <style>
        /* Estilos para el modal */
        .modal {
            display: none; /* Oculto por defecto */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php
    $nombre_usuario = htmlspecialchars($_SESSION['nombre'], ENT_QUOTES, 'UTF-8');
    ?>
    <div class="ticker-wrapper">
        <div class="ticker">
            <div class="ticker-item">
                <img src="imagenes/oferta.png" alt="Icono">
                <h2 style="color: yellow;">OFERTAS</h2>
                <img src="imagenes/ok.png" alt="Icono" class="ticker-icon">
                Concepción solo hoy a: $15.000 
                <img src="imagenes/ok.png" alt="Icono" class="ticker-icon">
                Punta Arenas: $35.000 
                <img src="imagenes/ok.png" alt="Icono" class="ticker-icon">
                Antofagasta: $30,000 
                <img src="imagenes/ok.png" alt="Icono" class="ticker-icon">
                Santiago desde cualquier destino: $28.700 
                <img src="imagenes/bus.png" alt="Icono" class="ticker-icon">
                <p style="color: yellow;">Buses El Rápido. Traslado de pasajeros en todos los aeropuertos de cada ciudad a tan solo $3.500 por persona en todo horario.</p>
            </div>
        </div>
    </div>
    <br>
    <h1>AGENCIA DE VIAJES RUTAS DE CHILE</h1>
    <div class="text2-container">
        <center><h1>
            <div class="container_nombre">
                <?php
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                    echo "<div class=''>
                            <span class=''>Bienvenido, " . $_SESSION['nombre'] . "</span>
                          </div>";
                }
                ?>
            </div>    
        </center></h1>    
        <div style="margin-bottom: 40px;"></div>
        <p class="centered-text2">¡Rutas de Chile! Somos tu agencia de viajes especializada en la venta de pasajes aéreos nacionales. En Rutas de Chile, nuestra misión es hacer que tus viajes sean lo más sencillos y placenteros posible, ofreciéndote las mejores opciones de vuelos al mejor precio.</p>
    </div>
    
    <div class="container_login">
        <div class="box" data-destino="Antofagasta" data-precio="35400">
            <h2>LISTADOS DE VUELOS NACIONALES</h2>
            <table>
                <tr>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>Fecha</th>
                    <th>Plazas Disponibles</th>
                    <th>Acciones</th>
                </tr>
                <?php
                if ($result_vuelos->num_rows > 0) {
                    while($row = $result_vuelos->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row["origen"]) . "</td>
                                <td>" . htmlspecialchars($row["destino"]) . "</td>
                                <td>" . htmlspecialchars($row["fecha"]) . "</td>
                                <td>" . htmlspecialchars($row["plazas_disponibles"]) . "</td>
                                <td>
                                    <button class='button' onclick='seleccionarVuelo(" . $row["id_vuelo"] . ", \"" . $row["fecha"] . "\")'>Hotel</button>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No hay vuelos registrados</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
    
    
    <div class="trigger-area">
        <h3><span>INGRESAR INFORMACIÓN</span></h3>
    </div>
    
    <!-- Aquí coloco el contenedor deslizante -->
    <div class="slide-out-container">
        <div class="close-button" onclick="cerrarCarrito()">
            <span class="close-x">X</span>
            <span class="close-text">cerrar</span>
        </div>
        <center>
            <p>Cpanel</p>
            <div id="carrito">
                <p style="color: white;">Ingresar información de Vuelos.</p>
                <button class="button" onclick="window.location.href='https://www.victorclavero.cl/tareas/semana6/VUELO/formulario_vuelo.html'">VUELOS</button><br>
                
                <p style="color: white;">Ingresar información de Hoteles.</p>
                <button class="button" onclick="window.location.href='https://www.victorclavero.cl/tareas/semana6/HOTEL/formulario.html'">HOTELES</button><br>
                 
                <p style="color: white;">Mostrar todoas las reservas del usuario</p>
                <button class="button" onclick="abrirReservaModal()">RESERVAS</button><br> 
                 
            <div style="margin-bottom: 100%;"></div>     
            </div>
            <button class="button_finalizar_compra" onclick="cerrarCarrito()">Cerrar</button>
            <div style="margin-bottom: 60px;"></div>
        </center>
    </div>
   

    <div id="hotelModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarHotelModal()">&times;</span>
            <h2>Hoteles Disponibles</h2>
            <table id="hotelTable">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Ubicación</th>
                        <th>Habitaciones Disponibles</th>
                        <th>Tarifa por Noche</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_hoteles->num_rows > 0) {
                        while($row = $result_hoteles->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row["nombre"]) . "</td>
                                    <td>" . htmlspecialchars($row["ubicacion"]) . "</td>
                                    <td>" . htmlspecialchars($row["habitaciones_disponibles"]) . "</td>
                                    <td>" . htmlspecialchars($row["tarifa_noche"]) . "</td>
                                    <td>
                                        <button class='button' onclick='reservarHotel(" . $row["id_hotel"] . ")'>Registrar</button>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No hay hoteles registrados</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para mostrar las reservas -->
    <div id="reservaModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarReservaModal()">&times;</span>
            <h2>Reservas</h2>
            <table id="reservaTable">
                <thead>
                    <tr>
                        <th>ID Reserva</th>
                        <th>ID Cliente</th>
                        <th>Fecha Reserva</th>
                        <th>ID Vuelo</th>
                        <th>ID Hotel</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Las filas de reservas serán insertadas aquí mediante JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <form id="reservaForm" method="POST" action="" style="display: none;">
        <input type="hidden" name="id_vuelo" id="id_vuelo">
        <input type="hidden" name="fecha_vuelo" id="fecha_vuelo">
        <input type="hidden" name="id_hotel" id="id_hotel">
    </form>

    <script>
        function seleccionarVuelo(idVuelo, fechaVuelo) {
            document.getElementById("id_vuelo").value = idVuelo;
            document.getElementById("fecha_vuelo").value = fechaVuelo;
            abrirHotelModal();
        }

        function abrirHotelModal() {
            var modal = document.getElementById("hotelModal");
            modal.style.display = "block";
        }

        function cerrarHotelModal() {
            var modal = document.getElementById("hotelModal");
            modal.style.display = "none";
        }

        function abrirReservaModal() {
            var modal = document.getElementById("reservaModal");
            modal.style.display = "block";
            cargarReservas(); // Llamar a la función para cargar las reservas
        }

        function cerrarReservaModal() {
            var modal = document.getElementById("reservaModal");
            modal.style.display = "none";
        }

        function cargarReservas() {
            // Realizar una solicitud AJAX para obtener los datos de la tabla RESERVA
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "obtener_reservas.php", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var reservas = JSON.parse(xhr.responseText);
                    var tbody = document.getElementById("reservaTable").getElementsByTagName("tbody")[0];
                    tbody.innerHTML = ""; // Limpiar el contenido actual del tbody

                    reservas.forEach(function(reserva) {
                        var row = tbody.insertRow();
                        row.insertCell(0).innerText = reserva.id_reserva;
                        row.insertCell(1).innerText = reserva.id_cliente;
                        row.insertCell(2).innerText = reserva.fecha_reserva;
                        row.insertCell(3).innerText = reserva.id_vuelo;
                        row.insertCell(4).innerText = reserva.id_hotel;
                    });
                }
            };
            xhr.send();
        }

        function reservarHotel(idHotel) {
            document.getElementById("id_hotel").value = idHotel;
            document.getElementById("reservaForm").submit();
        }
    </script>
    <script src="js/scripts.js"></script>
    <script src="Js/logout.js"></script>
    
</body>
</html>

<?php
$conn->close();
?>
