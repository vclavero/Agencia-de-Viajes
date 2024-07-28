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
    <title>Login</title>
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
    <div class="container-wrapper">
        <div style="margin-bottom: 27%;"></div>
        <div class="container">
            
            <?php
            // Inicio la sesión del usuario
            session_start();
            // Incluyo el archivo de conexión a la base de datos
            include('db.php'); // Asegúrate de que la conexión a la base de datos esté configurada correctamente
            
            // Verifico si el formulario se ha enviado
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                
                $username = $_POST['username'];
                $password = $_POST['password'];
            
                // Validar datos recibidos
                if (!empty($username) && !empty($password)) {
                    // Consultar la base de datos para verificar las credenciales
                    $query = "SELECT id, Clave, Nombre FROM Login WHERE Nombre = ?";
                    if ($stmt = $conn->prepare($query)) {
                        $stmt->bind_param('s', $username);
                        $stmt->execute();
                        $stmt->store_result();
            
                        // Verifico si el usuario existe
                        if ($stmt->num_rows > 0) {
                            $stmt->bind_result($user_id, $hashed_password, $nombre);
                            $stmt->fetch();
            
                            // Verifico si la contraseña es correcta
                            if (password_verify($password, $hashed_password)) {
                                // Establecer variables de sesión
                                $_SESSION['user_id'] = $user_id;
                                $_SESSION['nombre'] = $nombre;
                                $_SESSION['loggedin'] = true;
                                header("Location: cpanel.php");
                                exit();
                            } else {
                                echo '<p>Contraseña incorrecta.</p>';
                            }
                        } else {
                            echo '<p>Usuario no encontrado.</p>';
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

            <!-- Formulario de inicio de sesión -->
            <h2>Iniciar Sesión</h2>
            <form action="login.php" method="post">
                <input type="text" name="username" placeholder="Nombre de Usuario" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <input type="submit" value="Ingresar">
            </form>
            <!-- Enlace para registro de nuevos usuarios -->
            <a href="register.php">¿No tienes cuenta? Regístrate aquí</a>
        </div>
    </div>
    
    <!-- Archivo JavaScript -->
    <script src="js/scripts.js"></script>
</body>
</html>
