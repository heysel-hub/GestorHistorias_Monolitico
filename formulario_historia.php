<?php
require 'conexion.php';

$titulo_pagina = "Registrar historia de usuario";
$action = "operaciones/registrar_historia.php";
$id = "";
$titulo = "";
$descripcion = "";
$responsable = "";
$estado = "nueva";
$puntos = "";
$sprint_id = "";

if (!empty($_GET['id'])) {
    $id = (int)$_GET['id'];
    $titulo_pagina = "Modificar historia de usuario";
    $action = "operaciones/modificar_historia.php";

    $sql = "select * from historias where id=$id";
    $result = $conexDB->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $titulo = $row['titulo'];
        $descripcion = $row['descripcion'];
        $responsable = $row['responsable'];
        $estado = $row['estado'];
        $puntos = $row['puntos'];
        $sprint_id = $row['sprint_id'];
    }
}

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
    <h1><?php echo $titulo_pagina; ?></h1>
    <a href="index.php">Volver</a>

    <?php if ($sprints->num_rows == 0) { ?>
        <p>Primero debes <a href="formulario_sprint.php">crear un sprint</a>.</p>
    <?php } else { ?>
    <form action="<?php echo $action; ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div>
            <label for="titulo">Título: </label>
            <input type="text" name="titulo" id="titulo" maxlength="150" value="<?php echo htmlspecialchars($titulo); ?>" required>
        </div>
        <div>
            <label for="descripcion">Descripción: </label>
            <textarea name="descripcion" id="descripcion" rows="4" required><?php echo htmlspecialchars($descripcion); ?></textarea>
        </div>
        <div>
            <label for="responsable">Responsable: </label>
            <input type="text" name="responsable" id="responsable" maxlength="100" value="<?php echo htmlspecialchars($responsable); ?>" required>
        </div>
        <div>
            <label for="puntos">Puntos de complejidad: </label>
            <input type="number" name="puntos" id="puntos" min="1" value="<?php echo $puntos; ?>" required>
        </div>
        <div>
            <label for="estado">Estado: </label>
            <select name="estado" id="estado" required>
                <?php
                foreach ($estados as $e) {
                    $sel = ($e == $estado) ? 'selected' : '';
                    echo "<option value=\"$e\" $sel>$e</option>";
                }
                ?>
            </select>
        </div>
        <div>
            <label for="sprint_id">Sprint: </label>
            <select name="sprint_id" id="sprint_id" required>
                <?php
                while ($s = $sprints->fetch_assoc()) {
                    $sel = ($s['id'] == $sprint_id) ? 'selected' : '';
                    echo '<option value="' . $s['id'] . '" ' . $sel . '>' . htmlspecialchars($s['nombre']) . '</option>';
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