CREATE DATABASE IF NOT EXISTS gestor_historias_db;
USE gestor_historias_db;

-- Tabla de Sprints
CREATE TABLE sprints (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de Historias de Usuario
CREATE TABLE historias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT NOT NULL,
    responsable VARCHAR(100) NOT NULL,
    estado ENUM('nueva', 'activa', 'finalizada', 'impedimento') NOT NULL DEFAULT 'nueva',
    puntos INT NOT NULL,
    fecha_creacion DATE NOT NULL,
    fecha_finalizacion DATE DEFAULT NULL,
    sprint_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    -- Clave foránea
    FOREIGN KEY (sprint_id) REFERENCES sprints(id) ON DELETE CASCADE
);