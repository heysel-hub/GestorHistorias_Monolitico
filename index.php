<?php
require 'conexion.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Historias de Usuario</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <nav>
        <a href="index.php">Historias</a>
        <a href="formulario_historia.php">Nueva historia</a>
        <a href="sprints.php">Sprints</a>
        <a href="informe.php">Informe</a>
    </nav>

    <h1>Historias de usuario por sprint</h1>

    <?php
    if (!empty($_GET['error'])) {
        echo '<div class="mensaje error">Error al procesar la operación.</div>';
    }
    if (!empty($_GET['ok'])) {
        echo '<div class="mensaje ok">Operación realizada correctamente.</div>';
    }

    $sprints = $conexDB->query("select * from sprints order by fecha_inicio desc");

    while ($sprint = $sprints->fetch_assoc()) {
        echo '<section class="sprint">';
        echo '    <div class="sprint-encabezado">';
        echo '        <h2>' . htmlspecialchars($sprint['nombre']) . '</h2>';
        echo '        <span class="fechas">' . $sprint['fecha_inicio'] . ' &rarr; ' . $sprint['fecha_fin'] . '</span>';
        echo '    </div>';

        $sql = "select * from historias where sprint_id=" . (int)$sprint['id'] . " order by id";
        $historias = $conexDB->query($sql);

        echo '    <div class="tarjetas">';
        if ($historias->num_rows > 0) {
            while ($h = $historias->fetch_assoc()) {
                echo '<div class="tarjeta ' . $h['estado'] . '">';
                echo '    <h3>' . htmlspecialchars($h['titulo']) . '</h3>';
                echo '    <p><span class="estado ' . $h['estado'] . '">' . $h['estado'] . '</span></p>';
                echo '    <p>' . htmlspecialchars($h['descripcion']) . '</p>';
                echo '    <p><b>Responsable: </b>' . htmlspecialchars($h['responsable']) . '</p>';
                echo '    <p><b>Puntos: </b>' . $h['puntos'] . '</p>';
                echo '    <p><b>Creada: </b>' . $h['fecha_creacion'] . '</p>';
                if (!empty($h['fecha_finalizacion'])) {
                    echo '    <p><b>Finalizada: </b>' . $h['fecha_finalizacion'] . '</p>';
                }
                echo '    <div class="acciones">';
                echo '        <a href="formulario_historia.php?id=' . $h['id'] . '">Modificar</a>';
                echo '        <a class="borrar" href="operaciones/borrar_historia.php?id=' . $h['id'] . '" onclick="return confirm(\'¿Borrar esta historia?\');">Borrar</a>';
                echo '    </div>';
                echo '</div>';
            }
        } else {
            echo '<p class="vacio">Este sprint aún no tiene historias.</p>';
        }
        echo '    </div>';
        echo '</section>';
    }
    $conexDB->close();
    ?>
</body>

</html>