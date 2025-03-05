-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS control_flotas; 
USE control_flotas; 

-- Tabla de Usuarios (solo administradores)
CREATE TABLE usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre_usuario VARCHAR(50) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    nombre_completo VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de Conductores (sin vínculo con usuarios)
CREATE TABLE conductores (
    id_conductor INT PRIMARY KEY AUTO_INCREMENT,
    nombre_completo VARCHAR(100) NOT NULL,
    numero_licencia VARCHAR(20) NOT NULL UNIQUE,
    tipo_licencia VARCHAR(20) NOT NULL,
    fecha_vencimiento_licencia DATE NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    foto VARCHAR(150),
    estado ENUM('disponible', 'en_ruta', 'fuera_servicio', 'inactivo') DEFAULT 'disponible'
);

-- Tabla de Vehículos
CREATE TABLE vehiculos (
    id_vehiculo INT PRIMARY KEY AUTO_INCREMENT,
    numero_placa VARCHAR(20) NOT NULL UNIQUE,
    marca VARCHAR(50) NOT NULL,
    modelo VARCHAR(50) NOT NULL,
    anio INT NOT NULL,
    capacidad DECIMAL(10,2),
    estado ENUM('activo', 'mantenimiento', 'inactivo') DEFAULT 'activo',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Asignaciones de Vehículos
CREATE TABLE asignaciones_vehiculos (
    id_asignacion INT PRIMARY KEY AUTO_INCREMENT,
    id_vehiculo INT NOT NULL,
    id_conductor INT NOT NULL,
    fecha_inicio DATETIME NOT NULL,
    fecha_fin DATETIME,
    estado ENUM('activo', 'completado', 'cancelado') DEFAULT 'activo',
    FOREIGN KEY (id_vehiculo) REFERENCES vehiculos(id_vehiculo),
    FOREIGN KEY (id_conductor) REFERENCES conductores(id_conductor)
);



-- Tabla de Ubicaciones
CREATE TABLE ubicaciones (
    id_ubicacion INT PRIMARY KEY AUTO_INCREMENT,
    id_vehiculo INT NOT NULL,
    latitud DECIMAL(10,8) NOT NULL,
    longitud DECIMAL(11,8) NOT NULL,
    direccion INT,
    fecha_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_vehiculo) REFERENCES vehiculos(id_vehiculo)
);

-- Tabla de Mantenimientos
CREATE TABLE registros_mantenimiento (
    id_mantenimiento INT PRIMARY KEY AUTO_INCREMENT,
    id_vehiculo INT NOT NULL,
    tipo_mantenimiento ENUM('preventivo', 'correctivo') NOT NULL,
    descripcion TEXT NOT NULL,
    costo DECIMAL(10,2) NOT NULL,
    fecha_servicio DATE NOT NULL,
    fecha_proximo_servicio DATE,
    estado ENUM('programado', 'en_proceso', 'completado') DEFAULT 'programado',
    creado_por INT,
    FOREIGN KEY (id_vehiculo) REFERENCES vehiculos(id_vehiculo),
    FOREIGN KEY (creado_por) REFERENCES usuarios(id_usuario)
);
--borren la columna
ALTER TABLE registros_mantenimiento DROP COLUMN notas;

-- Tabla de Rutas
CREATE TABLE rutas (
    id_ruta INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    punto_inicio VARCHAR(100) NOT NULL,
    punto_fin VARCHAR(100) NOT NULL,
    duracion_estimada INT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    latitud DECIMAL(10,8) NOT NULL,
    longitud DECIMAL(11,8) NOT NULL
);


INSERT INTO rutas (nombre, descripcion, punto_inicio, punto_fin, duracion_estimada, latitud, longitud) VALUES
('Santa Cruz - La Paz', 'Ruta desde Santa Cruz hasta La Paz', 'Terminal Bimodal de Santa Cruz', 'Terminal de Buses de La Paz', 17, -16.50000000, -68.15000000),
('Santa Cruz - Cochabamba', 'Ruta desde Santa Cruz hasta Cochabamba', 'Terminal Bimodal de Santa Cruz', 'Terminal de Buses de Cochabamba', 9, -17.39360000, -66.15730000),
('Santa Cruz - Sucre', 'Ruta desde Santa Cruz hasta Sucre', 'Terminal Bimodal de Santa Cruz', 'Terminal de Buses de Sucre', 10, -19.03330000, -65.26270000),
('Santa Cruz - Potosí', 'Ruta desde Santa Cruz hasta Potosí', 'Terminal Bimodal de Santa Cruz', 'Terminal de Buses de Potosí', 12, -19.58360000, -65.75310000),
('Santa Cruz - Oruro', 'Ruta desde Santa Cruz hasta Oruro', 'Terminal Bimodal de Santa Cruz', 'Terminal de Buses de Oruro', 14, -17.98330000, -67.15000000),
('Santa Cruz - Tarija', 'Ruta desde Santa Cruz hasta Tarija', 'Terminal Bimodal de Santa Cruz', 'Terminal de Buses de Tarija', 15, -21.53550000, -64.72960000),
('Santa Cruz - Trinidad', 'Ruta desde Santa Cruz hasta Trinidad', 'Terminal Bimodal de Santa Cruz', 'Terminal de Buses de Trinidad', 10, -14.83330000, -64.90000000),
('Santa Cruz - Cobija', 'Ruta desde Santa Cruz hasta Cobija', 'Terminal Bimodal de Santa Cruz', 'Terminal de Buses de Cobija', 24, -11.02640000, -68.76920000);

-- Tabla de Asignaciones de Rutas
CREATE TABLE asignaciones_rutas (
    id_asignacion INT PRIMARY KEY AUTO_INCREMENT,
    id_ruta INT NOT NULL,
    id_asignacion_vehiculo INT NOT NULL,
    hora_inicio DATETIME NOT NULL,
    hora_fin DATETIME,
    estado ENUM('pendiente', 'en_proceso', 'completado', 'cancelado') DEFAULT 'pendiente',
    FOREIGN KEY (id_ruta) REFERENCES rutas(id_ruta),
    FOREIGN KEY (id_asignacion_vehiculo) REFERENCES asignaciones_vehiculos(id_asignacion)
);

-- Tabla de Alertas
CREATE TABLE alertas (
    id_alerta INT PRIMARY KEY AUTO_INCREMENT,
    id_vehiculo INT NOT NULL,
    tipo_alerta ENUM('mantenimiento', 'velocidad', 'desvio_ruta', 'sistema') NOT NULL,
    descripcion TEXT NOT NULL,
    severidad ENUM('baja', 'media', 'alta') NOT NULL,
    estado ENUM('activa', 'reconocida', 'resuelta') DEFAULT 'activa',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_resolucion TIMESTAMP NULL DEFAULT NULL,
    resuelto_por INT NULL DEFAULT NULL,
    FOREIGN KEY (id_vehiculo) REFERENCES vehiculos(id_vehiculo) ON DELETE CASCADE,
    FOREIGN KEY (resuelto_por) REFERENCES usuarios(id_usuario) ON DELETE SET NULL
);


