<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: ../index.php');
    exit;
}
require '../conexion.php';

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

$fecha_creacion = date('Y-m-d');
$fecha_finalizacion = ($estado == 'finalizada') ? $fecha_creacion : null;

$sql = "insert into historias (titulo, descripcion, responsable, estado, puntos, fecha_creacion, fecha_finalizacion, sprint_id) values (?,?,?,?,?,?,?,?)";
$stmt = $conexDB->prepare($sql);
$stmt->bind_param('ssssissi', $titulo, $descripcion, $responsable, $estado, $puntos, $fecha_creacion, $fecha_finalizacion, $sprint_id);

if ($stmt->execute()) {
    header('Location: ../index.php?ok=1');
} else {
    header('Location: ../index.php?error=1');
}
$stmt->close();
$conexDB->close();