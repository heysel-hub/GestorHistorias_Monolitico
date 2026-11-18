<?php

require_once __DIR__ . '/../../models/entities/sprint.php';
require_once __DIR__ . '/../../models/entities/historia.php';

interface HistoriasControllerInterface {
  
    public function registrarSprint(array $postData): bool;

    public function obtenerTodosLosSprints(): array;

    public function registrarHistoria(array $postData): bool;

    public function obtenerHistorialCompleto(): array;

    public function obtenerHistoriaPorId(int $id): ?Historia;

    public function actualizarHistoria(array $postData): bool;

    public function eliminarHistoria(int $id): bool;

    public function obtenerInforme(): array;
}
