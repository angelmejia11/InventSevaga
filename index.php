<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        h1 {
            color: #4CAF50;
        }

        form {
            width: 50%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin: 10px 0;
            font-weight: bold;
        }

        input, textarea {
            width: calc(100% - 24px);
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"], button {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            border: none;
            border-radius: 4px;
            padding: 12px 20px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover, button:hover {
            background-color: #45a049;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

<h1>F E R T I L I Z A N T E S</h1>

<img src="Sevaga.png" alt="Imagen de Inventario" style="width: 10%; margin: 20px auto; display: block;">
<?php
// Conexión a la base de datos (reemplaza con tus propios datos)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventario";
$port = 3310;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Mensaje de éxito
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
        // Actualizar el mensaje de éxito si la inserción fue exitosa
        $mensaje_exito = "Producto agregado con éxito";
    } else {
        // Si hubo un error en la inserción, mostrar mensaje de error
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Verificar si se envió el formulario para eliminar un producto
if(isset($_POST['eliminar_producto'])) {
    $producto_id = $_POST['eliminar_producto_id'];

    // Eliminar el producto de la tabla de inventario
    $sql_eliminar = "DELETE FROM inventariot WHERE codigo = $producto_id";

    if ($conn->query($sql_eliminar) === TRUE) {
        // Actualizar el mensaje de éxito si la eliminación fue exitosa
        $mensaje_exito = "Producto eliminado con éxito";
    } else {
        // Si hubo un error en la eliminación, mostrar mensaje de error
        echo "Error al eliminar el producto: " . $conn->error;
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

<!-- Formulario para agregar un producto -->
<form method="post">
    <label for="producto">Producto:</label>
    <input type="text" name="producto" required>
    
    <label for="cantidad">Cantidad:</label>
    <input type="number" name="cantidad" required>
    
    <label for="unidad">Unidad:</label>
    <input type="text" name="unidad" required>
    
    <label for="fecha">Fecha:</label>
    <input type="date" name="fecha" required>
    
    <label for="factura">Factura:</label>
    <input type="text" name="factura">
    
    <label for="observaciones">Observaciones:</label>
    <textarea name="observaciones"></textarea>
    
    <input type="submit" name="agregar_producto" value="Agregar Producto">
</form>

<!-- Tabla de inventario -->
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
                        <button type='submit' name='eliminar_producto' onclick='return confirm(\"¿Estás seguro de eliminar este producto?\")'>Eliminar</button>
                    </form>
                    <form method='post'>
                        <input type='hidden' name='producto_id' value='{$row['codigo']}'>
                        <button type='submit' name='mover_a_salidas' style='margin-top: 5px;'>Salidas</button>
                    </form>
                </td>
            </tr>";
    }
    ?>
</table>

<script>
    setTimeout(function() {
        var mensajeExito = document.getElementById('mensaje-exito');
        if (mensajeExito) {
            mensajeExito.style.display = 'none';
        }
    }, 5000); // 5000 milisegundos = 5 segundos
</script>

</body>
</html>

<?php
// Cerrar la conexión a la base de datos al final del script
$conn->close();
?>
