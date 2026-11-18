<?php

require_once __DIR__ . '/historias_controller_interface.php';
require_once __DIR__ . '/../mappers/historias_controller_mapper.php';
require_once __DIR__ . '/../../models/repositories/historias_repository_interface.php';

class HistoriasController implements HistoriasControllerInterface {
    private HistoriasRepositoryInterface $repository;

    public function __construct(HistoriasRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function registrarSprint(array $postData): bool {
        $sprint = HistoriasControllerMapper::mapPostToSprint($postData);

        if ($sprint->getNombre() === ''
            || $sprint->getFechaInicio() === ''
            || $sprint->getFechaFin() === ''
            || $sprint->getFechaFin() < $sprint->getFechaInicio()) {
            return false;
        }

        try {
            return $this->repository->crearSprint($sprint) > 0;
        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }

    public function obtenerTodosLosSprints(): array {
        return $this->repository->obtenerTodosLosSprints();
    }

    public function registrarHistoria(array $postData): bool {
        $historia = HistoriasControllerMapper::mapPostToHistoria($postData);

        if (!$this->historiaEsValida($historia)) {
            return false;
        }

        try {
            return $this->repository->crearHistoria($historia);
        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }

    public function obtenerHistorialCompleto(): array {
        $historial = [];

        foreach ($this->repository->obtenerTodosLosSprints() as $sprint) {
            $historial[] = [
                'sprint'    => $sprint,
                'historias' => $this->repository->obtenerHistoriasPorSprint($sprint->getId())
            ];
        }

        return $historial;
    }

    public function obtenerHistoriaPorId(int $id): ?Historia {
        return $this->repository->obtenerHistoriaPorId($id);
    }

    public function actualizarHistoria(array $postData): bool {
        $historia = HistoriasControllerMapper::mapPostToHistoria($postData);

        if ($historia->getId() === null || !$this->historiaEsValida($historia)) {
            return false;
        }

        try {
            return $this->repository->actualizarHistoria($historia);
        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }

    public function eliminarHistoria(int $id): bool {
        try {
            return $this->repository->eliminarHistoria($id);
        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }

    public function obtenerInforme(): array {
        return [
            'general'        => $this->repository->obtenerResumenGeneral(),
            'porResponsable' => $this->repository->obtenerResumenPorResponsable(),
            'porSprint'      => $this->repository->obtenerResumenPorSprint()
        ];
    }

    private function historiaEsValida(Historia $historia): bool {
        return $historia->getTitulo() !== ''
            && $historia->getDescripcion() !== ''
            && $historia->getResponsable() !== ''
            && $historia->getPuntos() >= 1
            && in_array($historia->getEstado(), Historia::ESTADOS, true)
            && $historia->getSprintId() > 0;
    }
}
