<?php

require_once __DIR__ . '/historias_repository_interface.php';
require_once __DIR__ . '/../database/historias_db_interface.php';
require_once __DIR__ . '/../mappers/historias_model_mapper.php';

class HistoriasRepository implements HistoriasRepositoryInterface {
    private mysqli $conn;

    private const COLUMNAS_RESUMEN = "
        count(*) as total,
        coalesce(sum(estado = 'finalizada'), 0) as finalizadas,
        coalesce(sum(estado in ('nueva', 'activa')), 0) as pendientes,
        coalesce(sum(estado = 'impedimento'), 0) as impedimentos,
        coalesce(sum(puntos), 0) as puntos_total,
        coalesce(sum(case when estado = 'finalizada' then puntos else 0 end), 0) as puntos_finalizados
    ";

    public function __construct(HistoriasDbInterface $db) {
        $this->conn = $db->getConnection();
    }

    public function crearSprint(Sprint $sprint): int {
        $sql = "INSERT INTO sprints (nombre, fecha_inicio, fecha_fin) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        $nombre = $sprint->getNombre();
        $fechaInicio = $sprint->getFechaInicio();
        $fechaFin = $sprint->getFechaFin();

        $stmt->bind_param("sss", $nombre, $fechaInicio, $fechaFin);
        $stmt->execute();

        $nuevoId = $stmt->insert_id;
        $stmt->close();

        return $nuevoId;
    }

    public function obtenerTodosLosSprints(): array {
        $result = $this->conn->query("SELECT * FROM sprints ORDER BY fecha_inicio DESC, id DESC");

        $sprints = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $sprints[] = HistoriasModelMapper::mapRowToSprint($row);
            }
        }
        return $sprints;
    }

    public function obtenerSprintPorId(int $id): ?Sprint {
        $stmt = $this->conn->prepare("SELECT * FROM sprints WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $row ? HistoriasModelMapper::mapRowToSprint($row) : null;
    }


    public function crearHistoria(Historia $historia): bool {
        $sql = "INSERT INTO historias
                    (titulo, descripcion, responsable, estado, puntos, fecha_creacion, fecha_finalizacion, sprint_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        $titulo = $historia->getTitulo();
        $descripcion = $historia->getDescripcion();
        $responsable = $historia->getResponsable();
        $estado = $historia->getEstado();
        $puntos = $historia->getPuntos();
        $fechaCreacion = $historia->getFechaCreacion();
        $fechaFinalizacion = $historia->getFechaFinalizacion();
        $sprintId = $historia->getSprintId();

        $stmt->bind_param("ssssissi", $titulo, $descripcion, $responsable, $estado, $puntos, $fechaCreacion, $fechaFinalizacion, $sprintId);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }

    public function obtenerHistoriasPorSprint(int $sprintId): array {
        $stmt = $this->conn->prepare("SELECT * FROM historias WHERE sprint_id = ? ORDER BY id ASC");
        $stmt->bind_param("i", $sprintId);
        $stmt->execute();

        $result = $stmt->get_result();
        $historias = [];
        while ($row = $result->fetch_assoc()) {
            $historias[] = HistoriasModelMapper::mapRowToHistoria($row);
        }
        $stmt->close();

        return $historias;
    }

    public function obtenerHistoriaPorId(int $id): ?Historia {
        $stmt = $this->conn->prepare("SELECT * FROM historias WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $row ? HistoriasModelMapper::mapRowToHistoria($row) : null;
    }

    public function actualizarHistoria(Historia $historia): bool {
        $sql = "UPDATE historias
                SET titulo = ?, descripcion = ?, responsable = ?, estado = ?, puntos = ?, sprint_id = ?,
                    fecha_finalizacion = IF(? = 'finalizada', COALESCE(fecha_finalizacion, CURDATE()), NULL)
                WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        $titulo = $historia->getTitulo();
        $descripcion = $historia->getDescripcion();
        $responsable = $historia->getResponsable();
        $estado = $historia->getEstado();
        $puntos = $historia->getPuntos();
        $sprintId = $historia->getSprintId();
        $id = $historia->getId();

        $stmt->bind_param("ssssiisi", $titulo, $descripcion, $responsable, $estado, $puntos, $sprintId, $estado, $id);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }

    public function eliminarHistoria(int $id): bool {
        $stmt = $this->conn->prepare("DELETE FROM historias WHERE id = ?");
        $stmt->bind_param("i", $id);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }

    public function obtenerResumenGeneral(): array {
        $sql = "SELECT " . self::COLUMNAS_RESUMEN . " FROM historias";
        $row = $this->conn->query($sql)->fetch_assoc();
        return $this->convertirFilaResumen($row);
    }

    public function obtenerResumenPorResponsable(): array {
        $sql = "SELECT responsable, " . self::COLUMNAS_RESUMEN . "
                FROM historias
                GROUP BY responsable
                ORDER BY responsable";
        $result = $this->conn->query($sql);

        $filas = [];
        while ($row = $result->fetch_assoc()) {
            $fila = $this->convertirFilaResumen($row);
            $fila['responsable'] = $row['responsable'];
            $filas[] = $fila;
        }
        return $filas;
    }

    public function obtenerResumenPorSprint(): array {
        $sql = "SELECT s.nombre, " . self::COLUMNAS_RESUMEN . "
                FROM historias h
                INNER JOIN sprints s ON s.id = h.sprint_id
                GROUP BY s.id, s.nombre
                ORDER BY s.fecha_inicio DESC";
        $result = $this->conn->query($sql);

        $filas = [];
        while ($row = $result->fetch_assoc()) {
            $fila = $this->convertirFilaResumen($row);
            $fila['nombre'] = $row['nombre'];
            $filas[] = $fila;
        }
        return $filas;
    }

    private function convertirFilaResumen(array $row): array {
        return [
            'total'              => (int) $row['total'],
            'finalizadas'        => (int) $row['finalizadas'],
            'pendientes'         => (int) $row['pendientes'],
            'impedimentos'       => (int) $row['impedimentos'],
            'puntos_total'       => (int) $row['puntos_total'],
            'puntos_finalizados' => (int) $row['puntos_finalizados'],
        ];
    }
}
