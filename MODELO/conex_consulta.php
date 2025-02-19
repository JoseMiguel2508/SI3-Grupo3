<?php

function ejecutarConsulta($query) {
    $host = "localhost";
    $user = "root";
    $password = "";
    $dbname = "sdsdsdsdsdsdsdsdsdsdsdsds";

    // Crear la conexión
    $con = mysqli_connect($host, $user, $password, $dbname);

    // Verificar la conexión
    if (!$con) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    // Establecer el conjunto de caracteres
    $con->set_charset("utf8");

    // Ejecutar la consulta
    $result = $con->query($query);

    // Verificar si hubo un error al ejecutar la consulta
    if ($con->error) {
        die("Error en la consulta: " . $con->error);
    }

    // Cerrar la conexión
    $con->close();

    // Devolver el resultado
    return $result;
}   

?>