<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información del Servidor</title>
</head>
<body>
    <?php
    // Función para obtener todas las direcciones IP del servidor
    function obtenerDireccionesIP() {
        $direcciones = array();

        // Intentar obtener las direcciones IP utilizando getifaddrs()
        if (function_exists('getifaddrs')) {
            // Obtener todas las interfaces de red del servidor
            $interfaces = getifaddrs();

            foreach ($interfaces as $interface) {
                // Filtrar solo las entradas IPv4 e IPv6
                if (isset($interface->addr) && ($interface->family === AF_INET || $interface->family === AF_INET6)) {
                    $direcciones[] = $interface->addr;
                }
            }
        }

        // Si getifaddrs() no está disponible, intentar obtener direcciones IP alternativamente
        if (empty($direcciones)) {
            $direcciones = gethostbynamel($_SERVER['SERVER_NAME']);
        }

        return $direcciones;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtener el nombre ingresado por el usuario
        $nombre = isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : '';

        // Mostrar el nombre ingresado
        if (!empty($nombre)) {
            echo "<h1>Bienvenido, $nombre</h1>";
        }

        // Mostrar el nombre del servidor y todas las direcciones IP
        $nombre_servidor = $_SERVER['SERVER_NAME'];

        echo "<p>Nombre del servidor: $nombre_servidor</p>";

        // Intentar obtener las direcciones IP del servidor
        $direcciones_ip = obtenerDireccionesIP();

        if (!empty($direcciones_ip)) {
            echo "<p>Direcciones IP del servidor:</p>";
            echo "<ul>";
            foreach ($direcciones_ip as $ip) {
                echo "<li>$ip</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No se pudo obtener la información de las direcciones IP.</p>";
        }
    }
    ?>

    <form method="post" action="">
        <label for="nombre">Ingresa tu nombre:</label>
        <input type="text" name="nombre" required>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>
