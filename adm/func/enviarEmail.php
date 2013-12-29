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
 * Data			| Versão | Modificação
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
    $retorno = true;
    /* Verifica qual é o sistema operacional do servidor para ajustar o cabeçalho de forma correta. Não alterar */
    $quebra_linha = "\n"; //Se for Linux
    if (PHP_OS == 'Linux') {
        $quebra_linha = "\n"; //Se for Linux
    } elseif (PHP_OS == 'WINNT') {
        $quebra_linha = "\r\n"; // Se for Windows
    }

    if (!$customMsg) {
        /* Montando a mensagem a ser enviada no corpo do e-mail. */
        $mensagemHTML = '<table width="490" border="0" cellpadding="0" cellspacing="6">
    				<tr>
    					<td colspan="2">
    						<p style="font-size: 14px; font-family: Arial, Helvetica, sans-serif; color: #A93118;">..: ' . utf8_encode($assunto) . ' :..</p>
    						
    					</td>
    				</tr>
    				';
        $qtde = count($campos);
        for ($i = 0; $i < $qtde; $i++) {
            $mensagemHTML .= '
    				<tr> 
    				  <td align="right"><strong>' . $campos[$i] . ': </strong></td>
    				  <td>' . $dados[$i] . '</td>
    				</tr>
                    ';
        }
        $mensagemHTML .= '</table>';
    }

    // O remetente deve ser um e-mail do seu domínio conforme determina a RFC 822.
    // O return-path deve ser ser o mesmo e-mail do remetente.
    $headers = implode($quebra_linha, #
                 array('MIME-Version: 1.1', #
                       'Content-type: text/html; charset=utf-8', #
                       'From: ' . $nomeRemetente . ' <' . $emailRemetente . '>', #
                       'Return-Path: ' . $nomeRemetente . ' <' . $emailRemetente . '>', #
                       'Reply-To: ' . $emailResposta, #
                       'Subject: ' . utf8_encode($assunto), #
                       'X-Priority: 3'
                       ));

    $emailDestinatario = is_array($emailDestinatario) ? $emailDestinatario : array($emailDestinatario);
    foreach ($emailDestinatario as $emailDestino) {
        mail($emailDestino, $assunto, $mensagemHTML, $headers, "-r".$emailRemetente) or $retorno = false;// die('Erro no servidor!');
        //echo 'email: ' . $emailDestino . '<br />';
    }
    return $retorno;
}

?>