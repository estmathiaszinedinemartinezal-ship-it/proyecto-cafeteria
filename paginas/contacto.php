<?php 
include '../config/conexion.php'; 
$mensaje_exito = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $correo = $conn->real_escape_string($_POST['correo']);
    $mensaje = $conn->real_escape_string($_POST['mensaje']);

    $sql = "INSERT INTO mensajes (nombre, correo, mensaje) VALUES ('$nombre', '$correo', '$mensaje')";

    if ($conn->query($sql) === TRUE) {
        $mensaje_exito = "Gracias por escribirnos. Tu mensaje ya está disponible en nuestro panel de atención.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cafetería Aroma - Contacto</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <header>
        <a href="../index.php" class="logo">☕ Cafetería Aroma</a>
        <nav>
            <a href="../index.php">Inicio</a>
            <a href="menu.php">Menú</a>
            <a href="reservas.php">Reservas</a>
            <a href="contacto.php">Contacto</a>
            <a href="admin.php" class="btn-admin">Panel Admin</a>
        </nav>
    </header>

    <div class="contenedor">
        <h1>Contáctanos</h1>
        <p>¿Tienes alguna consulta, pedido especial o sugerencia? Escríbenos directamente.</p>
        <?php if($mensaje_exito != "") echo "<div class='alerta'>$mensaje_exito</div>"; ?>
        
        <form method="POST" action="contacto.php">
            <div class="fila-form">
                <input type="text" name="nombre" placeholder="Tu nombre" required>
                <input type="email" name="correo" placeholder="Tu correo electrónico" required>
            </div>
            <textarea name="mensaje" rows="5" placeholder="Escribe aquí tu mensaje..." required></textarea>
            <button type="submit">Enviar Mensaje</button>
        </form>
    </div>
</body>
</html>