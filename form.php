<link rel="stylesheet" href="style.css">

<nav>
    <ul>
        <li><a href="index.php#Inicio">Inicio</a></li>
        <li><a href="#entradas">Entradas</a></li>
        <li><a href="#salidas">Salidas</a></li>
        <li><a href="form.php#Agregar">Agregar Producto</a></li>
    </ul>
</nav>

<h1>Agregar Producto</h1>



<div id="Agregar">

<?php include 'conexion.php'; ?>



<?php
// Mensaje de éxito
$mensaje_exito = "";
// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

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



<script src="script.js"></script>

<?php
// Cerrar la conexión a la base de datos al final del script
$conn->close();
?>
