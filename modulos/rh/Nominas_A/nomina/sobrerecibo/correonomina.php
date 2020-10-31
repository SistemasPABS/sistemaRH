    <?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    include_once('../../../../librerias/PHPMailer/src/PHPMailer.php');
    include_once('../../../../librerias/PHPMailer/src/Exception.php');
    include_once('../../../../librerias/PHPMailer/src/SMTP.php');

    $querycorreoautorizador ="SELECT * FROM vw_autorizadores WHERE plaza_id = $plaza";
    $resultcorreoautorizador = pg_query($conexion,$querycorreoautorizador);
    $mostrar=pg_fetch_array($resultcorreoautorizador);
    $correo=$mostrar['correo'];
    if($mostrar=pg_fetch_array($resultcorreoautorizador)){
    // Load Composer's autoloader
    //require 'vendor/autoload.php';

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'julieta.victoria.vargas@gmail.com';                     // SMTP username
            $mail->Password   = 'VictoriaVargas25';                               // SMTP password
            $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('julieta.victoria.vargas@gmail.com', 'Julieta Parra');
            $mail->addAddress('jnv1802@gmail.com');     // Add a recipient
            //$mail->addAddress('ellen@example.com');               // Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            /*Attachments
            $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name*/

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Nueva nomina creada';
            $body = file_get_contents("htmlnuevanominamail/nuevanomina.html");
            $mail->MsgHTML($body);
            /*$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';*/

            $mail->send();
            echo 'Correo enviado';
        }
        catch (Exception $e) {
            echo "Correo no pudo ser enviado. Mailer Error: {$mail->ErrorInfo}";
        }
    }

?>