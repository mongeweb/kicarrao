<?php
function recuperarSenhaAdm($emailRemetente = 'email@dominio.com', $emailDestinatario = 'email@dominio.com', $emailResposta = 'email@dominio.com', $assunto = '', $nomeRemetente = '', $conteudoEmail = array(), $twitter = '', $facebook = '')
{
    require_once "mailer/class.phpmailer.php";
    $retorno = true;
    
    $usuario = array_key_exists('usuario',$conteudoEmail) ? $conteudoEmail['usuario'] : '';
    $senha = array_key_exists('senha',$conteudoEmail) ? $conteudoEmail['senha'] : '';
    
    $textoEmail = "<body style='margin:0; padding:0;'>";
	$textoEmail .=	"<div id='mestre' style='width:700px;'>";
	$textoEmail .=		"<div class='topo' style='margin-left:42px;'><img src='http://".PROJECT_URL."/img/emailPadraoCabecalho.jpg'/></div>";
	$textoEmail .=		"<div id='conteudo' style='width:573px;margin-left:39px;'>";
    $textoEmail .= 			"<p style='font-size:12px;color:#3E3621;'>";
	$textoEmail .= 				"Dados para acesso do gerenciador: <br />";
	$textoEmail .= 				"<br /><br />";
	$textoEmail .= 				"Usuário: ".$usuario;
	$textoEmail .= 				"<br />";
	$textoEmail .= 				"Senha: ".$senha;
	$textoEmail .= 				"<br /><br />";
	$textoEmail .= 			"</p>";                         
	$textoEmail .=		"</div>";
	$textoEmail .=		"<div class='rodape' style='margin-left:42px;margin-top:20px;'>";
	$textoEmail .=			"<img src='http://".PROJECT_URL."/img/emailPadraoRodape.jpg' border='0' usemap='#Map'/>";
	$textoEmail .=			"<map name='Map'>";
	$textoEmail .=				"<area shape='rect' coords='370, 47, 399, 78' href='https://twitter.com/".$twitter."' target='_blank'>";
	$textoEmail .=				"<area shape='rect' coords='410, 47, 440, 78' href='https://www.facebook.com/".$facebook."' target='_blank'>";
	$textoEmail .=			"</map>";
	$textoEmail .=		"</div>";
	$textoEmail .=	"</div>";
	$textoEmail .= "</body>";
            
    $emailDestinatario = is_array($emailDestinatario) ? $emailDestinatario : array($emailDestinatario);
    
    $mail = new PHPMailer();
    $mail->IsMail();
    $mail->SetFrom("$emailRemetente",$nomeRemetente);
    foreach ($emailDestinatario as $emailDestino)
    {
        $mail->AddAddress($emailDestino);        
    }
	$mail->IsHTML(true);
	$mail->Subject = $assunto;
	$mail->Body    = $textoEmail;
	$mail->Send();
	
	$mail->ClearAllRecipients();
	$mail->ClearAttachments();
    return $retorno;   
}
?>