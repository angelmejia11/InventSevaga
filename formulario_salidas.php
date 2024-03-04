<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Salidas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Salida de Producto</h1>

<?php include 'conexion.php'; ?>

<?php
// Verificar si se ha enviado el formulario y si se ha seleccionado un producto
if(isset($_POST['producto_id'])) {
    $producto_id = $_POST['producto_id'];
} else {
    $producto_id = ""; // O cualquier otro valor predeterminado que desees
}

// Obtener el producto seleccionado de la base de datos
if(!empty($producto_id)) {
    $sql = "SELECT * FROM inventariot WHERE codigo = $producto_id";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
?>
            <form method="post" action="procesar_salida.php">
                <input type="hidden" name="producto_id" value="<?php echo $row['codigo']; ?>">
                <label for="producto">Producto:</label>
                <input type="text" name="producto" value="<?php echo $row['producto']; ?>" readonly>
                
                <label for="cantidad">Cantidad disponible:</label>
                <input type="text" name="cantidad" value="<?php echo $row['cantidad']; ?>" readonly>
                
                <label for="unidad">Unidad:</label>
                <input type="text" name="unidad" value="<?php echo $row['unidad']; ?>" readonly>
                
                <label for="fecha">Fecha:</label>
                <input type="date" name="fecha" required>
                
                <label for="area">Área:</label>
                <input type="text" name="area" required>
                
                <label for="vale">Vale:</label>
                <input type="text" name="vale" required>
                
                <label for="cantidad_salida">Cantidad de salida:</label>
                <input type="number" name="cantidad_salida" required>
                
                <input type="submit" name="agregar_salida" value="Agregar Salida">
            </form>
<?php
        } else {
            echo "Producto no encontrado.";
        }
    } else {
        echo "Error al ejecutar la consulta: " . $conn->error;
    }
} else {
    echo "No se ha seleccionado ningún producto.";
}
?>

</body>
</html>




