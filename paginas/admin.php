<?php 
include '../config/conexion.php'; 
$alerta = "";

// Agregar un nuevo producto al menú
if (isset($_POST['agregar_producto'])) {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $descripcion = $conn->real_escape_string($_POST['descripcion']);
    $precio = (float)$_POST['precio'];
    $categoria = $conn->real_escape_string($_POST['categoria']);
    
    $conn->query("INSERT INTO productos (nombre, descripcion, precio, categoria) VALUES ('$nombre', '$descripcion', '$precio', '$categoria')");
    $alerta = "Producto agregado al menú correctamente.";
}

// Eliminar producto, reserva o mensaje
if (isset($_GET['eliminar_producto'])) {
    $id = (int)$_GET['eliminar_producto'];
    $conn->query("DELETE FROM productos WHERE id = $id");
    $alerta = "Producto eliminado del menú.";
}
if (isset($_GET['eliminar_reserva'])) {
    $id = (int)$_GET['eliminar_reserva'];
    $conn->query("DELETE FROM reservas WHERE id = $id");
    $alerta = "Reserva eliminada.";
}
if (isset($_GET['eliminar_mensaje'])) {
    $id = (int)$_GET['eliminar_mensaje'];
    $conn->query("DELETE FROM mensajes WHERE id = $id");
    $alerta = "Mensaje eliminado.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración - Cafetería Aroma</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <header>
        <a href="../index.php" class="logo">☕ Panel Administrativo</a>
        <nav>
            <a href="../index.php">Ver Sitio Web</a>
            <a href="menu.php">Menú</a>
            <a href="admin.php" class="btn-admin">Actualizar Datos</a>
        </nav>
    </header>

    <div class="contenedor">
        <?php if($alerta != "") echo "<div class='alerta'>$alerta</div>"; ?>

        <!-- SECCIÓN 1: MENSAJES RECIBIDOS -->
        <h2>📩 Mensajes de Clientes</h2>
        <table>
            <tr>
                <th>Fecha</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Mensaje</th>
                <th>Acción</th>
            </tr>
            <?php
            $res_msg = $conn->query("SELECT * FROM mensajes ORDER BY fecha_envio DESC");
            if ($res_msg->num_rows > 0) {
                while($m = $res_msg->fetch_assoc()) {
                    echo "<tr>
                        <td>{$m['fecha_envio']}</td>
                        <td><strong>" . htmlspecialchars($m['nombre']) . "</strong></td>
                        <td>" . htmlspecialchars($m['correo']) . "</td>
                        <td>" . htmlspecialchars($m['mensaje']) . "</td>
                        <td><a href='admin.php?eliminar_mensaje={$m['id']}' class='btn-eliminar'>Borrar</a></td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No hay mensajes nuevos.</td></tr>";
            }
            ?>
        </table>

        <!-- SECCIÓN 2: RESERVAS REGISTRADAS -->
        <h2>📅 Reservas de Mesas</h2>
        <table>
            <tr>
                <th>Cliente</th>
                <th>Correo</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Personas</th>
                <th>Acción</th>
            </tr>
            <?php
            $res_res = $conn->query("SELECT * FROM reservas ORDER BY fecha ASC, hora ASC");
            if ($res_res->num_rows > 0) {
                while($r = $res_res->fetch_assoc()) {
                    echo "<tr>
                        <td><strong>" . htmlspecialchars($r['nombre_cliente']) . "</strong></td>
                        <td>" . htmlspecialchars($r['correo']) . "</td>
                        <td>{$r['fecha']}</td>
                        <td>{$r['hora']}</td>
                        <td>{$r['personas']} pers.</td>
                        <td><a href='admin.php?eliminar_reserva={$r['id']}' class='btn-eliminar'>Cancelar</a></td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No hay reservas registradas.</td></tr>";
            }
            ?>
        </table>

        <!-- SECCIÓN 3: GESTIONAR MENÚ -->
        <h2>☕ Agregar Nuevo Producto al Menú</h2>
        <form method="POST" action="admin.php">
            <div class="fila-form">
                <input type="text" name="nombre" placeholder="Nombre del producto (ej. Latte Vainilla)" required>
                <select name="categoria" required>
                    <option value="Café Caliente">Café Caliente</option>
                    <option value="Bebidas Frías">Bebidas Frías</option>
                    <option value="Repostería">Repostería</option>
                </select>
            </div>
            <div class="fila-form">
                <input type="text" name="descripcion" placeholder="Breve descripción del producto" required>
                <input type="number" step="0.50" name="precio" placeholder="Precio en Bs. (ej. 24.00)" required>
            </div>
            <button type="submit" name="agregar_producto">+ Agregar al Menú</button>
        </form>

        <h2 style="margin-top:30px;">📋 Productos Actuales en el Menú</h2>
        <table>
            <tr>
                <th>Producto</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Acción</th>
            </tr>
            <?php
            $res_prod = $conn->query("SELECT * FROM productos ORDER BY categoria");
            while($p = $res_prod->fetch_assoc()) {
                echo "<tr>
                    <td><strong>" . htmlspecialchars($p['nombre']) . "</strong></td>
                    <td>{$p['categoria']}</td>
                    <td>Bs. " . number_format($p['precio'], 2) . "</td>
                    <td><a href='admin.php?eliminar_producto={$p['id']}' class='btn-eliminar'>Eliminar</a></td>
                </tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>