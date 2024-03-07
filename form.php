<link rel="stylesheet" href="style.css">

<?php include 'nav.php'; ?>

<h1>Agregar Producto</h1>

<div id="Agregar">

<?php include 'conexion.php'; ?>

<?php
// Mensaje de éxito
$mensaje_exito = "";

// Verificar si se envió el formulario para agregar un producto
if(isset($_POST['agregar_producto'])) {
    // Obtener los datos del formulario
    $producto = $_POST['producto'];
    $cantidad = $_POST['cantidad'];
    $unidad = $_POST['unidad'];
    $fecha = $_POST['fecha'];
    $factura = $_POST['factura'];
    $observaciones = $_POST['observaciones'];

    // Insertar el nuevo producto en la tabla de entradas
    $sql_insert_entradas = "INSERT INTO entradas (producto, cantidad, unidad, fecha, factura, observaciones)
                   VALUES ('$producto', $cantidad, '$unidad', '$fecha', '$factura', '$observaciones')";

    if ($conn->query($sql_insert_entradas) === TRUE) {
        // Si la inserción en la tabla de entradas fue exitosa, inserta en la tabla de inventario
        $sql_insert_inventario = "INSERT INTO inventariot (producto, cantidad, unidad, fecha, factura, observaciones)
                                  VALUES ('$producto', $cantidad, '$unidad', '$fecha', '$factura', '$observaciones')";

        if ($conn->query($sql_insert_inventario) === TRUE) {
            // Actualizar el mensaje de éxito si la inserción en ambas tablas fue exitosa
            $mensaje_exito = "Producto agregado con éxito en entradas y en inventario";
        } else {
            // Si hubo un error en la inserción en la tabla de inventario, muestra el error
            echo "Error: " . $sql_insert_inventario . "<br>" . $conn->error;
        }
    } else {
        // Si hubo un error en la inserción en la tabla de entradas, muestra el error
        echo "Error: " . $sql_insert_entradas . "<br>" . $conn->error;
    }
}

// Obtener datos de la tabla de inventario
$sql_inventario = "SELECT * FROM inventariot";
$result_inventario = $conn->query($sql_inventario);

// Mostrar el mensaje de éxito si existe
if ($mensaje_exito != "") {
    echo "<p id='mensaje-exito' style='color: green; font-weight: bold;'>$mensaje_exito</p>";
}else{
    echo "";
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

<?php
// Cerrar la conexión a la base de datos al final del script
$conn->close();
?>