<?php
function recuperarSenha($emailRemetente = 'email@dominio.com', $emailDestinatario = 'email@dominio.com', $emailResposta = 'email@dominio.com', $assunto = '', $nomeRemetente = '', $conteudoEmail = array(), $twitter = '', $facebook = '')
{
    require_once "mailer/class.phpmailer.php";
    $retorno = true;
    
    $usuario = array_key_exists('usuario',$conteudoEmail) ? $conteudoEmail['usuario'] : '';
    $senha = array_key_exists('senha',$conteudoEmail) ? $conteudoEmail['senha'] : '';
    $nome = array_key_exists('nome',$conteudoEmail) ? $conteudoEmail['nome'] : '';
    
    $textoEmail = "<body>";
    $textoEmail .=    "<div style='width: 600px; height:800px;'>";
    $textoEmail .=        "<div style='width: 572px; padding:14px;'>";
    $textoEmail .=            "<div style='float: left; margin-bottom:40px;'>";
    $textoEmail .=                "<img src='".ssl().PROJECT_URL."/img/logo-email.png' alt='Kicarrão' />";
    $textoEmail .=            "</div>";
    $textoEmail .=            "<div style='float:left; width:100%; font-size:17px; color:#000; font-family:Arial; font-weight:bold;'>";
    $textoEmail .=                $assunto;
    $textoEmail .=            "</div>";
    $textoEmail .=            "<div style='float:left; width:100%; margin-bottom:10px;'><img src='".ssl().PROJECT_URL."/img/linha-email.png' alt='' /></div>";
    $textoEmail .=            "<div style='float:left; width:100%; font-size:14px; color:#000; font-family:Arial; margin-bottom:10px; line-height:18px;'>";
	$textoEmail .= 				"Prezado(a) ".$nome."<br />";
	$textoEmail .= 				"Abaixo seus dados de acesso para o site www.kicarrao.com.br :<br />";
	$textoEmail .= 				"<br /><br />";
	$textoEmail .= 				"Usuário : ".$usuario;
	$textoEmail .= 				"<br /><br />";
	$textoEmail .= 				"Senha : ".$senha;
	$textoEmail .= 				"<br /><br />";
	$textoEmail .= 			 "</div>";	
    $textoEmail .=            "<div style='float:left; width:100%; background: #000;'>";
    $textoEmail .=                "<div style='float: left; width:201px; margin-left:33px;'>";
    $textoEmail .=                    "<p style='color: #FFF; font-size:17px; font-family:Arial; font-weight:bold; margin-bottom:0px;'>Atendimento</p>";
    $textoEmail .=                    "<p style='color:#FABC11; font-size:17px; font-family:Arial; margin-top:5px;'>";
    $textoEmail .=                        "<a style='color:#FABC11; text-decoration:none;'>(51) 3557.1574</a><br />";
    $textoEmail .=                        "<a style='color:#FABC11; text-decoration:none;'>atendimento@kicarrao.com.br</a>";
    $textoEmail .=                    "</p>";
    $textoEmail .=                "</div>";
    $textoEmail .=                "<div style='float:right; width:150px; margin-top:20px; margin-right:24px;'>";
    $textoEmail .=                    "<p style='color: #FABC11; font-size:17px; font-family:Arial; font-weight:bold; margin-bottom:0px;'>Compre Online</p>";
    $textoEmail .=                    "<p style='color: #FFF; font-size:17px; font-family:Arial; margin-top:5px;'><a style='color:#FFFFFF; text-decoration:none;' href='http://www.kicarrao.com.br'>www.kicarrao.com.br</a></p>";
    $textoEmail .=                "</div>";
    $textoEmail .=            "</div>";
    $textoEmail .=        "</div>";
    $textoEmail .=    "</div>";
    $textoEmail .= "</body>";
            
    $emailDestinatario = is_array($emailDestinatario) ? $emailDestinatario : array($emailDestinatario);
    
    $mail = new PHPMailer();
    $mail->IsMail();
    $mail->SetFrom("$emailRemetente",$nomeRemetente);
    $mail->IsHTML(true);
	$mail->Subject = $assunto;
	$mail->Body    = $textoEmail;
    foreach ($emailDestinatario as $emailDestino)
    {
        $mail->AddAddress($emailDestino);
        $mail->Send();
	
    	$mail->ClearAllRecipients();
    	$mail->ClearAttachments();        
    }
    return $retorno;   
}
?>