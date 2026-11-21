<?php include '../config/conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cafetería Aroma - Menú</title>
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
        <h1>Nuestra Carta</h1>
        <p>Todos nuestros productos se preparan al momento con ingredientes frescos.</p>
        
        <div class="grid-menu">
            <?php
            $sql = "SELECT nombre, descripcion, precio, categoria FROM productos ORDER BY categoria, nombre";
            $resultado = $conn->query($sql);

            if ($resultado->num_rows > 0) {
                while($fila = $resultado->fetch_assoc()) {
                    echo "<div class='card-producto'>";
                    echo "<div>";
                    echo "<span class='categoria-badge'>" . htmlspecialchars($fila['categoria']) . "</span>";
                    echo "<h3>" . htmlspecialchars($fila['nombre']) . "</h3>";
                    echo "<p>" . htmlspecialchars($fila['descripcion']) . "</p>";
                    echo "</div>";
                    echo "<div class='precio'>Bs. " . number_format($fila['precio'], 2) . "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>No hay productos disponibles en este momento.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>