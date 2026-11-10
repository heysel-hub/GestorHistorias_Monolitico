<?php
require 'conexion.php';
echo 'Conexión exitosa!!!<br>';

$result = $conexDB->query("select * from sprints");
echo 'Sprints encontrados: ' . $result->num_rows;

$conexDB->close();