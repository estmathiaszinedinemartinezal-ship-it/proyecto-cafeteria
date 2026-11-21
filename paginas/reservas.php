<?php 
include '../config/conexion.php'; 
$mensaje_exito = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $correo = $conn->real_escape_string($_POST['correo']);
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $personas = (int)$_POST['personas'];

    $sql = "INSERT INTO reservas (nombre_cliente, correo, fecha, hora, personas) 
            VALUES ('$nombre', '$correo', '$fecha', '$hora', '$personas')";

    if ($conn->query($sql) === TRUE) {
        $mensaje_exito = "¡Tu mesa ha sido reservada con éxito para el $fecha a las $hora!";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cafetería Aroma - Reservas</title>
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
        <h1>Reserva tu Mesa</h1>
        <p>Asegura tu lugar favorito en nuestra cafetería.</p>
        <?php if($mensaje_exito != "") echo "<div class='alerta'>$mensaje_exito</div>"; ?>
        
        <form method="POST" action="reservas.php">
            <div class="fila-form">
                <input type="text" name="nombre" placeholder="Tu nombre completo" required>
                <input type="email" name="correo" placeholder="Tu correo electrónico" required>
            </div>
            <div class="fila-form">
                <input type="date" name="fecha" required>
                <input type="time" name="hora" required>
            </div>
            <input type="number" name="personas" placeholder="Cantidad de personas (1 a 15)" min="1" max="15" required>
            <button type="submit">Confirmar Reserva</button>
        </form>
    </div>
</body>
</html>