<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: ../index.php');
    exit;
}
require '../conexion.php';

$id = (int)$_POST['id'];
$titulo = trim($_POST['titulo']);
$descripcion = trim($_POST['descripcion']);
$responsable = trim($_POST['responsable']);
$estado = $_POST['estado'];
$puntos = (int)$_POST['puntos'];
$sprint_id = (int)$_POST['sprint_id'];

$estados = ['nueva', 'activa', 'finalizada', 'impedimento'];
if ($titulo == '' || $descripcion == '' || $responsable == '' || $puntos < 1 || !in_array($estado, $estados)) {
    header('Location: ../index.php?error=1');
    exit;
}

// Si pasa a "finalizada" se guarda la fecha (si ya la tenía se conserva); si cambia a otro estado se borra.
$sql = "update historias set titulo=?, descripcion=?, responsable=?, estado=?, puntos=?, sprint_id=?, ";
$sql .= " fecha_finalizacion = IF(? = 'finalizada', COALESCE(fecha_finalizacion, CURDATE()), NULL) ";
$sql .= " where id=?";
$stmt = $conexDB->prepare($sql);
$stmt->bind_param('ssssiisi', $titulo, $descripcion, $responsable, $estado, $puntos, $sprint_id, $estado, $id);

if ($stmt->execute()) {
    header('Location: ../index.php?ok=1');
} else {
    header('Location: ../index.php?error=1');
}
$stmt->close();
$conexDB->close();