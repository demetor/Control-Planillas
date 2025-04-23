<?php
require_once "../../Conexion/conexion2/conexion.php";
$conexion = conexion();

// Capturar datos del formulario
$id_punto = $_POST['id'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['Descipcion'];
$ubicacion = $_POST['Ubicacion'];
$estado = $_POST['Estado'];

// Llamar al procedimiento almacenado para actualizar el rol
$sql = "CALL actualizar_punto_colegio(?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("issss", $id_punto, $nombre, $descripcion, $ubicacion, $estado);  // 'i' para integer, 's' para string

// Ejecutar la consulta y manejar el resultado
if ($stmt->execute()) {
    echo "success"; // Enviado a AJAX para manejar con Alertify
} else {
    echo "error: " . $stmt->error;
}

// Cerrar la conexión
$stmt->close();
$conexion->close();
?>

