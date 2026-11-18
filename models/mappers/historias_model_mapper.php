<?php

require_once __DIR__ . '/../entities/sprint.php';
require_once __DIR__ . '/../entities/historia.php';

class HistoriasModelMapper {

    public static function mapRowToSprint(array $row): Sprint {
        return new Sprint(
            (int) $row['id'],
            $row['nombre'],
            $row['fecha_inicio'],
            $row['fecha_fin'],
            $row['created_at'] ?? null,
            $row['updated_at'] ?? null
        );
    }

    public static function mapRowToHistoria(array $row): Historia {
        return new Historia(
            (int) $row['id'],
            $row['titulo'],
            $row['descripcion'],
            $row['responsable'],
            $row['estado'],
            (int) $row['puntos'],
            $row['fecha_creacion'],
            $row['fecha_finalizacion'] ?? null,
            (int) $row['sprint_id'],
            $row['created_at'] ?? null,
            $row['updated_at'] ?? null
        );
    }
}
