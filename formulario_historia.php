<?php
require 'conexion.php';
date_default_timezone_set('America/Bogota');

$sprints = $conexDB->query("select id, nombre from sprints order by fecha_inicio desc");
$estados = ['nueva', 'activa', 'finalizada', 'impedimento'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historia de usuario</title>
</head>

<body>
    <h1>Registrar historia de usuario</h1>
    <a href="index.php">Volver</a>

    <?php if ($sprints->num_rows == 0) { ?>
        <p>Primero debes <a href="formulario_sprint.php">crear un sprint</a>.</p>
    <?php } else { ?>
    <form action="operaciones/registrar_historia.php" method="post">
        <div>
            <label for="titulo">Título: </label>
            <input type="text" name="titulo" id="titulo" maxlength="150" required>
        </div>
        <div>
            <label for="descripcion">Descripción: </label>
            <textarea name="descripcion" id="descripcion" rows="4" required></textarea>
        </div>
        <div>
            <label for="responsable">Responsable: </label>
            <input type="text" name="responsable" id="responsable" maxlength="100" required>
        </div>
        <div>
            <label for="puntos">Puntos de complejidad: </label>
            <input type="number" name="puntos" id="puntos" min="1" required>
        </div>
        <div>
            <label for="estado">Estado: </label>
            <select name="estado" id="estado" required>
                <?php
                foreach ($estados as $e) {
                    echo "<option value=\"$e\">$e</option>";
                }
                ?>
            </select>
        </div>
        <div>
            <label for="sprint_id">Sprint: </label>
            <select name="sprint_id" id="sprint_id" required>
                <?php
                while ($s = $sprints->fetch_assoc()) {
                    echo '<option value="' . $s['id'] . '">' . htmlspecialchars($s['nombre']) . '</option>';
                }
                ?>
            </select>
        </div>
        <div>
            <button type="submit">Guardar</button>
        </div>
    </form>
    <?php } ?>
</body>

</html>
<?php $conexDB->close(); ?>