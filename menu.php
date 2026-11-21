<?php include 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cafetería Aroma - Menú</title>
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
        <h1>Nuestro Menú</h1>
        <?php
        $sql = "SELECT nombre, descripcion, precio, categoria FROM productos ORDER BY categoria";
        $resultado = $conn->query($sql);

        if ($resultado->num_rows > 0) {
            while($fila = $resultado->fetch_assoc()) {
                echo "<div class='tarjeta'>";
                echo "<div><h3>" . $fila['nombre'] . " <small>(" . $fila['categoria'] . ")</small></h3>";
                echo "<p>" . $fila['descripcion'] . "</p></div>";
                echo "<div class='precio'>Bs. " . $fila['precio'] . "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>No hay productos disponibles.</p>";
        }
        ?>
    </div>
</body>
</html>