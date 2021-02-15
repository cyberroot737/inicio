<?php
function ValidateEmail($email)
{
   $pattern = '/^([0-9a-z]([-.\w]*[0-9a-z])*@(([0-9a-z])+([-\w]*[0-9a-z])*\.)+[a-z]{2,6})$/i';
   return preg_match($pattern, $email);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['formid']) && $_POST['formid'] == 'layoutdeform')
{
   $mailto = 'cyberroot76@gmail.com';
   $mailfrom = isset($_POST['email']) ? $_POST['email'] : $mailto;
   $subject = 'Mensaje de la página';
   $message = 'Este es un mensaje escrito a la página';
   $success_url = './thanks.php';
   $error_url = './error.php';
   $autoresponder_from = 'cyberroot76@gmail.com';
   $autoresponder_name = 'support@nuimage';
   $autoresponder_to = isset($_POST['email']) ? $_POST['email'] : $mailfrom;
   $autoresponder_subject = 'Hola, su mensaje fue recibido con éxito.';
   $autoresponder_message = 'Gracias por escribirnos, nuestro equipo se pondrá en contacto con usted lo más antes posible.';
   $eol = "\n";
   $error = '';
   $internalfields = array ("submit", "reset", "send", "filesize", "formid", "captcha_code", "recaptcha_challenge_field", "recaptcha_response_field", "g-recaptcha-response");
   $boundary = md5(uniqid(time()));
   $header  = 'From: '.$mailfrom.$eol;
   $header .= 'Reply-To: '.$mailfrom.$eol;
   $header .= 'MIME-Version: 1.0'.$eol;
   $header .= 'Content-Type: multipart/mixed; boundary="'.$boundary.'"'.$eol;
   $header .= 'X-Mailer: PHP v'.phpversion().$eol;

   try
   {
      if (!ValidateEmail($mailfrom))
      {
         $error .= "The specified email address (" . $mailfrom . ") is invalid!\n<br>";
         throw new Exception($error);
      }
      $message .= $eol;
      $message .= "IP Address : ";
      $message .= $_SERVER['REMOTE_ADDR'];
      $message .= $eol;
      foreach ($_POST as $key => $value)
      {
         if (!in_array(strtolower($key), $internalfields))
         {
            if (is_array($value))
            {
               $message .= ucwords(str_replace("_", " ", $key)) . " : " . implode(",", $value) . $eol;
            }
            else
            {
               $message .= ucwords(str_replace("_", " ", $key)) . " : " . $value . $eol;
            }
         }
      }
      $body  = 'This is a multi-part message in MIME format.'.$eol.$eol;
      $body .= '--'.$boundary.$eol;
      $body .= 'Content-Type: text/plain; charset=ISO-8859-1'.$eol;
      $body .= 'Content-Transfer-Encoding: 8bit'.$eol;
      $body .= $eol.stripslashes($message).$eol;
      if (!empty($_FILES))
      {
         foreach ($_FILES as $key => $value)
         {
             if ($_FILES[$key]['error'] == 0)
             {
                $body .= '--'.$boundary.$eol;
                $body .= 'Content-Type: '.$_FILES[$key]['type'].'; name='.$_FILES[$key]['name'].$eol;
                $body .= 'Content-Transfer-Encoding: base64'.$eol;
                $body .= 'Content-Disposition: attachment; filename='.$_FILES[$key]['name'].$eol;
                $body .= $eol.chunk_split(base64_encode(file_get_contents($_FILES[$key]['tmp_name']))).$eol;
             }
         }
      }
      $body .= '--'.$boundary.'--'.$eol;
      if ($mailto != '')
      {
         mail($mailto, $subject, $body, $header);
      }
      if (!ValidateEmail($autoresponder_from))
      {
         $error .= "The specified autoresponder email address (" . $autoresponder_from . ") is invalid!\n<br>";
         throw new Exception($error);
      }

      $autoresponder_header  = 'From: '.$autoresponder_name.' <'.$autoresponder_from.'>'.$eol;
      $autoresponder_header .= 'Reply-To: '.$autoresponder_from.$eol;
      $autoresponder_header .= 'MIME-Version: 1.0'.$eol;
      $autoresponder_header .= 'Content-Type: text/plain; charset=ISO-8859-1'.$eol;
      $autoresponder_header .= 'Content-Transfer-Encoding: 8bit'.$eol;
      $autoresponder_header .= 'X-Mailer: PHP v'.phpversion().$eol;
      foreach ($_POST as $key => $value)
      {
         if (!in_array(strtolower($key), $internalfields))
         {
            if (!is_array($value))
            {
               $autoresponder_message .= ucwords(str_replace("_", " ", $key)) . " : " . $value . $eol;
            }
            else
            {
               $autoresponder_message .= ucwords(str_replace("_", " ", $key)) . " : " . implode(",", $value) . $eol;
            }
         }
      }

      mail($autoresponder_to, $autoresponder_subject, $autoresponder_message, $autoresponder_header);
      header('Location: '.$success_url);
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
<title>nuimagen contacto</title>
<meta name="generator" content="nuimage@support">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="ICONO X16-1.png" rel="icon" sizes="16x16" type="image/png">
<link href="ICONO X32-1.png" rel="icon" sizes="32x32" type="image/png">
<link href="ICONO X64-1.png" rel="icon" sizes="64x64" type="image/png">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,300" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lato:400&subset=latin-ext" rel="stylesheet">
<link href="Untitled1.css" rel="stylesheet">
<link href="contacto1.css" rel="stylesheet">
<script src="jquery-1.12.4.min.js"></script>
<script>
$(document).ready(function()
{
   if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1) {$('#preloader').remove();}
});
$(window).on('load', function()
{
   $('#preloader').remove();
});
</script>
</head>
<body>
<div id="wb_layoutdatos">
<div id="layoutdatos">
<div class="row">
<div class="col-1">
<div id="wb_Image1">
<img src="images/LOGO100.png" id="Image1" alt="">
</div>
<div id="wb_Heading9">
<h1 id="Heading9">Bienvenido al área de contacto de nuimagen</h1>
</div>
<div id="wb_Shape4">
<div id="Shape4"></div>
</div>
<div id="wb_Heading8">
<h2 id="Heading8">¿Tiene alguna pregunta o desea más información?</h2>
</div>
</div>
</div>
</div>
</div>
<div id="wb_layoutdatos1">
<div id="layoutdatos1">
<div class="row">
<div class="col-1">
<div id="wb_Text1">
<span style="color:#4F4F4F;font-family:'Open Sans';font-weight:300;font-size:19px;line-height:27px;">A continuación, ingrese sus datos:</span>
</div>
</div>
<div class="col-2">
<div id="wb_Text2">
<span style="color:#228B22;font-family:'Open Sans';font-weight:300;font-size:19px;line-height:27px;">Nuestro WhatsApp: 953385881</span>
</div>
</div>
<div class="col-3">
<div id="wb_Text3">
<span style="color:#0179AD;font-family:'Open Sans';font-weight:300;font-size:19px;">nuestro correo:<br>cyberroot76@gmail.com</span>
</div>
</div>
</div>
</div>
</div>
<div id="wb_layoutdeform">
<form name="LayoutGrid8" method="post" action="<?php echo basename(__FILE__); ?>" enctype="multipart/form-data" id="layoutdeform">
<input type="hidden" name="formid" value="layoutdeform">
<div class="row">
<div class="col-1">
<div id="wb_LayoutGrid9">
<div id="LayoutGrid9">
<div class="row">
<div class="col-1">
<input type="text" id="editboxName" name="name" value="" spellcheck="false" required pattern="[A-Za-zÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýþÿ \t\r\n\f]*$" placeholder="Nombre(s)">
</div>
<div class="col-2">
<input type="email" id="editboxEmail" name="email" value="" spellcheck="false" required placeholder="E-mail (correo)">
</div>
<div class="col-3">
<input type="number" id="editboxPhone" name="phone" value="" spellcheck="false" required placeholder="Tel&#233;fono">
</div>
</div>
</div>
</div>
<textarea name="message" id="editboxMessage" rows="4" cols="70" autocomplete="off" spellcheck="false" required placeholder="Escriba aqu&#237; su mensaje"></textarea>
<div id="wb_Text11">
<span style="color:#B22222;">* Todos los campos son obligatorios. </span>
</div>
<input type="submit" id="Button1" name="" value="Enviar">
</div>
</div>
</form>
</div>
<div id="preloader"></div>
</body>
</html>