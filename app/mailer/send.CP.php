<?php
    require_once('./app/PHPMailer/PHPMailerAutoload.php');
    require_once('./app/PHPMailer/class.smtp.php');
    $docu = $_SESSION['docu'];
    $correo = $_SESSION['correo'];
    $adicional =$_SESSION['adicional'];
    $titulo = 'Comprobante de Pago '.$docu;
    $mensaje = "<p>";
    $HOY = date("Y-m-d");
    $correo = str_replace(";", " , ", $correo);
    if(!empty($adicional) and strpos($adicional, "@")){
        $correo .= ', '.$adicional;
    }
    if (strpos($correo, "@")>1){
            $mensaje = 'Se ha generado el Comprobante de pago '.$docu.'.pdf';
            $mensaje.= '<br/> Gracias por su pago.';
            $mensaje.= '<br/> Atentamente';
            $mensaje.= '<br/> Grupo Baltex SA de CV';
            $mensaje.= '<br /> ' . '</p>';
    }else {
            echo "No se ha localizado el correo electr&oacute;nico a quien enviar. No se va a enviar el correo.";
            return;
    }    
     $asunto = "Comprobante de pago.";  
     $mensaje.= "<p>Si usted piensa que es un error favor de verificarlo con Grupo Baltex SA de CV <br/> <br/> <br/><br/><br/></p>";
    try {    
        $mail = new PHPMailer();
        $mail->isSMTP(true); // telling the class to use SMTP
        $mail->SMTPOptions = array(
        'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
        $mail->SMTPSecure = 'tls';
        $mail->Host = 'tls://smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username   = "grupobaltex@gmail.com";  // Nombre del usuario SMTP
        $mail->Password   = "Baltex55883555";
        if(strpos($correo,",")){
            $correo = explode(",", $correo);
            for ($i=0; $i < count($correo) ; $i++) { 
                $mail->AddAddress($correo[$i]);
            }
        }else{
            $mail->AddAddress($correo);
        }
        $mail->SetFrom('grupobaltex@gmail.com' , "Grupo Baltex SA de CV. Aviso de comprobante de pago"); // Esccribe datos de contacto
        $mail->Subject = $asunto;
        $mail->AltBody = 'Para ver correctamente este mensaje, por favor usa un manejador de correo con compatibilidad HTML !'; // optional - MsgHTML will create an alternate automatically
        $mail->MsgHTML($mensaje);
        $mail->AddAttachment(realpath('C:\\xampp\\htdocs\\Facturas\\timbradas\\'.$docu.'.pdf'),$docu.'.pdf','base64','application/pdf');
        $mail->AddAttachment(realpath('C:\\xampp\\htdocs\\Facturas\\timbradas\\'.$docu.'.xml'),$docu.'.xml');
        $mail->Send();
     } catch (phpmailerException $e) {
        echo $e->errorMessage(); //Pretty error messages from PHPMailer
     } catch (Exception $e) {
        echo $e->getMessage(); //Boring error messages from anything else!
     }
 ?>
