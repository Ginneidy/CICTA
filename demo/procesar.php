<?php
/* Requerido para enviar correos */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './Enviarcorreo/Exception.php';
require './Enviarcorreo/PHPMailer.php';
require './Enviarcorreo/SMTP.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);
if (!isset($_POST['submit'])) {
    echo "<p>Debes llenar el formulario</p>";
    exit;
}
if (isset($_POST['submit'])) {
    $nombre = $_POST['fname'];
    $apellidos = $_POST['lname'];
    $email = $_POST['email'];
    $identificacion = $_POST['nid'];
    $profesion = $_POST['profesion'];
    $empresa = $_POST['empresa'];
    $pais = $_POST['pais'];
    if (empty($nombre) || empty($email) || empty($apellidos) || empty($identificacion) || empty($profesion) || empty($empresa) || empty($pais)) {
        echo "Todos los datos son obligatorios!";

        exit;
    }
    function IsInjected($str)
    {
        $injections = array(
            '(\n+)',
            '(\r+)',
            '(\t+)',
            '(%0A+)',
            '(%0D+)',
            '(%08+)',
            '(%09+)'
        );
        $inject = join('|', $injections);
        $inject = "/$inject/i";
        if (preg_match($inject, $str)) {
            return true;
        } else {
            return false;
        }
    }
    if (IsInjected($email)) {
        echo "Email incorrecto!";
        exit;
    }
    if (!is_numeric($identificacion)) {
        echo "<p> Número de identificación invalido </p>";
        exit;
    }
    try {
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        //Server settings
        $mail->SMTPDebug = 0;                       //Ver errores
        $mail->isSMTP();        
        $mail->Host       = 'smtp.gmail.com';       // SMTP de gmail
        $mail->SMTPAuth   = true;                   // Enable SMTP authentication
        $mail->Username   = 'ramaieeeud@udistrital.edu.co';                     // Correo del que envia, debe tener configurada la privacidad
        $mail->Password   = 'ramaestudiantil2020';                     // Contraseña del correo
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;                    // TCP puerto de gmail

        //Recipients
        $mail->setFrom('ramaieeeud@udistrital.edu.co'); // El que envia el correo
        $mail->addAddress('Rama.distrital@gmail.com'); //El que lo recibe 

        // Content
        $mail->isHTML(true);                  // Si tiene html en caso de venir de un fomrulario
        $mail->Subject = 'Incripcion a congreso'; //Asunto del correo
        $mail->Body    = "Un nuevo usuario se ha registrado: \n" .
            "Nombre: $nombre.\n" .
            "Apellidos: $apellidos.\n" .
            "Email: $email.\n" .
            "Identificación: $identificacion.\n" .
            "profesion: $profesion.\n" .
            "emrpesa: $empresa.\n" .
            "pais: $pais.\n"; 
            
            //cuerpo

        $mail->send();
        echo "<script>alert('Inscripción realizada exitosamente')</script>";
        echo "<script>setTimeout(\"location.href='index.html'\",1000)</script>";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
