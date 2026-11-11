<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sprint</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <nav>
        <a href="index.php">Historias</a>
        <a href="formulario_historia.php">Nueva historia</a>
        <a href="sprints.php">Sprints</a>
        <a href="informe.php">Informe</a>
    </nav>

    <h1>Registrar sprint</h1>

    <form action="operaciones/registrar_sprint.php" method="post">
        <div>
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" maxlength="100" required>
        </div>
        <div>
            <label for="fecha_inicio">Fecha de inicio</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio" required>
        </div>
        <div>
            <label for="fecha_fin">Fecha de fin</label>
            <input type="date" name="fecha_fin" id="fecha_fin" required>
        </div>
        <div>
            <button type="submit">Guardar</button>
        </div>
    </form>
</body>

</html>