<?php
function enviaAmigoEmail($emailRemetente = 'email@dominio.com', $emailDestinatario = 'email@dominio.com', $emailResposta = 'email@dominio.com', $assunto = '', $nomeRemetente = '', $conteudoEmail = array(), $twitter = '', $facebook = '')
{
    require_once "mailer/class.phpmailer.php";
    $retorno = true;
    
    $nomeAmigo = array_key_exists('nomeAmigo',$conteudoEmail) ? $conteudoEmail['nomeAmigo'] : '';
    $linkAnuncio = array_key_exists('linkAnuncio',$conteudoEmail) ? $conteudoEmail['linkAnuncio'] : '';
    $anos = array_key_exists('anos',$conteudoEmail) ? $conteudoEmail['anos'] : '';
    $preco = array_key_exists('preco',$conteudoEmail) ? $conteudoEmail['preco'] : '';
    $cor = array_key_exists('cor',$conteudoEmail) ? $conteudoEmail['cor'] : '';
    $placa = array_key_exists('placa',$conteudoEmail) ? $conteudoEmail['placa'] : '';
    $descricao = array_key_exists('descricao',$conteudoEmail) ? $conteudoEmail['descricao'] : '';
    $imagem = array_key_exists('imagem',$conteudoEmail) ? $conteudoEmail['imagem'] : '';
    $nome = array_key_exists('nome',$conteudoEmail) ? $conteudoEmail['nome'] : '';
    $email = array_key_exists('email',$conteudoEmail) ? $conteudoEmail['email'] : '';
    $marcaVersao  = array_key_exists('marcaVersao',$conteudoEmail) ? $conteudoEmail['marcaVersao'] : '';
    
    $textoEmail = "<body style='margin: 0; padding:0;'>
                    <div class='mestre' style=\"float: left; width:600px;\">
                        <div class='topo' style=\"float:left; width:100%;\">
                            <a style=\"display: block;\" href='http://www.kicarrao.com.br' target='_blank'><img src='http://www.kicarrao.com.br/img/padrao-email/topo.jpg' alt='KiCarrão' /></a>
                        </div>
                        <div class=\"centro\" style=\"float: left; width:100%; min-height:362px;\">
                            <div style=\"font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#1A1A1A; margin-top:16px; margin-left:19px;\"> 	
                                Olá (a) $nomeAmigo<br />
                                seu amigo(a) $nome indicou um anúncio para você.<br />
                            </div>
                            <div style=\"float: left; margin-left:14px; margin-right:14px;\">
                                <p style=\"background: url('http://www.kicarrao.com.br/img/padrao-email/fundotarja.png') no-repeat; width:559px; height:41px; color:#FFF; font-family:Arial, Helvetica, sans-serif; font-size:17px; font-weight:bold; line-height:41px; margin-top:35px; margin-bottom:0; padding-left:13px;\">
                                    Dados do Anúncio - Kicarrão
                                </p>
                                <div style=\"font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#1A1A1A; padding-top:28px; padding-left:19px;\">
                                    <table style=\"width:531px;\" cellspacing=\"0\" cellpadding=\"0\">
                                        <tr>
                                            <td style=\"padding-top:23px; padding-bottom:14px; width:141px; text-align:center;\">
                                                <a href=\"$linkAnuncio\">
                                                    <img src=\"$imagem\" alt=\"\" />   
                                                </a>
                                            </td>
                                            <td style=\"padding-left:10px; padding-top:5px; padding-bottom:2px;\">
                                                <p style=\"font-size:13px;\">
                                                     $marcaVersao<br />
                                                     <br />
                                                     $placa - $cor - $anos<br />
                                                     <br />	
                                                     R$ $preco<br />
                                                     <br />
                                                     $descricao 
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div style='width:100%; text-align:center; padding-top:20px; padding-bottom:10px; font-family:Arial, Helvetica, sans-serif; font-size:13px;'>
                                	Dúvidas ligue para 51 8480-2943  Obrigado e bons negócios!
                                </div>
                            </div>
                        </div>
                        <div style='background: #D1D1D1; float: left; width:100%; padding-top:32px; min-height:82px;'>
                            <p style='color:#A60F09; font-family:Arial, Helvetica, sans-serif; font-size: 17px; font-weight:bold; float:left; margin-left:27px; margin-top:0; margin-bottom:0;'>
                                Acompanhe o Kicarrão nas<br /> 
                                <span style='font-size: 22px; display:block; margin-top:5px;'>Redes Sociais</span>
                            </p>
                            <div style='float: right; margin-right:17px;'>
                                <a style='margin-right: 7px;' href='https://www.facebook.com/kicarrao' target='_blank'><img src='http://www.kicarrao.com.br/img/padrao-email/facebook.png' /></a>
                                <a style='margin-right: 7px;' href='https://twitter.com/kicarrao' target='_blank'><img src='http://www.kicarrao.com.br/img/padrao-email/twitter.png' /></a>
                                <a style='margin-right: 7px;' href='http://instagram.com/kicarrao' target='_blank'><img src='http://www.kicarrao.com.br/img/padrao-email/instagram.png' /></a>
                                <a style='margin-right: 7px;' href='http://www.youtube.com/user/kicarrao?feature=watch' target='_blank'><img src='http://www.kicarrao.com.br/img/padrao-email/youtube.png' /></a>
                            </div> 
                        </div>
                        <div class='rodape' style='float:left; width:100%;'>
                            <a style='display: block;' href='http://www.kicarrao.com.br' target='_blank'>
                                <img src='http://www.kicarrao.com.br/img/padrao-email/rodape.jpg' alt='KiCarrão' />
                            </a>
                        </div>
                    </div>
                    </body>";
            
    $emailDestinatario = is_array($emailDestinatario) ? $emailDestinatario : array($emailDestinatario);
    
    $mail = new PHPMailer();
    $mail->IsMail();
    $mail->SetFrom("$emailRemetente",$nomeRemetente);
    $mail->ClearReplyTos();
    $mail->AddReplyTo($emailResposta,$nome);
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