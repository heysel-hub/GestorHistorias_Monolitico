<?php
require '../conexion.php';

$id = (int)$_GET['id'];

$sql = "delete from historias where id=$id";
$result = $conexDB->query($sql);

if ($result) {
    header('Location: ../index.php?ok=1');
} else {
    header('Location: ../index.php?error=1');
}
$conexDB->close();