<?php
require 'conexion.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sprints</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <nav>
        <a href="index.php">Historias</a>
        <a href="formulario_historia.php">Nueva historia</a>
        <a href="sprints.php">Sprints</a>
        <a href="informe.php">Informe</a>
    </nav>

    <h1>Sprints</h1>

    <?php
    if (!empty($_GET['error'])) {
        echo '<div class="mensaje error">Error al guardar los datos!!!</div>';
    }
    if (!empty($_GET['ok'])) {
        echo '<div class="mensaje ok">Operación realizada correctamente.</div>';
    }
    ?>

    <a class="boton" href="formulario_sprint.php">Registrar un sprint</a>

    <table>
        <tr>
            <th>Nombre</th>
            <th>Inicio</th>
            <th>Fin</th>
        </tr>
        <?php
        $sql = "select * from sprints order by fecha_inicio desc";
        $result = $conexDB->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '    <td>' . htmlspecialchars($row['nombre']) . '</td>';
                echo '    <td>' . $row['fecha_inicio'] . '</td>';
                echo '    <td>' . $row['fecha_fin'] . '</td>';
                echo '</tr>';
            }
        }
        $conexDB->close();
        ?>
    </table>
</body>

</html>