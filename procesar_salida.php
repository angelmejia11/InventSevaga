
<?php
include 'conexion.php';

if(isset($_POST['agregar_salida'])) {
    $producto_id = $_POST['producto_id'];
    $cantidad_salida = $_POST['cantidad_salida'];
    
    // Obtener la cantidad actual y el nombre del producto del producto en la tabla inventariot
    $sql_producto = "SELECT cantidad, producto FROM inventariot WHERE codigo = $producto_id";
    $result_producto = $conn->query($sql_producto);
    
    if ($result_producto->num_rows > 0) {
        $row_producto = $result_producto->fetch_assoc();
        $cantidad_actual = $row_producto['cantidad'];
        $nombre_producto = $row_producto['producto']; // Se obtiene el nombre del producto
        
        // Verificar si hay suficiente cantidad disponible para la salida
        if ($cantidad_actual >= $cantidad_salida) {
            // Realizar la resta de la cantidad de salida en la tabla inventariot
            $nueva_cantidad = $cantidad_actual - $cantidad_salida;
            $sql_actualizar_cantidad = "UPDATE inventariot SET cantidad = $nueva_cantidad WHERE codigo = $producto_id";
            
            if ($conn->query($sql_actualizar_cantidad) === TRUE) {
                // Insertar los datos de la salida en la tabla salidas
                $unidad = $_POST['unidad'];
                $fecha = $_POST['fecha'];
                $area = $_POST['area'];
                $vale = $_POST['vale'];
                $observaciones = $_POST['observaciones'];
                
                $sql_salida = "INSERT INTO salidas (producto_id, nombre_producto, cantidad, unidad, fecha, area, vale, observaciones) 
                                VALUES ('$producto_id', '$nombre_producto', '$cantidad_salida', '$unidad', '$fecha', '$area', '$vale', '$observaciones')";
                
                if ($conn->query($sql_salida) === TRUE) {
                    // Mensaje de éxito
                    $mensaje_exito = "Salida agregada con éxito";
                } else {
                    // Mensaje de error si hay un problema al insertar la salida
                    echo "Error al agregar la salida: " . $conn->error;
                }
            } else {
                // Mensaje de error si hay un problema al actualizar la cantidad en inventariot
                echo "Error al actualizar la cantidad en el inventario: " . $conn->error;
            }
        } else {
            // Mensaje de error si no hay suficiente cantidad disponible
            echo "No hay suficiente cantidad disponible para la salida.";
        }
    } else {
        // Mensaje de error si no se encuentra el producto en inventariot
        echo "No se encuentra el producto en el inventario.";
    }
}

// Redirigir de vuelta a la página de inicio
header("Location: index.php");
exit();

$conn->close();
?>
