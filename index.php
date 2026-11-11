<?php
require 'conexion.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Historias de Usuario</title>
</head>

<body>
    <h1>Historias de usuario por sprint</h1>
    <a href="formulario_historia.php">Registrar una historia</a> |
    <a href="sprints.php">Sprints</a>

    <?php
    if (!empty($_GET['error'])) {
        echo '<div>Error al procesar la operación.</div>';
    }
    if (!empty($_GET['ok'])) {
        echo '<div>Operación realizada correctamente.</div>';
    }

    $sprints = $conexDB->query("select * from sprints order by fecha_inicio desc");

    while ($sprint = $sprints->fetch_assoc()) {
        echo '<h2>' . htmlspecialchars($sprint['nombre']) . '</h2>';
        echo '<p>' . $sprint['fecha_inicio'] . ' a ' . $sprint['fecha_fin'] . '</p>';

        $sql = "select * from historias where sprint_id=" . (int)$sprint['id'] . " order by id";
        $historias = $conexDB->query($sql);

        if ($historias->num_rows > 0) {
            while ($h = $historias->fetch_assoc()) {
                echo '<div style="border:1px solid #000; padding:8px; margin:8px 0;">';
                echo '    <h3>' . htmlspecialchars($h['titulo']) . '</h3>';
                echo '    <p><b>Estado: </b>' . $h['estado'] . '</p>';
                echo '    <p>' . htmlspecialchars($h['descripcion']) . '</p>';
                echo '    <p><b>Responsable: </b>' . htmlspecialchars($h['responsable']) . '</p>';
                echo '    <p><b>Puntos: </b>' . $h['puntos'] . '</p>';
                echo '    <p><b>Creada: </b>' . $h['fecha_creacion'] . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p>Este sprint aún no tiene historias.</p>';
        }
    }
    $conexDB->close();
    ?>
</body>

</html>