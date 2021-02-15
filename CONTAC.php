<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require __DIR__.'/Exception.php';
require __DIR__.'/PHPMailer.php';
require __DIR__.'/SMTP.php';

function ValidateEmail($email)
{
   $pattern = '/^([0-9a-z]([-.\w]*[0-9a-z])*@(([0-9a-z])+([-\w]*[0-9a-z])*\.)+[a-z]{2,6})$/i';
   return preg_match($pattern, $email);
}
function ReplaceVariables($code)
{
   foreach ($_POST as $key => $value)
   {
      if (is_array($value))
      {
         $value = implode(",", $value);
      }
      $name = "$" . $key;
      $code = str_replace($name, $value, $code);
   }
   $code = str_replace('$ipaddress', $_SERVER['REMOTE_ADDR'], $code);
   return $code;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['formid']) && $_POST['formid'] == 'capamadre')
{
   $mailto = 'amvixd@gmail.com';
   $mailfrom = isset($_POST['email']) ? $_POST['email'] : $mailto;
   $subject = 'Correo de nuimagen';
   $message = '<font style="color:#DC143C;font-family:Open Sans;font-weight:300;font-size:19px">Mensaje de la página Web:</font><font style="color:#DC143C;font-family:Arial;font-size:16px"><br></font><font style="color:#000000;font-family:Arial;font-size:16px"><br></font><font style="color:#DC143C;font-family:Open Sans;font-weight:300;font-size:19px">Nombre: </font><font style="color:#00BFFF;font-family:Open Sans;font-weight:300;font-size:19px">$nombre</font><font style="color:#DC143C;font-family:Open Sans;font-weight:300;font-size:19px"><br>Correo: </font><font style="color:#00BFFF;font-family:Open Sans;font-weight:300;font-size:19px">$email</font><font style="color:#DC143C;font-family:Open Sans;font-weight:300;font-size:19px"><br>Teléfono: </font><font style="color:#00BFFF;font-family:Open Sans;font-weight:300;font-size:19px">$telefono<br></font><font style="color:#DC143C;font-family:Open Sans;font-weight:300;font-size:19px">Mensaje: </font><font style="color:#00BFFF;font-family:Open Sans;font-weight:300;font-size:19px">$areatxt</font>';
   $success_url = './thanks.php';
   $error_url = './error.php';
   $autoresponder_from = 'amvixd@gmail.com';
   $autoresponder_name = 'support@nuimage';
   $autoresponder_to = isset($_POST['email']) ? $_POST['email'] : $mailfrom;
   $autoresponder_subject = 'Gracias $nombre , su mensaje fue recibido con éxito.';
   $autoresponder_message = '<font style="color:#DC143C;font-family:Arial;font-size:19px"><strong>Para su control, usted escribió lo siguiente:</strong></font><font style="color:#000000;font-family:Open Sans;font-weight:300;font-size:19px"><br><br></font><font style="color:#DC143C;font-family:Open Sans;font-weight:300;font-size:19px">Nombre:</font><font style="color:#000000;font-family:Open Sans;font-weight:300;font-size:19px"> </font><font style="color:#1E90FF;font-family:Open Sans;font-weight:300;font-size:19px">$nombre<br></font><font style="color:#DC143C;font-family:Open Sans;font-weight:300;font-size:19px">E-mail: </font><font style="color:#1E90FF;font-family:Open Sans;font-weight:300;font-size:19px">$email</font><font style="color:#000000;font-family:Open Sans;font-weight:300;font-size:19px"><br></font><font style="color:#DC143C;font-family:Open Sans;font-weight:300;font-size:19px">Teléfono:</font><font style="color:#000000;font-family:Open Sans;font-weight:300;font-size:19px"> </font><font style="color:#1E90FF;font-family:Open Sans;font-weight:300;font-size:19px">$telefono</font><font style="color:#000000;font-family:Open Sans;font-weight:300;font-size:19px"><br></font><font style="color:#DC143C;font-family:Open Sans;font-weight:300;font-size:19px">Mensaje: </font><font style="color:#1E90FF;font-family:Open Sans;font-weight:300;font-size:19px">$areatxt</font>';
   $eol = "\n";
   $error = '';

   $mail = new PHPMailer(true);
   try
   {
      $subject = ReplaceVariables($subject);
      $mail->Subject = stripslashes($subject);
      $mail->From = $mailfrom;
      $mail->FromName = $mailfrom;
      $mailto_array = explode(",", $mailto);
      for ($i = 0; $i < count($mailto_array); $i++)
      {
         if(trim($mailto_array[$i]) != "")
         {
            $mail->AddAddress($mailto_array[$i], "");
         }
      }
      if (!ValidateEmail($mailfrom))
      {
         $error .= "The specified email address (" . $mailfrom . ") is invalid!\n<br>";
         throw new Exception($error);
      }
      $mail->AddReplyTo($mailfrom);
      $mail->CharSet = 'ISO-8859-1';
      if (!empty($_FILES))
      {
         foreach ($_FILES as $key => $value)
         {
            if ($_FILES[$key]['error'] == 0)
            {
               if (is_array($_FILES[$key]['name']))
               {
                  $count = count($_FILES[$key]['name']);
                  for ($file = 0; $file < $count; $file++)
                  {
                     $mail->AddAttachment($_FILES[$key]['tmp_name'][$file], $_FILES[$key]['name'][$file]);
                  }
               }
               else
               {
                  $mail->AddAttachment($_FILES[$key]['tmp_name'], $_FILES[$key]['name']);
               }
            }
         }
      }
      $message = ReplaceVariables($message);
      $message = stripslashes($message);
      $mail->MsgHTML($message);
      $mail->IsHTML(true);
      $mail->Send();
      if (!ValidateEmail($autoresponder_from))
      {
         $error .= "The specified autoresponder email address (" . $autoresponder_from . ") is invalid!\n<br>";
         throw new Exception($error);
      }

      $mail->ClearAddresses();
      $mail->ClearAttachments();
      $autoresponder_subject = ReplaceVariables($autoresponder_subject);
      $mail->Subject = stripslashes($autoresponder_subject);
      $mail->From = $autoresponder_from;
      $mail->FromName = $autoresponder_name;
      $mail->AddAddress($autoresponder_to, "");
      $mail->AddReplyTo($autoresponder_from);
      $autoresponder_message = ReplaceVariables($autoresponder_message);
      $autoresponder_message = stripslashes($autoresponder_message);
      $mail->MsgHTML($autoresponder_message);
      $mail->IsHTML(true);
      $mail->Send();
      $successcode = file_get_contents($success_url);
      $successcode = ReplaceVariables($successcode);
      echo $successcode;
   }
   catch (Exception $e)
   {
      $errorcode = file_get_contents($error_url);
      $replace = "##error##";
      $errorcode = str_replace($replace, $e->getMessage(), $errorcode);
      echo $errorcode;
   }
   exit;
}
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Éxito de evío de datos</title>
<meta name="keywords" content="support">
<meta name="generator" content="support@nuimage">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,300" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lato:400&subset=latin-ext" rel="stylesheet">
<link href="Untitled1.css" rel="stylesheet">
<link href="CONTAC.css" rel="stylesheet">
</head>
<body>
<div id="container">
</div>
<div id="wb_titulo">
<div id="titulo">
<div class="row">
<div class="col-1">
<div id="wb_Image1" style="display:inline-block;width:calc(100% - 10px);height:auto;z-index:0;">
<img src="images/logo principal.png" id="Image1" alt="">
</div>
<div id="wb_Text1">
<span style="color:#DC143C;font-family:Arial;font-size:19px;"><strong>nu</strong></span><span style="color:#000000;font-family:Arial;font-size:19px;"><strong>imagen</strong></span>
</div>
</div>
<div class="col-2">
<div id="wb_mensajetxt">
<span style="color:#000000;font-family:'Open Sans';font-weight:300;font-size:27px;line-height:36px;">Bienvenido al área de contacto</span>
</div>
</div>
</div>
</div>
</div>
<div id="wb_capamadre">
<form name="CONTACTO" method="post" action="<?php echo basename(__FILE__); ?>" enctype="multipart/form-data" id="capamadre">
<input type="hidden" name="formid" value="capamadre">
<div class="row">
<div class="col-1">
<div id="wb_capalinea1">
<div id="capalinea1">
<div class="row">
<div class="col-1">
<hr id="Line2" style="display:block;width: calc(100% - 40px);z-index:12;">
</div>
</div>
</div>
</div>
<div id="wb_capaform">
<div id="capaform">
<div class="row">
<div class="col-1">
<div id="wb_Text2">
<span style="color:#DC143C;font-family:Arial;font-size:13px;">Todos los campos son obligatorios*</span>
</div>
<input type="text" id="nombre" style="display:block;width: calc(100% - 40px);height:43px;z-index:14;" name="nombre" value="" tabindex="1" spellcheck="false" required pattern="[A-Za-zÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýþÿ \t\r\n\f]*$" placeholder="Nombre">
<input type="email" id="email" style="display:block;width: calc(100% - 40px);height:43px;z-index:15;" name="email" value="" tabindex="2" spellcheck="false" required placeholder="E-mail (correo)">
<input type="number" id="phone" style="display:block;width: calc(100% - 40px);height:43px;z-index:16;" name="telefono" value="" tabindex="3" spellcheck="false" required placeholder="Tel&#233;fono">
</div>
<div class="col-2">
<textarea name="areatxt" id="txtmensaje" style="display:block;width: calc(100% - 40px);;height:191px;z-index:17;" rows="11" cols="33" tabindex="4" spellcheck="false" required placeholder="Escriba aqu&#237; su mensaje"></textarea>
</div>
</div>
</div>
</div>
<div id="wb_capalinea2">
<div id="capalinea2">
<div class="row">
<div class="col-1">
<hr id="Line1" style="display:block;width: calc(100% - 40px);z-index:18;">
</div>
</div>
</div>
</div>
<div id="wb_capabtn">
<div id="capabtn">
<div class="row">
<div class="col-1">
<input type="submit" id="btnenviar" name="btnenviar" value="Enviar" style="display:inline-block;width:148px;height:40px;z-index:19;" tabindex="5">
<div id="wb_Text3">
<span style="color:#1E90FF;font-family:'Open Sans';font-weight:300;font-size:19px;">Recuerde que tambien puede escribirnos al WhatsApp: 953385881</span>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</form>
</div>
</body>
</html>