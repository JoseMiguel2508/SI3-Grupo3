
----///////PROCEDURES///////----

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

--actualizar_conductor
DELIMITER $$

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
END$$

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
