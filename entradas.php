<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros de Entradas</title>
    <link rel="stylesheet" href="style.css">
   
</head>
<div id="Entradas">
<?php include 'nav.php'; ?>
<body>

<?php
// Conexión a la base de datos
include 'conexion.php';

// Consulta para obtener los registros de la tabla 'entradas'
$sql_entradas = "SELECT * FROM entradas";
$result_entradas = $conn->query($sql_entradas);
?>

<h1>Registros de Entradas</h1>

<table>
    <thead>
        <tr>
            <th>Código</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Unidad</th>
            <th>Fecha</th>
            <th>Factura</th>
            <th>Observaciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Verificar si hay resultados de la consulta
        if ($result_entradas->num_rows > 0) {
            // Iterar sobre los resultados y mostrar cada fila en la tabla
            while($row = $result_entradas->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['producto']}</td>
                        <td>{$row['cantidad']}</td>
                        <td>{$row['unidad']}</td>
                        <td>{$row['fecha']}</td>
                        <td>{$row['factura']}</td>
                        <td>{$row['observaciones']}</td>
                      </tr>";
            }
        } else {
            
            echo "<tr><td colspan='7'>No hay registros de entradas</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php
// Cerrar la conexión a la base de datos
$conn->close();
?>

</body>
</html>
