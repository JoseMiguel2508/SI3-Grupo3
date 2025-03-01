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

--------- Insertar Usuario ----------
DELIMITER $$

CREATE PROCEDURE InsertarUsuario(
    IN p_nombre_usuario VARCHAR(50),
    IN p_contrasena VARCHAR(255),
    IN p_nombre_completo VARCHAR(100),
    IN p_correo VARCHAR(100)
)
BEGIN
    INSERT INTO usuarios (nombre_usuario, contrasena, nombre_completo, correo, estado)
    VALUES (p_nombre_usuario, SHA2(p_contrasena, 256), p_nombre_completo, p_correo, 'activo');
END $$

DELIMITER ;


-------- validar Loguin ----------
DELIMITER $$

CREATE PROCEDURE ValidarUsuario(
    IN p_nombre_usuario VARCHAR(50),
    IN p_contrasena VARCHAR(255)
)
BEGIN
    SELECT id_usuario, nombre_usuario, nombre_completo, correo, estado
    FROM usuarios
    WHERE nombre_usuario = p_nombre_usuario
      AND contrasena = SHA2(p_contrasena, 256)
      AND estado = 'activo';
END $$

DELIMITER ;
-- Tabla de Conductores (sin vínculo con usuarios)
CREATE TABLE conductores (
    id_conductor INT PRIMARY KEY AUTO_INCREMENT,
    nombre_completo VARCHAR(100) NOT NULL,
    numero_licencia VARCHAR(20) NOT NULL UNIQUE,
    tipo_licencia VARCHAR(20) NOT NULL,
    fecha_vencimiento_licencia DATE NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    foto VARCHAR(15),
    estado ENUM('disponible', 'en_ruta', 'fuera_servicio', 'inactivo') DEFAULT 'disponible'
);
<<<<<<< HEAD
--Registrar conductores para    
DELIMITER $$

CREATE PROCEDURE registrar_conductor(
    IN nombre_completo VARCHAR(255),
    IN numero_licencia VARCHAR(50),
    IN tipo_licencia VARCHAR(50),
    IN fecha_vencimiento_licencia DATE,
    IN telefono VARCHAR(20),
    IN estado ENUM('disponible', 'en_ruta', 'fuera_servicio', 'inactivo'),
    IN foto VARCHAR(255)
)
BEGIN
    INSERT INTO conductores (nombre_completo, numero_licencia, tipo_licencia, fecha_vencimiento_licencia, telefono, estado, foto)
    VALUES (nombre_completo, numero_licencia, tipo_licencia, fecha_vencimiento_licencia, telefono, estado, foto);
END $$

DELIMITER ;

DELIMITER $$
--Actualizar conductor
CREATE PROCEDURE actualizar_conductor(
    IN p_id_conductor INT,
    IN p_nombre_completo VARCHAR(255),
    IN p_numero_licencia VARCHAR(50),
    IN p_tipo_licencia VARCHAR(50),
    IN p_fecha_vencimiento_licencia DATE,
    IN p_telefono VARCHAR(20),
    IN p_estado ENUM('disponible', 'en_ruta', 'fuera_servicio', 'inactivo'),
    IN p_foto VARCHAR(255)
)
BEGIN
    UPDATE conductores 
    SET 
        nombre_completo = p_nombre_completo,
        numero_licencia = p_numero_licencia,
        tipo_licencia = p_tipo_licencia,
        fecha_vencimiento_licencia = p_fecha_vencimiento_licencia,
        telefono = p_telefono,
        estado = p_estado,
        foto = p_foto
    WHERE id_conductor = p_id_conductor;
END $$

DELIMITER ;

=======
>>>>>>> c2bfcac47208a4ed0bb3c94c6d0d530405f6f482

-- Tabla de Vehículos
CREATE TABLE vehiculos (
    id_vehiculo INT PRIMARY KEY AUTO_INCREMENT,
    numero_placa VARCHAR(20) NOT NULL UNIQUE,
    marca VARCHAR(50) NOT NULL,
    modelo VARCHAR(50) NOT NULL,
    anio INT NOT NULL,
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

<<<<<<< HEAD
--Actulizar asignaciones_vehiculos (no esta terminado)
DELIMITER //

CREATE PROCEDURE editar_asignacion(
    IN p_id_asignacion INT,
    IN p_id_conductor INT,
    IN p_id_vehiculo INT,
    IN p_fecha_inicio DATETIME,
    IN p_fecha_fin DATETIME,
    IN p_estado ENUM('activo', 'completado', 'cancelado')
)
BEGIN
    UPDATE asignaciones_vehiculos
    SET id_conductor = p_id_conductor,
        id_vehiculo = p_id_vehiculo,
        fecha_inicio = p_fecha_inicio,
        fecha_fin = p_fecha_fin,
        estado = p_estado
    WHERE id_asignacion = p_id_asignacion;
END //

DELIMITER ;


=======
>>>>>>> c2bfcac47208a4ed0bb3c94c6d0d530405f6f482
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
    duracion_estimada INT,
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
    fecha_resolucion TIMESTAMP NULL DEFAULT NULL,
    resuelto_por INT NULL DEFAULT NULL,
    FOREIGN KEY (id_vehiculo) REFERENCES vehiculos(id_vehiculo) ON DELETE CASCADE,
    FOREIGN KEY (resuelto_por) REFERENCES usuarios(id_usuario) ON DELETE SET NULL
);

-- Agregar columna foto a conductores
ALTER TABLE conductores
ADD COLUMN foto VARCHAR(255);

-- Eliminar columnas ultima_ubicacion y ultima_actualizacion de vehiculos
ALTER TABLE vehiculos
DROP COLUMN ultimo_mantenimiento,
DROP COLUMN proximo_mantenimiento;

----///////PROCEDURES///////----

--------- Registrar Conductor ----------
DELIMITER $$

CREATE PROCEDURE registrar_conductor(
    IN nombre_completo VARCHAR(255),
    IN numero_licencia VARCHAR(50),
    IN tipo_licencia VARCHAR(50),
    IN fecha_vencimiento_licencia DATE,
    IN telefono VARCHAR(20),
    IN estado ENUM('disponible', 'en_ruta', 'fuera_servicio', 'inactivo'),
    IN foto VARCHAR(255)
)
BEGIN
    INSERT INTO conductores (nombre_completo, numero_licencia, tipo_licencia, fecha_vencimiento_licencia, telefono, estado, foto)
    VALUES (nombre_completo, numero_licencia, tipo_licencia, fecha_vencimiento_licencia, telefono, estado, foto);
END $$

DELIMITER ;

--------- Insertar Usuario ----------
DELIMITER $$

CREATE PROCEDURE InsertarUsuario(
    IN p_nombre_usuario VARCHAR(50),
    IN p_contrasena VARCHAR(255),
    IN p_nombre_completo VARCHAR(100),
    IN p_correo VARCHAR(100)
)
BEGIN
    INSERT INTO usuarios (nombre_usuario, contrasena, nombre_completo, correo, estado)
    VALUES (p_nombre_usuario, SHA2(p_contrasena, 256), p_nombre_completo, p_correo, 'activo');
END $$

DELIMITER ;

-------- Validar Login ----------
DELIMITER $$

CREATE PROCEDURE ValidarUsuario(
    IN p_nombre_usuario VARCHAR(50),
    IN p_contrasena VARCHAR(255)
)
BEGIN
    SELECT id_usuario, nombre_usuario, nombre_completo, correo, estado
    FROM usuarios
    WHERE nombre_usuario = p_nombre_usuario
      AND contrasena = SHA2(p_contrasena, 256)
      AND estado = 'activo';
END $$

DELIMITER ;

-------- Registrar Vehiculo ----------
DELIMITER $$

CREATE PROCEDURE RegistrarVehiculo(
    IN p_numero_placa VARCHAR(20),
    IN p_marca VARCHAR(50),
    IN p_modelo VARCHAR(50),
    IN p_anio INT,
    IN p_capacidad DECIMAL(10,2),
    IN p_estado ENUM('activo', 'mantenimiento', 'inactivo')
)
BEGIN
    -- Validar que la placa sea única
    IF EXISTS (SELECT 1 FROM vehiculos WHERE numero_placa = p_numero_placa) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'La placa ya está registrada';
    ELSE
        -- Insertar el nuevo vehículo
        INSERT INTO vehiculos (numero_placa, marca, modelo, anio, capacidad, estado)
        VALUES (p_numero_placa, p_marca, p_modelo, p_anio, p_capacidad, p_estado);
        
        -- Confirmar registro exitoso
        SELECT 'Registro exitoso' AS mensaje;
    END IF;
END $$

DELIMITER ;

-------- Editar resgistro de vehiculo ----------
DELIMITER $$

CREATE PROCEDURE EditarVehiculo(
    IN p_id_vehiculo INT,
    IN p_numero_placa VARCHAR(20),
    IN p_marca VARCHAR(50),
    IN p_modelo VARCHAR(50),
    IN p_anio INT,
    IN p_capacidad DECIMAL(10,2),
    IN p_estado ENUM('activo', 'mantenimiento', 'inactivo')
)
BEGIN
    -- Validar que la placa sea única, excepto para el vehículo que se está editando
    IF EXISTS (SELECT 1 FROM vehiculos WHERE numero_placa = p_numero_placa AND id_vehiculo != p_id_vehiculo) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'La placa ya está registrada para otro vehículo';
    ELSE
        -- Actualizar el vehículo
        UPDATE vehiculos
        SET numero_placa = p_numero_placa,
            marca = p_marca,
            modelo = p_modelo,
            anio = p_anio,
            capacidad = p_capacidad,
            estado = p_estado
        WHERE id_vehiculo = p_id_vehiculo;
        
        -- Confirmar actualización exitosa
        SELECT 'Actualización exitosa' AS mensaje;
    END IF;
END $$

DELIMITER ;

-------- Listar vehiculos ----------
DELIMITER $$

CREATE PROCEDURE ListarVehiculos()
BEGIN
    SELECT id_vehiculo, numero_placa, marca, modelo, anio, capacidad, estado, fecha_registro
    FROM vehiculos;
END $$

DELIMITER ;