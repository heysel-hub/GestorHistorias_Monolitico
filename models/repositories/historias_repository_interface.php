<?php

require_once __DIR__ . '/../entities/sprint.php';
require_once __DIR__ . '/../entities/historia.php';

interface HistoriasRepositoryInterface {
  
    public function crearSprint(Sprint $sprint): int;
    public function obtenerTodosLosSprints(): array;
    public function obtenerSprintPorId(int $id): ?Sprint;

   
    public function crearHistoria(Historia $historia): bool;
    public function obtenerHistoriasPorSprint(int $sprintId): array;
    public function obtenerHistoriaPorId(int $id): ?Historia;
    public function actualizarHistoria(Historia $historia): bool;
    public function eliminarHistoria(int $id): bool;

    public function obtenerResumenGeneral(): array;
    public function obtenerResumenPorResponsable(): array;
    public function obtenerResumenPorSprint(): array;
}
