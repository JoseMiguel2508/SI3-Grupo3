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

--------- Actualizar conductor ----------
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

-------Listar Rutas---------
DELIMITER $$

CREATE PROCEDURE ObtenerRutas()
BEGIN
    SELECT id_ruta, nombre FROM rutas;
END $$

DELIMITER ;

-------Listar Vehiculos sin Asignacion de Ruta---------
DELIMITER $$

CREATE PROCEDURE ObtenerVehiculosSinRuta()
BEGIN
    SELECT 
        a.id_asignacion,
        a.id_vehiculo,
        v.marca, 
        v.modelo, 
        v.numero_placa, 
        c.nombre_completo AS nombre_conductor
    FROM asignaciones_vehiculos a
    INNER JOIN vehiculos v ON a.id_vehiculo = v.id_vehiculo
    INNER JOIN conductores c ON a.id_conductor = c.id_conductor
    WHERE a.estado = 'activo'
    AND NOT EXISTS (
        SELECT 1 FROM asignaciones_rutas ar WHERE ar.id_asignacion_Vehiculo = a.id_asignacion
    );
END $$

DELIMITER ;

-------Insertar Asignacion---------
DELIMITER $$

CREATE PROCEDURE InsertarAsignacionRuta(
    IN p_id_ruta INT,
    IN p_id_asignacion_Vehiculo INT,
    IN p_hora_inicio DATETIME,
    IN p_hora_fin DATETIME,
    IN p_estado VARCHAR(20)
)
BEGIN
    INSERT INTO asignaciones_rutas (id_ruta, id_asignacion_Vehiculo, hora_inicio, hora_fin, estado) 
    VALUES (p_id_ruta, p_id_asignacion_Vehiculo, p_hora_inicio, p_hora_fin, p_estado);
END $$

DELIMITER ;

-------Listar Asignacion---------
DELIMITER $$

CREATE PROCEDURE ObtenerAsignacionesRutas()
BEGIN
    SELECT 
        a.id_asignacion, 
        v.modelo, 
        v.numero_placa, 
        c.nombre_completo, 
        a.hora_inicio, 
        a.hora_fin, 
        r.nombre AS nombre_ruta, 
        a.estado,
        av.id_vehiculo
    FROM asignaciones_rutas a
    INNER JOIN asignaciones_vehiculos av ON a.id_asignacion_vehiculo = av.id_asignacion
    INNER JOIN rutas r ON a.id_ruta = r.id_ruta
    INNER JOIN vehiculos v ON av.id_vehiculo = v.id_vehiculo
    INNER JOIN conductores c ON av.id_conductor = c.id_conductor
    order by id_asignacion asc;
END $$

DELIMITER ;

-------Eliminar Asignacion---------
DELIMITER $$

CREATE PROCEDURE EliminarAsignacionRuta(
    IN p_id_asignacion INT
)
BEGIN
    DELETE FROM asignaciones_rutas WHERE id_asignacion = p_id_asignacion;
END $$

DELIMITER ;


-------ListarAsignacionRutas---------
DELIMITER $$

CREATE PROCEDURE ListaVehiculoRuta()
BEGIN
    SELECT 
        ar.id_asignacion, 
        r.nombre AS nombre_ruta, 
        c.nombre_completo, 
        v.modelo, 
        v.numero_placa, 
        ar.hora_inicio, 
        ar.hora_fin, 
        ar.estado,
        r.latitud AS latitud_fin, 
        r.longitud AS longitud_fin
    FROM asignaciones_rutas ar
    JOIN rutas r ON ar.id_ruta = r.id_ruta
    JOIN asignaciones_vehiculos av ON ar.id_asignacion_vehiculo = av.id_asignacion
    JOIN vehiculos v ON av.id_vehiculo = v.id_vehiculo
    JOIN conductores c ON av.id_conductor = c.id_conductor
    WHERE ar.estado = 'en_proceso'
    ORDER BY ar.id_asignacion ASC;
END $$

DELIMITER ;

-------Agregar Ubicacion vehiculo---------

DELIMITER $$

CREATE PROCEDURE InsertarUbicacionVehiculo(
    IN p_id_vehiculo INT,
    IN p_latitud DECIMAL(10,8),
    IN p_longitud DECIMAL(11,8),
    IN p_direccion INT
)
BEGIN
    INSERT INTO ubicaciones (id_vehiculo, latitud, longitud, direccion, fecha_hora) 
    VALUES (p_id_vehiculo, p_latitud, p_longitud, p_direccion, NOW());
END $$

DELIMITER ;
