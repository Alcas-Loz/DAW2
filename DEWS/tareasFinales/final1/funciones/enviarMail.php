<?php
require 'src/PHPMailer.php';
require 'src/SMTP.php';
  function enviarEmail($email, $asunto, $body, $attach = null) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'albertocaserolozano@gmail.com';
        $mail->Password   = 'igjgdjcknotbfarz';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';
        $mail->setFrom('albertocaserolozano@gmail.com', 'Cursos CP');
        if(is_array($email)) {
            foreach($email as $correo) $mail->addAddress($correo);
        } else {
            $mail->addAddress($email);
        }
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body    = $body;
        if ($attach != null && file_exists($attach)) {
            $mail->addAttachment($attach);
        }
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false; 
    }
}
?>