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
        $mail->SMTPDebug = SMTP::DEBUG_SERVER; 

        $mail->isSMTP();                                          
        $mail->Host       = 'mail.g1.daw.inspedralbes.cat';  
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = 'admin@g1.daw.inspedralbes.cat';              
        $mail->Password   = 'Admin1234.';                        
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $mail->setFrom('admin@g1.daw.inspedralbes.cat', 'Sistema de Logs');
        $mail->addAddress('a23pauvilsor@inspedralbes.cat'); 

        $mail->isHTML(true);                                  
        $mail->Subject = 'Nova Incidència: ' . $incidencia['title'];
        $mail->Body    = "<h2>Detalls:</h2><p>{$incidencia['descripcio']}</p>";
        $mail->AltBody = $incidencia['descripcio'];

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Error al enviar: {$mail->ErrorInfo}"; 
        return false;
    }
}