<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: ../sprints.php');
    exit;
}
require '../conexion.php';

$nombre = trim($_POST['nombre']);
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];

if ($nombre == '' || $fecha_fin < $fecha_inicio) {
    header('Location: ../sprints.php?error=1');
    exit;
}

$sql = "insert into sprints (nombre, fecha_inicio, fecha_fin) values (?,?,?)";
$stmt = $conexDB->prepare($sql);
$stmt->bind_param('sss', $nombre, $fecha_inicio, $fecha_fin);

if ($stmt->execute()) {
    header('Location: ../sprints.php?ok=1');
} else {
    header('Location: ../sprints.php?error=1');
}
$stmt->close();
$conexDB->close();