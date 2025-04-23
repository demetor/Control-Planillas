<?php
// Incluir el archivo de conexión
require_once "../../Conexion/conexion2/conexion.php";

// Obtener la conexión a la base de datos
$conexion = conexion();

// Consultar la base de datos para obtener los conteos
$query = "SELECT conteo_ayer, conteo_hoy FROM vista_conteo_controles_aseo";
$resultado = $conexion->query($query);

if ($resultado->num_rows > 0) {
    // Obtener los datos
    $fila = $resultado->fetch_assoc();
    $datos = [
        'ayer' => (int)$fila['conteo_ayer'],
        'hoy' => (int)$fila['conteo_hoy']
    ];
} else {
    $datos = [
        'ayer' => 0,
        'hoy' => 0
    ];
}

// Devolver los datos en formato JSON
header('Content-Type: application/json');
echo json_encode($datos);

// Cerrar la conexión
$conexion->close();
?>
