<?php

/**
 * enviaEmail()
 * 
 * Envia um emeail para cada email enviado no parametro $emailDestinatario.
 * 
 * @author Augusto dos S. Ferreira
 * @copyright 04/2010
 * @version 1.0
 * @access public
 * 
 * Histórico:
 * 
 * Data			| Ve	rsão | Modificação
 * ------------------------------------------------------------------------------------------------
 * 				|		 | ------------------------------------------------------------------------
 * ------------------------------------------------------------------------------------------------
 * 
 * @param String $nomeRemetente                         Nome do remetente do email(pode ser o nome do site).
 * @param String $emailRemetente                        Email do remetente.
 * @param Array $emailDestinatario                      Array de emails para enviar.
 * @param String $emailResposta                         Email de resposta.
 * @param String $assunto                               Assunto do email.
 * @param Array $campos                                 Nome dos campos para montar a mensagem.
 * @param Array $dados                                  Valores dos campos para montar a mensagem.
 * @return bool
 */
function enviarEmail($nomeRemetente = '', $emailRemetente = 'email@dominio.com', $emailDestinatario = 'email@dominio.com', $emailResposta = 'email@dominio.com', $assunto = '', $campos = array(), $dados = array(), $customMsg = false, $mensagemHTML = '')
{
    
    require_once "mailer/class.phpmailer.php";
    
    $retorno = true;
    /* Verifica qual é o sistema operacional do servidor para ajustar o cabeçalho de forma correta. Não alterar */
    $quebra_linha = "\n"; //Se for Linux
    if (PHP_OS == 'Linux') {
        $quebra_linha = "\n"; //Se for Linux
    } elseif (PHP_OS == 'WINNT') {
        $quebra_linha = "\r\n"; // Se for Windows
    }
    $anexo = false;
    if (!$customMsg)
    {
        /* Montando a mensagem a ser enviada no corpo do e-mail. */
        $mensagemHTML = '<table width="490" border="0" cellpadding="0" cellspacing="6">
    				<tr>
    					<td colspan="2">
    						<p style="font-size: 14px; font-family: Arial, Helvetica, sans-serif; color: #A93118;">..: ' . $assunto . '</p>
    						<p>Formul&aacute;rio preenchido em ' . date('d/m/Y') . ' as ' . date('H:i') . '</p>
    					</td>
    				</tr>
    				';
        $qtde = count($campos);
        
        for ($i = 0; $i < $qtde; $i++)
        {
            if ($campos[$i] != "Anexo")
            {
                $mensagemHTML .= '
        				<tr> 
        				  <td align="right" width="133px"><strong>' . $campos[$i] . '</strong></td>
        				  <td>' . $dados[$i] . '</td>
        				</tr>
                        ';
                
            }
            else
            {
                if(isset($dados[$i]))
				{
                    $arquivo = $dados[$i]['tmp_name'];
					$name = isset($_FILES['file']['name']) ? $_FILES['file']['name'] : '';
                    if($name != '')
                    {
    					$arrName = explode('.', $name);
    					$ext = end($arrName);
    					$finalName = strtolower("arquivo".date("dmY"). rand(1, 999999) . '.' . $ext);
                    	$anexo = true;
                    }
                    else
                    {
                        $anexo = false;
                    }
				}
				else
				{
                    $anexo = false;
				}
                
            }
        }
        $mensagemHTML .= '</table>';
    }

    $emailDestinatario = is_array($emailDestinatario) ? $emailDestinatario : array($emailDestinatario);
    
    $mail = new PHPMailer();
    $mail->IsMail();
    
    $mail->SetFrom("$emailRemetente",$nomeRemetente);
    foreach ($emailDestinatario as $emailDestino)
    {
        $mail->AddAddress($emailDestino); 
        $mail->IsHTML(true);
        if($anexo == true)
            $mail->AddAttachment($arquivo,$finalName);
        $mail->Subject = $assunto;
        $mail->Body    = $mensagemHTML;
        $retorno = $mail->Send();
        
        $mail->ClearAllRecipients();
        $mail->ClearAttachments();
    }
	
    return $retorno;
}

?>