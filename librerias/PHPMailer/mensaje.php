<?php

$contrasena = $_POST['contrasena'];

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
    $mail->setFrom('enviocontrasena2020@gmail.com', 'Sena');
    $mail->addAddress('dtuzzo33@gmail.com', 'Sro/Sra');     // Add a recipient

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Contraseña';
    $mail->Body    = 'Su contraseña temporal es: '.$contrasena;
    $mail->CharSet = 'UTF-8';

    $mail->send();
    echo 'Mensaje enviado exitosamente';

} catch (Exception $e) {
    echo "Error no se puedo enviar tu correo. Mailer Error: {$mail->ErrorInfo}";
}

?>

