<?php

class Historia {
   
    public const ESTADOS = ['nueva', 'activa', 'finalizada', 'impedimento'];

    private ?int $id;
    private string $titulo;
    private string $descripcion;
    private string $responsable;
    private string $estado;
    private int $puntos;
    private string $fechaCreacion;
    private ?string $fechaFinalizacion; // null mientras la historia no esté finalizada
    private int $sprintId;
    private ?string $createdAt;
    private ?string $updatedAt;

    public function __construct(
        ?int $id,
        string $titulo,
        string $descripcion,
        string $responsable,
        string $estado,
        int $puntos,
        string $fechaCreacion,
        ?string $fechaFinalizacion,
        int $sprintId,
        ?string $createdAt = null,
        ?string $updatedAt = null
    ) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->responsable = $responsable;
        $this->estado = $estado;
        $this->puntos = $puntos;
        $this->fechaCreacion = $fechaCreacion;
        $this->fechaFinalizacion = $fechaFinalizacion;
        $this->sprintId = $sprintId;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): ?int { return $this->id; }
    public function getTitulo(): string { return $this->titulo; }
    public function getDescripcion(): string { return $this->descripcion; }
    public function getResponsable(): string { return $this->responsable; }
    public function getEstado(): string { return $this->estado; }
    public function getPuntos(): int { return $this->puntos; }
    public function getFechaCreacion(): string { return $this->fechaCreacion; }
    public function getFechaFinalizacion(): ?string { return $this->fechaFinalizacion; }
    public function getSprintId(): int { return $this->sprintId; }
    public function getCreatedAt(): ?string { return $this->createdAt; }
    public function getUpdatedAt(): ?string { return $this->updatedAt; }

    public function setId(?int $id): void { $this->id = $id; }
    public function setTitulo(string $titulo): void { $this->titulo = $titulo; }
    public function setDescripcion(string $descripcion): void { $this->descripcion = $descripcion; }
    public function setResponsable(string $responsable): void { $this->responsable = $responsable; }
    public function setEstado(string $estado): void { $this->estado = $estado; }
    public function setPuntos(int $puntos): void { $this->puntos = $puntos; }
    public function setFechaFinalizacion(?string $fechaFinalizacion): void { $this->fechaFinalizacion = $fechaFinalizacion; }
    public function setSprintId(int $sprintId): void { $this->sprintId = $sprintId; }
}
