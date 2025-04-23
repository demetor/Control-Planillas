<?php

require_once('../../Conexion/conexion.php');
$obj = new conectar();
$conexion = $obj->conexion();

$fileContacts = $_FILES['fileContacts'];
$fileContacts = file_get_contents($fileContacts['tmp_name']);

$fileContacts = explode("\n", $fileContacts);
$fileContacts = array_filter($fileContacts);

// preparar contactos (convertirlos en array)
foreach ($fileContacts as $contact) {
    $contactList[] = explode(";", $contact);
}

// Eliminar el primer elemento del array
array_shift($contactList);

// Inicializar una variable de bandera
$success = true;

// Recorrer el array de contactos
foreach ($contactList as $contactData) {
    // Procesar los datos
    $nombre = $contactData[0];
    $Correo = $contactData[1];
    $Cedula = $contactData[2];
    $rol = $contactData[3];
    $cotrasena = $contactData[2]; // Asegúrate de que este índice sea correcto

    // Hashear la contraseña
    $password = password_hash($cotrasena, PASSWORD_DEFAULT);

    // Preparar la consulta
    $sql = "CALL insertar_usuario(?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssii", $nombre, $Correo, $password, $Cedula, $rol);

    // Ejecutar la consulta
    if (!$stmt->execute()) {
        // Si hay un error, cambiar la bandera a false
        $success = false;
    }

    // Cerrar la declaración
    $stmt->close();
}

// Mostrar el mensaje de éxito o error al final
if ($success) {
    echo "success";  // Todas las inserciones fueron exitosas
} else {
    echo "error: No se pudieron insertar todos los usuarios.";  // Hubo al menos un error
}