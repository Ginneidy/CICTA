<?php
if(!isset($_POST['submit'])){
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

    //Validate first
    if (empty($nombre) || empty($email) || empty($apellidos) || empty($identificacion) || empty($profesion) || empty($empresa) || empty($pais)) {
        echo "Todos los datos son obligatorios!";
        
        exit;
    }
    if (IsInjected($email)) {
        echo "Email incorrecto!";
        exit;
    }
    if(!is_numeric($identificacion)){
        echo "<p> Número de identificación invalido </p>";
        exit;
    }
    $email_from = 'ginneidy@gmial.com'; //<== update the email address
    $email_subject = "Nuevo formulario";
    $email_body = "Un nuevo usuario se ha registrado: \n" .
        "Nombre: $nombre.\n" .
        "Apellidos: $apellidos.\n" .
        "Email: $email.\n" .
        "Identificación: $identificacion.\n" .
        "profesion: $profesion.\n";
        "emrpesa: $empresa.\n";
        "pais: $pais.\n";

    $to = "ginneidy@gmail.com"; //<== update the email address
    $headers = "From: $email_from \r\n";
    $headers.= "Reply-To: $email \r\n";
    //Send the email!
    mail($to, $email_subject, $email_body, $headers);
    //done. redirect to thank-you page.
    header('Location: index.html');


    // Function to validate against any email injection attempts
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
}
