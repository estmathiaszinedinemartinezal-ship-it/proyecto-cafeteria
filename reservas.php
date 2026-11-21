<?php 
include 'conexion.php'; 
$mensaje_exito = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $personas = $_POST['personas'];

    $sql = "INSERT INTO reservas (nombre_cliente, correo, fecha, hora, personas) 
            VALUES ('$nombre', '$correo', '$fecha', '$hora', '$personas')";

    if ($conn->query($sql) === TRUE) {
        $mensaje_exito = "¡Reserva registrada con éxito en la base de datos!";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cafetería Aroma - Reservas</title>
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
        <h1>Reserva tu Mesa</h1>
        <?php if($mensaje_exito != "") echo "<div class='alerta'>$mensaje_exito</div>"; ?>
        <form method="POST" action="reservas.php">
            <input type="text" name="nombre" placeholder="Tu nombre completo" required>
            <input type="email" name="correo" placeholder="Tu correo electrónico" required>
            <input type="date" name="fecha" required>
            <input type="time" name="hora" required>
            <input type="number" name="personas" placeholder="Cantidad de personas" min="1" max="15" required>
            <button type="submit">Confirmar Reserva</button>
        </form>
    </div>
</body>
</html>