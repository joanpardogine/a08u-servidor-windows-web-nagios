<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informació del nostre Servidor</title>
</head>
<body>
    <h1>Informació del nostre Servidor</h1>
    <?php
    // Per demanar el nom a l'usuari
    $nom = isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '';
    // Mostrar el nom entrat per l'usuari
    if (!empty($nom)) {
        echo "<p>Hola $nom!</p>";
    }
    // Mostrar el nom del servidor i les seves adreces IP
    $nom_servidor = $_SERVER['SERVER_NAME'];
    $ip_servidor = gethostbyname($nom_servidor);
    echo "<p>Nom del servidor: $nom_servidor</p>";
    echo "<p>Adreça IP del servidor: $ip_servidor</p>";
    ?>
    <form method="post" action="">
        <label for="nom">Entra el teu nom:</label>
        <input type="text" name="nom" required>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>