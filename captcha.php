<?php
require_once 'configRoot.php';
//session_start();
ob_start();
error_reporting(E_ALL | E_STRICT);
//require('class/session_handler_carro.php');
ini_set('display_errors', 'Off');
ini_set('log_errors', 'Off');
//iniciar_sessao();
$codigoCaptcha = substr(md5(time()) ,0,5);

$_SESSION['captchaDetalhe'] = $codigoCaptcha;
$imagemCaptcha = imagecreatefrompng(ssl().PROJECT_URL."/img/fundo-captcha.png");
$fonteCaptcha = 5;
 
$corCaptcha = imagecolorallocate($imagemCaptcha,180,180,180);
imagestring($imagemCaptcha,$fonteCaptcha,7,7,$codigoCaptcha,$corCaptcha);
header("Content-type: image/png");
 
imagepng($imagemCaptcha);
imagedestroy($imagemCaptcha);
?>