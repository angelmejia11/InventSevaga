<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salidas Registradas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
    <ul>
        <li><a href="index.php#Inicio">Inicio</a></li>
        <li><a href="salidas.php#Salidas">Salidas</a></li>
        <li><a href="form.php">Agregar Producto</a></li>
    </ul>
</nav>


<h1>Salidas Registradas</h1>
<div id="Salidas">
<table>
    <thead>
        <tr>
            <th>Código</th>
            <th>Producto</th>
            <th>Nombre del Producto</th> <!-- Nuevo campo -->
            <th>Cantidad</th>
            <th>Unidad</th>
            <th>Fecha</th>
            <th>Área</th>
            <th>Vale</th>
            <th>Observaciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Incluir el archivo de conexión
        include 'conexion.php';

        // Consultar la tabla de salidas
        $sql = "SELECT * FROM salidas";
        $result = $conn->query($sql);

        // Mostrar los datos en la tabla
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['codigo']}</td>
                        <td>{$row['producto_id']}</td>
                        <td>{$row['nombre_producto']}</td> <!-- Mostrar el nombre del producto -->
                        <td>{$row['cantidad']}</td>
                        <td>{$row['unidad']}</td>
                        <td>{$row['fecha']}</td>
                        <td>{$row['area']}</td>
                        <td>{$row['vale']}</td>
                        <td>{$row['observaciones']}</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='9'>No hay registros de salidas</td></tr>";
        }
        ?>
    </tbody>
</table>

</body>
</html>