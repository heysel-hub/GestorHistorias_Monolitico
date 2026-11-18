<?php
require __DIR__ . '/../../conexion.php';

$id = (int)$_GET['id'];

$sql = "delete from historias where id=$id";
$result = $conexDB->query($sql);

if ($result) {
    header('Location: ../historias.php?ok=1');
} else {
    header('Location: ../historias.php?error=1');
}
$conexDB->close();