<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; 

function enviarEmailIncidencia($id, $mysqli) {
    $sentencia = $mysqli->prepare("SELECT title, descripcio FROM incidencies WHERE id = ?");
    $sentencia->bind_param("i", $id);
    $sentencia->execute();
    $resultado = $sentencia->get_result();
    $incidencia = $resultado->fetch_assoc();

    if (!$incidencia) return false;

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();                                          
        $mail->Host       = 'smtp.g1.daw.inspedralbes.cat';                    
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = 'admin@g1.daw.inspedralbes.cat';              
        $mail->Password   = 'Admin1234.';                        
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        $mail->setFrom('admin@g1.daw.inspedralbes.cat', 'Sistema de Logs');
        $mail->addAddress('a22iliakiaki@inspedralbes.cat'); 

        $mail->isHTML(true);                                  
        $mail->Subject = 'Nova Incidència: ' . $incidencia['title'];
        $mail->Body    = "<h2>Detalls:</h2><p>{$incidencia['descripcio']}</p>";
        $mail->AltBody = $incidencia['descripcio'];

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}