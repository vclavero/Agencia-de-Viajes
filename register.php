<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Aquí especifico la codificación de caracteres para la página -->
    <meta charset="UTF-8">
    <!-- Aquí configuro la vista de la página para que sea responsiva -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Aquí enlazo la hoja de estilos CSS -->
    <link rel="stylesheet" href="css/styles.css">
    <!-- Aquí defino el título de la página -->
    <title>Registro</title>
</head>
<body>
    <!-- Aquí coloco la barra de notificaciones con ofertas -->
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
    <!-- Encabezado principal de la página -->
    <h1>AGENCIA DE VIAJES RUTAS DE CHILE</h1>
    <div style="margin-bottom: 20px;"></div>
    <!-- Contenedor de texto de bienvenida -->
    <div class="text2-container">
        <p class="centered-text2">¡Bienvenidos a Rutas de Chile! Somos tu agencia de viajes especializada en la venta de pasajes aéreos nacionales. En Rutas de Chile, nuestra misión es hacer que tus viajes sean lo más sencillos y placenteros posible, ofreciéndote las mejores opciones de vuelos al mejor precio.</p>
    </div>
    <div style="margin-bottom: 3.5%;"></div>
    <div class="container2">
        <h2>Registrar</h2>
        <!-- Formulario de registro -->
        <form action="register.php" method="post">
            <input type="text" name="username" placeholder="Nombre de Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <input type="submit" value="Registrar">
        </form>
        <!-- Enlace para iniciar sesión si ya tiene cuenta -->
        <a href="login.php">¿Ya tienes una cuenta? Inicia sesión aquí</a>

        <?php
        // Incluyo el archivo de conexión a la base de datos
        include('db.php');

        // Lógica de registro
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Validar datos recibidos
            if (!empty($username) && !empty($password)) {
                // Preparo la sentencia SQL para insertar un nuevo usuario
                $query = "INSERT INTO Login (Nombre, Clave) VALUES (?, ?)";
                if ($stmt = $conn->prepare($query)) {
                    // Encripto la contraseña antes de guardarla en la base de datos
                    $password_hashed = password_hash($password, PASSWORD_DEFAULT);
                    $stmt->bind_param('ss', $username, $password_hashed);
                    if ($stmt->execute()) {
                        echo '<p>Registro exitoso. Ahora puedes <a href="login.php">iniciar sesión</a>.</p>';
                    } else {
                        echo '<p>Error al registrar. Por favor, intenta de nuevo.</p>';
                    }
                    $stmt->close();
                } else {
                    echo '<p>Error en la preparación de la consulta.</p>';
                }
            } else {
                echo '<p>Por favor, complete todos los campos.</p>';
            }
        }
        ?>
    </div>
    <!-- Archivo JavaScript -->
    <script src="js/scripts.js"></script>
</body>
</html>
