<?php
/*
    Importamos las dependencias de PHPMailer
 * 
 * Para haccer funcionar esto usamos composer
 * -  composer require phpmailer/phpmailer
 * introducimos la carpeta 'vendor' generada en libraries
 * 
 * Los arcivos de composer a veces se suelen borrar, para arreglar esto simplemente sobreescribir
 * vendor soluciona el problema
 * 
*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$autoload=$_SERVER['DOCUMENT_ROOT'].'/Ejercicios_UT6_1_Victor_Valdes_Cobos/vendor/autoload.php';
//Load Composer's autoloader
if(file_exists($autoload)){
    require $autoload;
    $mail = new PHPMailer(true); //Objeto de la clase PHPMailer
    
}else{
    trigger_error("No se ha encontrado el archivo autoload, para que funcione MailServer, intentelo de nuevo.", E_USER_ERROR);
}



try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username ='concesionarioconce@gmail.com'; // Cambia esto
    $mail->Password = 'foad dfhp viwj vhmo'; //  // 'conce200#'
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->Timeout = 5;

    $mail->setFrom('concesionarioconce@gmail.com');
    $mail->addAddress($_SESSION['email']); // Cambia esto al destinatario real

    $mail->isHTML(false);
    $mail->Subject = "Inicio de sesion con tu cuenta";
    $mail->Body = "Se ha iniciado sesión en tu cuenta.";

    $mail->send();
    echo 'Correo enviado con éxito';
} catch (Exception $exc) {
    echo 'Error al enviar el correo. Detalles: ' . $exc->getMessage();
}

