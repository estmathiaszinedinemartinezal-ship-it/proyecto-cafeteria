<?php 
include 'conexion.php'; 
$mensaje_exito = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $mensaje = $_POST['mensaje'];

    $sql = "INSERT INTO mensajes (nombre, correo, mensaje) VALUES ('$nombre', '$correo', '$mensaje')";

    if ($conn->query($sql) === TRUE) {
        $mensaje_exito = "Gracias por escribirnos. Tu mensaje ha sido guardado.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cafetería Aroma - Contacto</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <header>
        <nav>
            <a href="index.php">Inicio</a>
            <a href="menu.php">Menú</a>
            <a href="reservas.php">Reservas</a>
            <a href="contacto.php">Contacto</a>
        </nav>
    </header>
    <div class="contenedor">
        <h1>Contáctanos</h1>
        <?php if($mensaje_exito != "") echo "<div class='alerta'>$mensaje_exito</div>"; ?>
        <form method="POST" action="contacto.php">
            <input type="text" name="nombre" placeholder="Tu nombre" required>
            <input type="email" name="correo" placeholder="Tu correo" required>
            <textarea name="mensaje" rows="5" placeholder="Escribe tu consulta o sugerencia..." required></textarea>
            <button type="submit">Enviar Mensaje</button>
        </form>
    </div>
</body>
</html>