
<?php
include 'conexion.php';

if(isset($_POST['agregar_salida'])) {
    $producto_id = $_POST['producto_id'];
    $cantidad = $_POST['cantidad_salida']; // Cambio aquí
    $unidad = $_POST['unidad'];
    $fecha = $_POST['fecha'];
    $area = $_POST['area'];
    $vale = $_POST['vale'];
    $observaciones = $_POST['observaciones']; // Cambio aquí
    
    // Insertar datos en la tabla de salidas
    $sql_salida = "INSERT INTO salidas (producto_id, cantidad, unidad, fecha, area, vale, observaciones) 
                    VALUES ('$producto_id', '$cantidad', '$unidad', '$fecha', '$area', '$vale', '$observaciones')";
    
    if ($conn->query($sql_salida) === TRUE) {
        // Actualizar el mensaje de éxito si la inserción fue exitosa
        $mensaje_exito = "Salida agregada con éxito";
    } else {
        // Si hubo un error en la inserción, mostrar mensaje de error
        echo "Error: " . $sql_salida . "<br>" . $conn->error;
    }
}

// Redirigir de vuelta a la página de inicio
header("Location: index.php");
exit();

$conn->close();
?>

