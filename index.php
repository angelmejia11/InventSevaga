<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'nav.php'; ?>

<h1>F E R T I L I Z A N T E S</h1>

<img src="Sevaga.png" alt="Imagen de Inventario" style="width: 10%; margin: 20px auto; display: block;">

<div id="Inicio">
<form method="GET" id="searchForm">
    <label for="search">Buscar producto:</label>
    <input type="text" name="search" id="search" placeholder="Ingrese el nombre del producto">
    <button type="submit">Buscar</button>
    <button type="button" onclick="limpiarCampoBusqueda()">Limpiar Búsqueda</button>
</form>
    <?php include 'conexion.php'; ?>

    <?php
    // Mensaje de éxito

    session_start(); // Inicia la sesión si aún no se ha iniciado

    // Verificar si hay un mensaje de éxito almacenado en la variable de sesión
    if (isset($_SESSION['mensaje_exito'])) {
        echo "<p style='color: green; font-weight: bold;'>{$_SESSION['mensaje_exito']}</p>";
        // Eliminar el mensaje de éxito después de mostrarlo para que no se muestre en futuras recargas de la página
        unset($_SESSION['mensaje_exito']);
    }

    $mensaje_exito = "";

    // Verificar si se envió el formulario para agregar un producto
    if(isset($_POST['agregar_producto'])) {
        $producto = $_POST['producto'];
        $cantidad = $_POST['cantidad'];
        $unidad = $_POST['unidad'];
        $fecha = $_POST['fecha'];
        $factura = $_POST['factura'];
        $observaciones = $_POST['observaciones'];

        // Insertar el nuevo producto en la tabla de inventario
        $sql = "INSERT INTO inventariot (producto, cantidad, unidad, fecha, factura, observaciones) VALUES ('$producto', $cantidad, '$unidad', '$fecha', '$factura', '$observaciones')";

        if ($conn->query($sql) === TRUE) {
          
            $mensaje_exito = "Producto agregado con éxito";
        } else {
            
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Verificar si se envió el formulario para eliminar un producto
if(isset($_POST['eliminar_producto'])) {
    $producto_id = $_POST['eliminar_producto_id'];
    
    
    $sql_eliminar_salidas = "DELETE FROM salidas WHERE producto_id = $producto_id";

    if ($conn->query($sql_eliminar_salidas) === TRUE) {
        // Ahora que los registros relacionados en la tabla salidas han sido eliminados, podemos proceder a eliminar el producto de la tabla inventariot
        $sql_eliminar = "DELETE FROM inventariot WHERE codigo = $producto_id";

        if ($conn->query($sql_eliminar) === TRUE) {
            
            $mensaje_exito = "Producto eliminado con éxito";
        } else {
            
            echo "Error al eliminar el producto: " . $conn->error;
        }
    } else {
        
        echo "Error al eliminar los registros relacionados en la tabla salidas: " . $conn->error;
    }
}
    // Obtener datos de la tabla de inventario
    $sql_inventario = "SELECT * FROM inventariot";
    $result_inventario = $conn->query($sql_inventario);

    // Mostrar el mensaje de éxito si existe
    if ($mensaje_exito != "") {
        echo "<p id='mensaje-exito' style='color: green; font-weight: bold;'>$mensaje_exito</p>";
    }
    ?>
<?php
// Verificar si se envió un término de búsqueda
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = $_GET['search'];
    // Sanitizar la entrada del usuario
    $search_term = mysqli_real_escape_string($conn, $search_term);
    // Construir la consulta SQL para buscar por nombre de producto
    $sql = "SELECT * FROM inventariot WHERE producto LIKE '%$search_term%'";
} else {
    // Si no se proporciona un término de búsqueda, mostrar un mensaje indicando que no se ha realizado ninguna búsqueda
     echo "Por favor, ingresa un término de búsqueda para buscar un producto.";
    
    $sql = "";
}

// Ejecutar la consulta solo si $sql no está vacía
if (!empty($sql)) {
    // Ejecutar la consulta
    $result = $conn->query($sql);

    // Verificar si se encontraron resultados
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Código</th><th>Producto</th><th>Cantidad</th><th>Unidad</th><th>Fecha</th><th>Factura</th><th>Observaciones</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['codigo']}</td>";
            echo "<td>{$row['producto']}</td>";
            echo "<td>{$row['cantidad']}</td>";
            echo "<td>{$row['unidad']}</td>";
            echo "<td>{$row['fecha']}</td>";
            echo "<td>{$row['factura']}</td>";
            echo "<td>{$row['observaciones']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron resultados.";
    }
}
?>

    <table>
        <tr>
            <th>Código</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Unidad</th>
            <th>Fecha</th>
            <th>Factura</th>
            <th>Observaciones</th>
            <th>Acciones</th>
        </tr>
        <?php
        while($row = $result_inventario->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['codigo']}</td>
                    <td>{$row['producto']}</td>
                    <td>{$row['cantidad']}</td>
                    <td>{$row['unidad']}</td>
                    <td>{$row['fecha']}</td>
                    <td>{$row['factura']}</td>
                    <td>{$row['observaciones']}</td>
                    <td>
                        <form method='post'>
                            <input type='hidden' name='eliminar_producto_id' value='{$row['codigo']}'>
                            <button type='submit' name='eliminar_producto' onclick='return confirm
                            (\"¿Estás seguro de eliminar este producto?\")'>Eliminar</button>
                        </form>
                        
                        <form method='post' action='formulario_salidas.php'> 
                            <input type='hidden' name='producto_id' value='{$row['codigo']}'>
                            <button type='submit' name='mover_a_salidas' style='margin-top: 5px;'>Salidas
                            </button>
                        </form>
                    </td>
                </tr>";
        }
        ?>
    </table>

    <script src="script.js"></script>

</body>
</html>

<?php

$conn->close();
?>


