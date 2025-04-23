<?php

$correosena_aprendiz = $_POST['correosena_aprendiz'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer\PHPMailer.php';
require 'PHPMailer\SMTP.php';
require 'PHPMailer\Exception.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;                      // Enable verbose debug output
    $mail->isSMTP(true);                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'enviocontrasena2020@gmail.com';                     // SMTP username
    $mail->Password   = 'Sena2020#';                               // SMTP password
    $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('enviocontrasena2020@gmail.com', 'Sistema de Gestión de Asistencias SENA 2020');
    $mail->addAddress($correosena_aprendiz, 'Sro/Sra');     // Add a recipient

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Reporte sobre inasistencia';
    $mail->Body    = 'Estimad@ aprendiz, este correo es para informarle que ya ha cumplido con las 3 inasistencias sin justificar y por ende tiene un llamado de atención. Gracias';
    $mail->CharSet = 'UTF-8';

    $mail->send();

    include '../../Vista/RecuperarPas/Pasa.php';


} catch (Exception $e) {

    include '../../Vista/RecuperarPas/Error.php';

}

?>