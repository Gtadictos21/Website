<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '/var/www/html/vendor/phpmailer/phpmailer/src/Exception.php';
    require '/var/www/html/vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require '/var/www/html/vendor/phpmailer/phpmailer/src/SMTP.php';

    // Secretos

    $json = file_get_contents('/var/www/config.json');
    $decode = json_decode($json);
    $SMTP_server = $decode->SMTP;
    $email_address = $decode->email;
    $password = $decode->password;


    // Seteo de hora

    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $date = date('d/m/Y h:i:s a', time());

    // Cloudflare IP & Pais

    $IP = $_SERVER["HTTP_CF_CONNECTING_IP"]; // IP del visitante
    $PAIS = $_SERVER["HTTP_CF_IPCOUNTRY"]; // Pais del visitante

    if ($IP === NULL){
        $IP = "Desconocida";
    }

    if ($PAIS === NULL){
        $PAIS = "Desconocido";
    }

    // Formulario de contacto 

    $mail = new PHPMailer(true);

    if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['comment'];
    $mailto = '<a href="mailto:'.$email.'">'.$email.'</a>';

    try{
        $mail->isSMTP();
        $mail->Host = $SMTP_server; // SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = $email_address; // Mail desde el que se mandarán los correos
        $mail->Password = $password; // Contraseña
        $mail->SMTPSecure = 'ssl';
        $mail->Port = '465'; // Puerto SMTP
        $mail->setFrom($email_address); // Dirección mail utilizada en el servidor SMTP
        $mail->addAddress($email_address); // Dirección mail que recibirá los correos (Puede ser la misma que la dirección utilizada para enviarlos)
        $mail->isHTML(true);
        $mail->Subject = 'Mensaje recibido (Formulario de contacto)'; // Asunto del mail
        $mail->Body = "<h4>Nombre: $name <br>Email: $mailto <br>IP: $IP ($PAIS) <br>Hora: $date <br><br>Mensaje:</h4><p>$message</p>"; // Cuerpo

        $mail->send(); // Envia el mail
        $hidemydiv = True;
    } catch (Exception $e){
        $hidemydiv = False;
    }
    }
?>