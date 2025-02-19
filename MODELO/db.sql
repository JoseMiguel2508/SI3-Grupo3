-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS control_flotas;
USE control_flotas;

-- Tabla de Usuarios
CREATE TABLE usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre_usuario VARCHAR(50) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    nombre_completo VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    rol ENUM('administrador', 'supervisor', 'conductor') NOT NULL,
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de Conductores
CREATE TABLE conductores (
    id_conductor INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT,
    numero_licencia VARCHAR(20) NOT NULL UNIQUE,
    tipo_licencia VARCHAR(20) NOT NULL,
    fecha_vencimiento_licencia DATE NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    contacto_emergencia VARCHAR(100),
    telefono_emergencia VARCHAR(15),
    estado ENUM('disponible', 'en_ruta', 'fuera_servicio', 'inactivo') DEFAULT 'disponible',
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE SET NULL
);

-- Tabla de Vehículos
CREATE TABLE vehiculos (
    id_vehiculo INT PRIMARY KEY AUTO_INCREMENT,
    numero_placa VARCHAR(20) NOT NULL UNIQUE,
    marca VARCHAR(50) NOT NULL,
    modelo VARCHAR(50) NOT NULL,
    anio INT NOT NULL,
    tipo_vehiculo ENUM('camion', 'furgoneta', 'autobus', 'automovil') NOT NULL,
    capacidad DECIMAL(10,2),
    estado ENUM('activo', 'mantenimiento', 'inactivo') DEFAULT 'activo',
    ultimo_mantenimiento DATE,
    proximo_mantenimiento DATE,
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
    velocidad DECIMAL(5,2),
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
    notas TEXT,
    creado_por INT,
    FOREIGN KEY (id_vehiculo) REFERENCES vehiculos(id_vehiculo),
    FOREIGN KEY (creado_por) REFERENCES usuarios(id_usuario)
);

-- Tabla de Rutas
CREATE TABLE rutas (
    id_ruta INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    punto_inicio VARCHAR(100) NOT NULL,
    punto_fin VARCHAR(100) NOT NULL,
    duracion_estimada INT, -- en minutos
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

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
    fecha_resolucion TIMESTAMP,
    resuelto_por INT,
    FOREIGN KEY (id_vehiculo) REFERENCES vehiculos(id_vehiculo),
    FOREIGN KEY (resuelto_por) REFERENCES usuarios(id_usuario)
);

-- Índices para optimizar consultas
CREATE INDEX idx_estado_vehiculo ON vehiculos(estado);
CREATE INDEX idx_estado_conductor ON conductores(estado);
CREATE INDEX idx_fecha_ubicacion ON ubicaciones(fecha_hora);
CREATE INDEX idx_fecha_mantenimiento ON registros_mantenimiento(fecha_servicio);
CREATE INDEX idx_estado_ruta ON rutas(estado);
CREATE INDEX idx_estado_alerta ON alertas(estado);