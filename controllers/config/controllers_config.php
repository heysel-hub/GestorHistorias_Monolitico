<?php

date_default_timezone_set('America/Bogota');

require_once __DIR__ . '/../../models/config/models_config.php';
require_once __DIR__ . '/../mappers/historias_controller_mapper.php';
require_once __DIR__ . '/../historias/historias_controller_interface.php';
require_once __DIR__ . '/../historias/historias_controller.php';

function obtenerHistoriasController(): HistoriasController {
    $db = new HistoriasDb();
    $repository = new HistoriasRepository($db);
    return new HistoriasController($repository);
}
