CREATE TABLE Empresa (
    Id_Empresa INT PRIMARY KEY,
    Nombre VARCHAR(255),
    Direccion VARCHAR(255),
    Telefono VARCHAR(50),
    Email VARCHAR(255)
);

CREATE TABLE Vehiculo (
    Id_Vehiculo INT PRIMARY KEY,
    Id_Empresa INT,
    Placa VARCHAR(50),
    Capacidad INT,
    Estado VARCHAR(50),
    FOREIGN KEY (Id_Empresa) REFERENCES Empresa(Id_Empresa)
);

CREATE TABLE Conductor (
    Id_Conductor INT PRIMARY KEY,
    Id_Empresa INT,
    Nombre VARCHAR(255),
    Apellido_Pat VARCHAR(255),
    Apellido_Mat VARCHAR(255),
    Licencia VARCHAR(50),
    tipo_licencia VARCHAR(50),
    FOREIGN KEY (Id_Empresa) REFERENCES Empresa(Id_Empresa)
);

CREATE TABLE Contacto (
    Id_Contacto INT PRIMARY KEY,
    Id_Conductor INT,
    Telefono VARCHAR(50),
    email VARCHAR(255),
    Glosa TEXT,
    FOREIGN KEY (Id_Conductor) REFERENCES Conductor(Id_Conductor)
);

CREATE TABLE Asignacion_Vehiculo (
    Id_Asignacion INT PRIMARY KEY,
    Id_Vehiculo INT,
    Id_Conductor INT,
    Fecha_Asignacion DATE,
    Fecha_Fin DATE,
    FOREIGN KEY (Id_Vehiculo) REFERENCES Vehiculo(Id_Vehiculo),
    FOREIGN KEY (Id_Conductor) REFERENCES Conductor(Id_Conductor)
);

CREATE TABLE Viaje (
    Id_Viaje INT PRIMARY KEY,
    Id_Vehiculo INT,
    Id_Conductor INT,
    Id_Ruta INT,
    Fecha_Salida DATE,
    Fecha_llegada DATE,
    Estado VARCHAR(50),
    Combustible_Consumido DECIMAL(10, 2),
    km_recorridos DECIMAL(10, 2),
    FOREIGN KEY (Id_Vehiculo) REFERENCES Vehiculo(Id_Vehiculo),
    FOREIGN KEY (Id_Conductor) REFERENCES Conductor(Id_Conductor),
    FOREIGN KEY (Id_Ruta) REFERENCES Ruta(Id_Ruta)
);

CREATE TABLE Gps (
    Id_Sensor INT PRIMARY KEY,
    Id_Vehiculo INT,
    Fecha_hora TIMESTAMP,
    Latitud DECIMAL(10, 6),
    Longitud DECIMAL(10, 6),
    Velocidad DECIMAL(10, 2),
    FOREIGN KEY (Id_Vehiculo) REFERENCES Vehiculo(Id_Vehiculo)
);

CREATE TABLE Ruta (
    Id_Ruta INT PRIMARY KEY,
    Id_Destino INT,
    Origen VARCHAR(255),
    FOREIGN KEY (Id_Destino) REFERENCES Destino(Id_Destino)
);

CREATE TABLE Alertas (
    Id_Alerta INT PRIMARY KEY,
    Id_Vehiculo INT,
    Tipo_alerta VARCHAR(50),
    Descripcion TEXT,
    Fecha_Hora TIMESTAMP,
    Estado VARCHAR(50),
    FOREIGN KEY (Id_Vehiculo) REFERENCES Vehiculo(Id_Vehiculo)
);

CREATE TABLE Modelo (
    Id_Modelo INT PRIMARY KEY,
    Id_Marca INT,
    Nombre VARCHAR(255),
    Tipo VARCHAR(50),
    año INT,
    FOREIGN KEY (Id_Marca) REFERENCES Marca(Id_Marca)
);

CREATE TABLE Marca (
    Id_Marca INT PRIMARY KEY,
    Nombre VARCHAR(255)
);

CREATE TABLE Destino (
    Id_Destino INT PRIMARY KEY,
    Nombre_Destino VARCHAR(255),
    Distancia DECIMAL(10, 2),
    Tiempo_Estimado DECIMAL(10, 2)
);
