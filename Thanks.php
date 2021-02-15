<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>nuimagen agradecimientos</title>
<meta name="author" content="SCV(Dev)">
<meta name="generator" content="nuimagen@support">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="ICONO X16-1.png" rel="icon" sizes="16x16" type="image/png">
<link href="ICONO X32-1.png" rel="icon" sizes="32x32" type="image/png">
<link href="ICONO X64-1.png" rel="icon" sizes="64x64" type="image/png">
<link href="font-awesome.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,300" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lato:400&subset=latin-ext" rel="stylesheet">
<link href="Untitled1.css" rel="stylesheet">
<link href="thanks.css" rel="stylesheet">
<script src="jquery-1.12.4.min.js"></script>
<script src="wwb16.min.js"></script>
<script>
$(document).ready(function()
{
   $('#wb_IconFont1').addClass('visibility-hidden');
   function onScrollIconFont1()
   {
      var $obj = $("#wb_IconFont1");
      if (!$obj.hasClass("in-viewport") && $obj.inViewPort(true))
      {
         $obj.addClass("in-viewport");
         AnimateCss('wb_IconFont1', 'animate-fade-in-up', 0, 1250);
      }
      else
      if ($obj.hasClass("in-viewport") && !$obj.inViewPort(true))
      {
         $obj.removeClass("in-viewport");
         AnimateCss('wb_IconFont1', 'animate-fade-out', 0, 0);
      }
   }
   if (!$('#wb_IconFont1').inViewPort(true))
   {
      $('#wb_IconFont1').addClass("in-viewport");
   }
   onScrollIconFont1();
   $(window).scroll(function(event)
   {
      onScrollIconFont1();
   });
});
</script>
</head>
<body>
<div id="wb_LayoutGrid1">
<div id="LayoutGrid1">
<div class="row">
<div class="col-1">
<div id="wb_Image1" style="display:inline-block;width:calc(100% - 60px);height:auto;z-index:0;">
<img src="images/LOGO100.png" id="Image1" alt="">
</div>
<div id="wb_Text1">
<span style="color:#696969;font-family:'Open Sans';font-weight:300;font-size:20px;">Gracias por escribirnos, el equipo de nuimagen se pondrá en contacto con usted.<br>Su mensaje fue enviado con éxito!</span>
</div>
<div id="wb_Text3">
<span style="color:#DC143C;font-family:Arial;font-size:19px;"><strong>Sus datos y mensaje de contacto:</strong></span>
</div>
<div id="wb_Text2">
<span style="color:#DC143C;font-family:Arial;font-size:19px;"><strong>Nombre: </strong></span><span style="color:#1E90FF;font-family:Arial;font-size:19px;">$name</span><span style="color:#000000;font-family:Arial;font-size:19px;"><br><br></span><span style="color:#DC143C;font-family:Arial;font-size:19px;"><strong>E-mail: </strong></span><span style="color:#1E90FF;font-family:Arial;font-size:19px;">$email</span><span style="color:#000000;font-family:Arial;font-size:19px;"><br><br></span><span style="color:#DC143C;font-family:Arial;font-size:19px;"><strong>Teléfono: </strong></span><span style="color:#1E90FF;font-family:Arial;font-size:19px;">$phone</span><span style="color:#000000;font-family:Arial;font-size:19px;"><br><br></span><span style="color:#DC143C;font-family:Arial;font-size:19px;"><strong>Mensaje: </strong></span><span style="color:#1E90FF;font-family:Arial;font-size:19px;">$message</span><span style="color:#000000;font-family:Arial;font-size:19px;"><br></span>
</div>
</div>
</div>
</div>
</div>
<div id="wb_capalinea2">
<div id="capalinea2">
<div class="row">
<div class="col-1">
<hr id="Line1" style="display:block;width: calc(100% - 60px);z-index:4;">
</div>
</div>
</div>
</div>
<div id="wb_LayoutGrid2">
<div id="LayoutGrid2">
<div class="row">
<div class="col-1">
<div id="wb_Text4">
<span style="color:#DC143C;font-family:'Open Sans';font-weight:300;font-size:19px;line-height:24px;">¿Desea imprimir esta página?</span>
</div>
<div id="wb_IconFont1" style="display:none;width:91px;height:79px;text-align:center;z-index:6;">
<a href="javascript:window.print()"><div id="IconFont1"><i class="fa fa-print"></i></div></a>
</div>
<div id="wb_Text5">
<span style="color:#1E90FF;font-family:'Open Sans';font-weight:300;font-size:19px;"><a href="./index.html">Volver al inicio</a></span>
</div>
</div>
</div>
</div>
</div>
<div id="wb_LayoutGrid3">
<div id="LayoutGrid3">
<div class="row">
<div class="col-1">
<hr id="Line2" style="display:block;width: calc(100% - 60px);z-index:8;">
</div>
</div>
</div>
</div>
</body>
</html>