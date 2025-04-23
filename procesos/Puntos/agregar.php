<?php
require_once "../../Conexion/conexion2/conexion.php";
require_once "../../librerias/phpqrcode/qrlib.php";  // Asegúrate de que esta librería esté correctamente incluida

$conexion = conexion();

// Captura de datos del formulario
$nombre_punto = $_POST['nombre_punto'];
$descripcion_punto = $_POST['Descipcion_punto'];  // Cambio: 'Descipcion_punto' a 'descripcion_punto' por consistencia
$ubicacion_punto = $_POST['Ubicacion_punto'];
$estado = $_POST['Estado'];

// Generar un código alfanumérico para el QR (esto puede ser un ID único u otro valor)
$codigoGenerado = strtoupper(substr(sha1(mt_rand()), 0, 20));  // Usando un valor único y aleatorio para el código QR

// Generar el contenido del QR
$contenido_qr = "Codigo: $codigoGenerado";

// Ruta para guardar el archivo QR
$qr_code_dir = '../../assets/qr_codes/';

// Verificar si la carpeta existe, si no, crearla
if (!file_exists($qr_code_dir)) {
    mkdir($qr_code_dir, 0777, true);  // 0777 da permisos de lectura, escritura y ejecución
}

// Ruta del archivo QR (se crea un nombre único)
$ruta_qr = $qr_code_dir . uniqid() . '.png';

// Generar el código QR y guardarlo en la ruta especificada
QRcode::png($contenido_qr, $ruta_qr);  // Genera el QR en la ruta especificada

// Llamar al procedimiento almacenado para insertar los datos
$sql = "CALL insertar_punto_colegio(?, ?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssssss", $nombre_punto, $descripcion_punto, $ubicacion_punto, $estado, $ruta_qr, $codigoGenerado);

// Ejecutar la consulta y manejar el resultado
if ($stmt->execute()) {
    echo "success";  // Si todo fue bien, se muestra un mensaje de éxito
} else {
    echo "error: No se pudo insertar el punto.";  // En caso de error
}

// Cerrar la conexión
$stmt->close();
$conexion->close();
?>

