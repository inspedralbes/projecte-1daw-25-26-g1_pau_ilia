<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; 
include_once "conneccion.php";

$id = $mysqli->insert_id; 




$sentencia = $mysqli->prepare("SELECT id, title, descripcio, departament_id, data_incidencia FROM incidencies WHERE id = ?");
$sentencia->bind_param("i", $id);
$sentencia->execute();
$resultado = $sentencia->get_result();
$incidencia = $resultado->fetch_assoc();


$mail = new PHPMailer(true);

try {
    $mail->isSMTP();                                          
    $mail->Host       = 'smtp.g1.daw.inspedralbes.cat';                    
    $mail->SMTPAuth   = true;                                   
    $mail->Username   = 'admin@g1.daw.inspedralbes.cat';              
    $mail->Password   = 'Admin1234.';                        
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
    $mail->Port       = 587;                    

    $mail->setFrom('admin@g1.daw.inspedralbes.cat', 'Sistema de Logs');
    $mail->addAddress('admin@g1.daw.inspedralbes.cat'); 

    $mail->isHTML(true);                                  
    $mail->Subject = 'Nueva Incidencia Creada';
    $mail->Body    = $incidencia['title'];
    $mail->AltBody = $incidencia['descripcio'];

    $mail->send();
    echo 'El missatge s’ha enviat correctament.';

} catch (Exception $e) {
    echo "El missatge no s’ha pogut enviar. Error de Mailer: {$mail->ErrorInfo}";

} catch (\Exception $e) {
    echo "S’ha produït un error general: {$e->getMessage()}";
}