<?php

require_once __DIR__ . '/../../models/entities/sprint.php';
require_once __DIR__ . '/../../models/entities/historia.php';

class HistoriasControllerMapper {

    public static function mapPostToSprint(array $postData): Sprint {
        $id = isset($postData['id']) && $postData['id'] !== '' ? (int) $postData['id'] : null;
        $nombre = trim($postData['nombre'] ?? '');
        $fechaInicio = trim($postData['fecha_inicio'] ?? '');
        $fechaFin = trim($postData['fecha_fin'] ?? '');

        return new Sprint($id, $nombre, $fechaInicio, $fechaFin);
    }

    public static function mapPostToHistoria(array $postData): Historia {
        $id = isset($postData['id']) && $postData['id'] !== '' ? (int) $postData['id'] : null;
        $titulo = trim($postData['titulo'] ?? '');
        $descripcion = trim($postData['descripcion'] ?? '');
        $responsable = trim($postData['responsable'] ?? '');
        $estado = trim($postData['estado'] ?? 'nueva');
        $puntos = (int) ($postData['puntos'] ?? 0);
        $sprintId = (int) ($postData['sprint_id'] ?? 0);

        $hoy = date('Y-m-d');
        $fechaFinalizacion = ($estado === 'finalizada') ? $hoy : null;

        return new Historia(
            $id,
            $titulo,
            $descripcion,
            $responsable,
            $estado,
            $puntos,
            $hoy,
            $fechaFinalizacion,
            $sprintId
        );
    }
}
