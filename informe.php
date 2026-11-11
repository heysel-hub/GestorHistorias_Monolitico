<?php
require 'conexion.php';

// Cada consulta cuenta las historias por estado.
// "Pendientes" = nuevas + activas.
$columnas = "
    count(*) as total,
    sum(estado='finalizada') as finalizadas,
    sum(estado in ('nueva','activa')) as pendientes,
    sum(estado='impedimento') as impedimentos
";

$general = $conexDB->query("select $columnas from historias")->fetch_assoc();
$porResponsable = $conexDB->query("select responsable, $columnas from historias group by responsable order by responsable");
$porSprint = $conexDB->query("select s.nombre, $columnas from historias h inner join sprints s on s.id = h.sprint_id group by s.id, s.nombre order by s.fecha_inicio desc");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <nav>
        <a href="index.php">Historias</a>
        <a href="formulario_historia.php">Nueva historia</a>
        <a href="sprints.php">Sprints</a>
        <a href="informe.php">Informe</a>
    </nav>

    <h1>Informe de avance</h1>

    <h2>General</h2>
    <div class="resumen">
        <div class="dato"><strong><?php echo (int)$general['total']; ?></strong>Total</div>
        <div class="dato finalizadas"><strong><?php echo (int)$general['finalizadas']; ?></strong>Finalizadas</div>
        <div class="dato pendientes"><strong><?php echo (int)$general['pendientes']; ?></strong>Pendientes</div>
        <div class="dato impedimentos"><strong><?php echo (int)$general['impedimentos']; ?></strong>Con impedimento</div>
    </div>

    <h2>Por responsable</h2>
    <table>
        <tr>
            <th>Responsable</th>
            <th>Total</th>
            <th>Finalizadas</th>
            <th>Pendientes</th>
            <th>Con impedimento</th>
        </tr>
        <?php
        while ($row = $porResponsable->fetch_assoc()) {
            echo '<tr>';
            echo '    <td>' . htmlspecialchars($row['responsable']) . '</td>';
            echo '    <td>' . $row['total'] . '</td>';
            echo '    <td>' . $row['finalizadas'] . '</td>';
            echo '    <td>' . $row['pendientes'] . '</td>';
            echo '    <td>' . $row['impedimentos'] . '</td>';
            echo '</tr>';
        }
        ?>
    </table>

    <h2>Por sprint</h2>
    <table>
        <tr>
            <th>Sprint</th>
            <th>Total</th>
            <th>Finalizadas</th>
            <th>Pendientes</th>
            <th>Con impedimento</th>
        </tr>
        <?php
        while ($row = $porSprint->fetch_assoc()) {
            echo '<tr>';
            echo '    <td>' . htmlspecialchars($row['nombre']) . '</td>';
            echo '    <td>' . $row['total'] . '</td>';
            echo '    <td>' . $row['finalizadas'] . '</td>';
            echo '    <td>' . $row['pendientes'] . '</td>';
            echo '    <td>' . $row['impedimentos'] . '</td>';
            echo '</tr>';
        }
        $conexDB->close();
        ?>
    </table>
</body>

</html>