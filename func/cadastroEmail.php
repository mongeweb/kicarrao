<?php
/*

 * @param String $emailRemetente                        Email do remetente.
 * @param Array  $emailDestinatario                     Array de emails para enviar.
 * @param String $emailResposta                         Email de resposta.
 * @param String $assunto                               Assunto do email. 
 * @param String $nomeRemetente                         Nome do remetente do email(pode ser o nome do site).
 * @param Array  $conteudoEmail                         Nome dos campos para montar a mensagem.
 * @return bool

*/
function cadastroEmail($emailRemetente = 'email@dominio.com', $emailDestinatario = 'email@dominio.com', $emailResposta = 'email@dominio.com', $assunto = '', $nomeRemetente = '', $conteudoEmail = array(), $twitter = '', $facebook = '', $formulario = 1)
{
    require_once "mailer/class.phpmailer.php";
    $retorno = true;
    
    $nome = array_key_exists('nome',$conteudoEmail) ? $conteudoEmail['nome'] : '';
    $email = array_key_exists('email',$conteudoEmail) ? $conteudoEmail['email'] : '';
    $senha = array_key_exists('senha',$conteudoEmail) ? $conteudoEmail['senha'] : '';
    $tipoAnuncio = array_key_exists('tipoAnuncio',$conteudoEmail) ? $conteudoEmail['tipoAnuncio'] : 2;
    
    $textoEmail_1 = "<body style='margin: 0; padding:0;'>
                    	<div class='mestre' style='float: left; width:600px;'>
                        	<div class='topo' style='float:left; width:100%;'>
                            	<a style='display: block;' href='http://www.kicarrao.com.br' target='_blank'>
                                	<img style='border:none;' src='http://www.kicarrao.com.br/img/padrao-email/topo.jpg' alt='KiCarrão' />
                            	</a>
                        	</div>
                        	<div class='centro' style='float: left; width:100%; min-height:362px;'>
                            	<div style='float: left; margin-left:14px; margin-right:14px;'>
									<p style='background: url('http://www.kicarrao.com.br/img/padrao-email/fundotarja.png') no-repeat; width:559px; height:41px; color:#FFF; font-family:Arial, Helvetica, sans-serif; font-size:17px; font-weight:bold; line-height:41px; margin-top:35px; margin-bottom:0; padding-left:13px;'>
										Cadastro - Kicarrão
									</p>
									<div style='font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#1A1A1A; margin-top:28px; margin-left:19px;'>
										<span style='color: #E6332C;'>".$nome."</span> <b>, seja bem-vindo ao Portal Kicarrão!</b><br />
										<br />
										Agora você pode desfrutar de todos os benefícios de ter uma conta no<br /> Portal Kicarrão.<br />
										<ul style='padding-left:13px; font-size:13px;'>
											<li><b>Veja todos os seus anúncios em um só lugar</b></li>
											<li><b>Edite e exclua seus anúncios de forma rápida e fácil</b></li>
											<li><b>Crie e altere seu perfil com segurança e agilidade</b></li>
										</ul>
										Seus dados para acesso ao portal são:<br />
										<br />
										Usuário: <span style='color: #E6332C;'>".$email."</span><br />
										Senha: <span style='color: #E6332C;'>".$senha."</span><br />
										<br />
										
										<p style='font-size:13px; text-align: center;'>Esperamos que aprecie a utilização do nosso portal.</p>
										
										<p style='font-size:13px;'>
											Obrigado por utilizar o Kicarrão,<br /><br />
											<b>Equipe da Kicarrão</b>
										</p>
										<br /><br /><br />
										<p style='color:#5F5F5F; font-size:13px; font-weight:bold; float:left; width:100%;'>
											<span style='padding:0 12px;'>Suporte: 51 8480 2943</span>
											<span style='padding:0 12px;'>Skype: sac.kicarrao</span>
											<span style='padding:0 12px;'>E-mail: suporte@kicarrao.com.br</span>
										</p>
									</div>
                            	</div>
                        	</div>
							<div style='background: #D1D1D1; float: left; width:100%; padding-top:32px; min-height:82px;'>
								<div style='display: table-cell; vertical-align:top; padding-left:27px; padding-top:0; padding-bottom:0; color:#A60F09; font-family:Arial, Helvetica, sans-serif; font-size: 17px; font-weight:bold;'>
									Acompanhe o Kicarrão nas<br /> 
									<span style='font-size: 22px; display:block; padding-top:5px;'>Redes Sociais</span>
								</div>
								<div style='display: table-cell; vertical-align:middle; text-align: right; min-width: 344px;'>
									<a style='border:none; padding-right: 7px; text-decoration:none;' href='https://www.facebook.com/kicarrao' target='_blank'>
										<img style='border:none;' src='http://www.kicarrao.com.br/img/padrao-email/facebook.png' />
									</a>
									<a style='border:none; padding-right: 7px; text-decoration:none;' href='https://twitter.com/kicarrao' target='_blank'>
										<img style='border:none;' src='http://www.kicarrao.com.br/img/padrao-email/twitter.png' />
									</a>
									<a style='border:none; padding-right: 7px; text-decoration:none;' href='http://instagram.com/kicarrao' target='_blank'>
										<img style='border:none;' src='http://www.kicarrao.com.br/img/padrao-email/instagram.png' />
									</a>
									<a style='border:none; padding-right: 7px; text-decoration:none;' href='http://www.youtube.com/user/kicarrao?feature=watch' target='_blank'>  
										<img style='border:none;' src='http://www.kicarrao.com.br/img/padrao-email/youtube.png' />
									</a>
								</div> 
							</div>
							<div class='rodape' style='float:left; width:100%;'>
								<a style='display: block; border:none;' href='http://www.kicarrao.com.br' target='_blank'>
									<img style='border:none;' src='http://www.kicarrao.com.br/img/padrao-email/rodape.jpg' alt='KiCarrão' />
								</a>
							</div>
                    	</div>
                      </body>";			   
    
    
            
    $emailDestinatario_1 = is_array($emailDestinatario) ? $emailDestinatario : array($emailDestinatario);
    
	
    $mail = new PHPMailer();
    $mail->IsMail();
    $mail->SetFrom("$emailRemetente",$nomeRemetente);
    $mail->IsHTML(true);
	$mail->Subject = $assunto;
	$mail->Body    = $textoEmail_1;
    foreach ($emailDestinatario_1 as $emailDestino)
    {
        $mail->AddAddress($emailDestino); 
        $mail->Send();
	
    	$mail->ClearAllRecipients();
    	$mail->ClearAttachments();       
    }
	
	$emailDestinatario_2 = array('financeiro@kicarrao.com.br','programacao@monge.com.br');
	$textoEmail_2 = "<body style='margin: 0; padding:0;'>
                    	<div class='mestre' style='float: left; width:600px;'>
                        	<div class='topo' style='float:left; width:100%;'>
                            	<a style='display: block;' href='http://www.kicarrao.com.br' target='_blank'>
                                	<img style='border:none;' src='http://www.kicarrao.com.br/img/padrao-email/topo.jpg' alt='KiCarrão' />
                            	</a>
                        	</div>
                        	<div class='centro' style='float: left; width:100%; min-height:362px;'>
                            	<div style='float: left; margin-left:14px; margin-right:14px;'>
									<p style='background: url('http://www.kicarrao.com.br/img/padrao-email/fundotarja.png') no-repeat; width:559px; height:41px; color:#FFF; font-family:Arial, Helvetica, sans-serif; font-size:17px; font-weight:bold; line-height:41px; margin-top:35px; margin-bottom:0; padding-left:13px;'>
										Novo Cadastro - Kicarrão
									</p>
									<div style='font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#1A1A1A; margin-top:28px; margin-left:19px;'>
										<span style='color: #E6332C;'>Cliente: ".$nome."</span>
										<br />
										<br />
										Dados de acesso ao portal:<br />
										<br />
										Usuário: <span style='color: #E6332C;'>".$email."</span><br />
										Senha: <span style='color: #E6332C;'>".$senha."</span><br />
										<br />";
		$textoEmail_2 .="</div>
                            	</div>
                        	</div>
							<div style='background: #D1D1D1; float: left; width:100%; padding-top:32px; min-height:82px;'>
								<div style='display: table-cell; vertical-align:middle; text-align: right; min-width: 344px;'>
									<a style='border:none; padding-right: 7px; text-decoration:none;' href='https://www.facebook.com/kicarrao' target='_blank'>
										<img style='border:none;' src='http://www.kicarrao.com.br/img/padrao-email/facebook.png' />
									</a>
									<a style='border:none; padding-right: 7px; text-decoration:none;' href='https://twitter.com/kicarrao' target='_blank'>
										<img style='border:none;' src='http://www.kicarrao.com.br/img/padrao-email/twitter.png' />
									</a>
									<a style='border:none; padding-right: 7px; text-decoration:none;' href='http://instagram.com/kicarrao' target='_blank'>
										<img style='border:none;' src='http://www.kicarrao.com.br/img/padrao-email/instagram.png' />
									</a>
									<a style='border:none; padding-right: 7px; text-decoration:none;' href='http://www.youtube.com/user/kicarrao?feature=watch' target='_blank'>  
										<img style='border:none;' src='http://www.kicarrao.com.br/img/padrao-email/youtube.png' />
									</a>
								</div> 
							</div>
							<div class='rodape' style='float:left; width:100%;'>
								<a style='display: block; border:none;' href='http://www.kicarrao.com.br' target='_blank'>
									<img style='border:none;' src='http://www.kicarrao.com.br/img/padrao-email/rodape.jpg' alt='KiCarrão' />
								</a>
							</div>
                    	</div>
                      </body>";
	
		$mail = new PHPMailer();
		$mail->IsMail();
		$mail->SetFrom("$emailRemetente",$nomeRemetente);
		$mail->IsHTML(true);
		$mail->Subject = $assunto;
		$mail->Body    = $textoEmail_2;
		foreach ($emailDestinatario_2 as $emailDestino)
		{
			$mail->AddAddress($emailDestino); 
			$mail->Send();
		
			$mail->ClearAllRecipients();
			$mail->ClearAttachments();       
		}

    return $retorno;   
}

function confirmacaoAnuncio($emailRemetente = 'email@dominio.com', $emailDestinatario = 'email@dominio.com', $emailResposta = 'email@dominio.com', $assunto = '', $nomeRemetente = '', $conteudoEmail = array(), $twitter = '', $facebook = '')
{
    require_once "mailer/class.phpmailer.php";
    $retorno = true;
    
    $codCliente = array_key_exists('codCliente',$conteudoEmail) ? $conteudoEmail['codCliente'] : '';
    $codAnuncio = array_key_exists('codAnuncio',$conteudoEmail) ? $conteudoEmail['codAnuncio'] : '';
    
    $sqlAnuncios = mysql_query("SELECT ca.cod, ca.cor, ca.dataValidadeAnuncio, ca.anoFabricacao, ca.anoModelo, vm.marca, vmd.modelo, vv.versao,
            ca.valor, c.razaoSocialNome, ca.plano,
            (SELECT a.arquivo FROM arquivos AS a WHERE a.codReferencia = ca.cod 
            AND a.referencia = 'clientesAnuncios' AND a.tipo = 1 ORDER BY a.capa DESC LIMIT 1) AS arquivo
            FROM clientesAnuncios AS ca
            INNER JOIN clientes AS c ON c.cod = ca.codCliente
            INNER JOIN veiculosMarcas AS vm ON vm.cod = ca.marca
            LEFT JOIN veiculosModelos AS vmd ON vmd.cod = ca.modelo
            LEFT JOIN veiculosVersoes AS vv ON vv.cod = ca.versao
            WHERE ca.cod = '$codAnuncio' AND ca.codCliente = '$codCliente'");
            echo mysql_error();
    $tpAnuncios = mysql_fetch_assoc($sqlAnuncios);
    
    $marca = $tpAnuncios['marca'];
    $modelo = $tpAnuncios['modelo'];
    $versao = $tpAnuncios['versao'];
    $nome = $tpAnuncios['razaoSocialNome'];
    $anoFabricacao = $tpAnuncios['anoFabricacao'];
    $anoModelo = $tpAnuncios['anoModelo'];
    $cor = $tpAnuncios['cor'];
    $valor = number_format((float)$tpAnuncios['valor'],2,',','.');
    $dataValidadeAnuncio = dataBr($tpAnuncios['dataValidadeAnuncio']);
    $plano = $tpAnuncios['plano'];
    $arquivo = $tpAnuncios['arquivo'];
    
    $textoEmail = "<body style='margin: 0; padding:0;'>";
    $textoEmail .=   "<div class='mestre' style='width:600px;'>";
    $textoEmail .=       "<div class='topo' style='width:100%;'>";
    $textoEmail .=           "<a style='display: block;' href='https://www.kicarrao.com.br' target='_blank'><img style='display: block;' src='https://www.kicarrao.com.br/img/padrao-email/topo.jpg' alt='KiCarrão' /></a>";
    $textoEmail .=       "</div>";
    $textoEmail .=       "<div class='centro' style='width:100%; min-height:362px;'>";
    $textoEmail .=           "<div style='float: left; padding-left:14px; padding-right:14px;'><br /><br />";
    $textoEmail .=              "<p style='background: #BE1F25; width:559px; height:41px; color:#FFF; font-family:Arial, Helvetica, sans-serif; font-size:17px; font-weight:bold; line-height:41px; padding-bottom:0; padding-left:13px;'>";
    $textoEmail .=                  "Anúncio Aprovado - Kicarrão";
    $textoEmail .=              "</p>";
    $textoEmail .=              "<div style='font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#1A1A1A; padding-left:19px;'>";
    $textoEmail .=                  "<b>".$nome.", Parabéns!</b><br />";
    $textoEmail .=                  "<br />";
    $textoEmail .=                  "<b>Seu anúncio estará disponível no Portal Kicarrão de 3 a 6 horas.</b><br />";
    $textoEmail .=                  "Anúncio<br /><br />";
    $textoEmail .=                  "<table style='border: 1px solid #808285; width:531px;' cellspacing='0' cellpadding='0'>";
    $textoEmail .=                     "<tr>";
    $textoEmail .=                         "<td style='padding-top:23px; padding-left:26px; padding-bottom:14px; min-width: 108px;'>";
    if($arquivo != '')
    {
        $textoEmail .=                             "<img src='".ssl().PROJECT_URL."/arquivos/clientesAnuncios/".$arquivo."' alt='Confirmação de cadastro do anúncio' />";   
    }
    $textoEmail .=                         "</td>";
    $textoEmail .=                         "<td style='padding-left:10px; padding-top:5px; padding-bottom:2px;'>";
    $textoEmail .=                             "<p style='border-right: 1px solid #808285; width:156px; font-size:13px;'>";
    $textoEmail .=                                 "<b>".$marca." ".$versao."</b><br />";
    $textoEmail .=                                 "Cor: ".$cor."<br />";
    $textoEmail .=                                 "Ano: ".$anoFabricacao.($anoModelo != '' ? "/".$anoModelo : '')."<br />";
    $textoEmail .=                                 "Valor: R$ ".$valor;
    $textoEmail .=                             "</p>";
    $textoEmail .=                         "</td>";
    $textoEmail .=                         "<td style='width: 220px; text-align:center; vertical-align:middle; font-size:13px;'>";
    $textoEmail .=                             "<b>Plano ".$plano."<br /> Validade: ".$dataValidadeAnuncio."</b>";
    $textoEmail .=                         "</td>";
    $textoEmail .=                     "</tr>";
    $textoEmail .=                 "</table>";
    $textoEmail .=                 "<br />";
    $textoEmail .=                 "<table style='width:534px;'>";
    $textoEmail .=                     "<tr><td align='left'>"; 
    $textoEmail .=                          "<a href='http://www.kicarrao.com.br/identificacao' target='_blank' style='display:inline-block; text-align:left; width: 157px; height:31px; line-height:31px; background:#970E08; color:#FFF; font-size:14px; text-transform:uppercase; text-align:center; text-decoration:none;'>Visualizar Anúncio</a>";
    $textoEmail .=                     "</td>";
    $textoEmail .=                     "<td>&nbsp;</td>";
    $qBoleto = mysql_query("SELECT cod FROM boletos WHERE codAnuncio = '$codAnuncio' AND codCliente = '$codCliente' ORDER BY cod DESC LIMIT 1");
    $nBoleto = mysql_num_rows($qBoleto);
    if($nBoleto > 0)
    {
        $tpBoleto = mysql_fetch_assoc($qBoleto);
        $link = sslRedir().PROJECT_URL."/boleto/visualizar.php?b=".base64_encode($tpBoleto['cod']);
        $textoEmail .=                 "<td align='right'>";
        $textoEmail .=                      "<a href='".$link."' target='_blank' style='display:inline-block; text-align:right; width: 157px; height:31px; line-height:31px; background:#970E08; color:#FFF; font-size:14px; text-transform:uppercase; text-align:center; text-decoration:none;'>Visualizar Boleto</a>";
        $textoEmail .=                     "</td>";
    }
    $textoEmail .=                     "</tr>";
    $textoEmail .=                 "</table>"; 
    $textoEmail .=                 "<br /><br /><br />";
    $textoEmail .=                 "<p style='font-size:13px;'>";
    $textoEmail .=                      "Obrigado por utilizar o Kicarrão,<br /><br />";
    $textoEmail .=                      "<b>Equipe da Kicarrão</b>";
    $textoEmail .=                 "</p>";
    $textoEmail .=                 "<br />";
    $textoEmail .=             "</div>";
    $textoEmail .=          "</div>";
    $textoEmail .=       "</div>";
    $textoEmail .=         "<div style='background:#D1D1D1; width:100%; padding-top:32px; min-height:82px; clear:both;'>";
    $textoEmail .=             "<p style='display:inline-block; padding-left:27px; padding-top:0; padding-bottom:0; color:#A60F09; font-family:Arial, Helvetica, sans-serif; font-size: 17px; font-weight:bold;'>";
    $textoEmail .=               "Acompanhe o Kicarrão nas<br />"; 
    $textoEmail .=               "<span style='font-size: 22px; display:block; padding-top:5px;'>Redes Sociais</span>";
    $textoEmail .=             "</p>";
    $textoEmail .=             "<div style='display: inline-block; padding-right: 17px; text-align: right; min-width: 344px;'>";
    $textoEmail .=                 "<a style='padding-right: 7px;' href='https://www.facebook.com/kicarrao' target='_blank'><img src='https://www.kicarrao.com.br/img/padrao-email/facebook.png' /></a>";
    $textoEmail .=                 "<a style='padding-right: 7px;' href='https://twitter.com/kicarrao' target='_blank'><img src='https://www.kicarrao.com.br/img/padrao-email/twitter.png' /></a>";
    $textoEmail .=                 "<a style='padding-right: 7px;' href='http://instagram.com/kicarrao' target='_blank'><img src='https://www.kicarrao.com.br/img/padrao-email/instagram.png' /></a>";
    $textoEmail .=                 "<a style='padding-right: 7px;' href='http://www.youtube.com/user/kicarrao?feature=watch' target='_blank'><img src='https://www.kicarrao.com.br/img/padrao-email/youtube.png' /></a>";
    $textoEmail .=             "</div>"; 
    $textoEmail .=         "</div>";
    $textoEmail .=         "<div class='rodape' style='width:100%;'>";
    $textoEmail .=             "<a style='display: block;' href='http://www.kicarrao.com.br' target='_blank'>";
    $textoEmail .=                 "<img src='https://www.kicarrao.com.br/img/padrao-email/rodape.jpg' alt='KiCarrão' />";
    $textoEmail .=             "</a>";
    $textoEmail .=         "</div>";
    $textoEmail .=     "</div>";
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

function cadastroGuia($emailRemetente = 'email@dominio.com', $emailDestinatario = 'email@dominio.com', $emailResposta = 'email@dominio.com', $assunto = '', $nomeRemetente = '', $conteudoEmail = array(), $twitter = '', $facebook = '')
{
    require_once "mailer/class.phpmailer.php";
    $retorno = true;
 	
	$empresa = array_key_exists('empresa',$conteudoEmail) ? $conteudoEmail['empresa'] : '';
    $fone = array_key_exists('fone',$conteudoEmail) ? $conteudoEmail['fone'] : '';
    $email = array_key_exists('e-mail',$conteudoEmail) ? $conteudoEmail['e-mail'] : '';
	$cidade = array_key_exists('cidade',$conteudoEmail) ? $conteudoEmail['cidade'] : '';
	$estado = array_key_exists('estado',$conteudoEmail) ? $conteudoEmail['estado'] : '';
	  
	$emailDestinatario = array('financeiro@kicarrao.com.br','programacao@monge.com.br');
	$textoEmail = "<body style='margin: 0; padding:0;'>
                    	<div class='mestre' style='float: left; width:600px;'>
                        	<div class='topo' style='float:left; width:100%;'>
                            	<a style='display: block;' href='http://www.kicarrao.com.br' target='_blank'>
                                	<img style='border:none;' src='http://www.kicarrao.com.br/img/padrao-email/topo.jpg' alt='KiCarrão' />
                            	</a>
                        	</div>
                        	<div class='centro' style='float: left; width:100%; min-height:362px;'>
                            	<div style='float: left; margin-left:14px; margin-right:14px;'>
									<p style='background: url('http://www.kicarrao.com.br/img/padrao-email/fundotarja.png') no-repeat; width:559px; height:41px; color:#FFF; font-family:Arial, Helvetica, sans-serif; font-size:17px; font-weight:bold; line-height:41px; margin-top:35px; margin-bottom:0; padding-left:13px;'>
										Novo Cadastro - Kicarrão
									</p>
									<div style='font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#1A1A1A; margin-top:28px; margin-left:19px;'>
										Empresa:<span style='color: #E6332C;'> ".$empresa."</span><br />
										Fone: <span style='color: #E6332C;'>".$fone."</span><br />
										E-mail: <span style='color: #E6332C;'>".$email."</span><br />
										Cidade: <span style='color: #E6332C;'>".$cidade."</span><br />
										Estado: <span style='color: #E6332C;'>".$estado."</span><br />
									</div>
                            	</div>
                        	</div>
							<div style='background: #D1D1D1; float: left; width:100%; padding-top:32px; min-height:82px;'>
								<div style='display: table-cell; vertical-align:middle; text-align: right; min-width: 344px;'>
									<a style='border:none; padding-right: 7px; text-decoration:none;' href='https://www.facebook.com/kicarrao' target='_blank'>
										<img style='border:none;' src='http://www.kicarrao.com.br/img/padrao-email/facebook.png' />
									</a>
									<a style='border:none; padding-right: 7px; text-decoration:none;' href='https://twitter.com/kicarrao' target='_blank'>
										<img style='border:none;' src='http://www.kicarrao.com.br/img/padrao-email/twitter.png' />
									</a>
									<a style='border:none; padding-right: 7px; text-decoration:none;' href='http://instagram.com/kicarrao' target='_blank'>
										<img style='border:none;' src='http://www.kicarrao.com.br/img/padrao-email/instagram.png' />
									</a>
									<a style='border:none; padding-right: 7px; text-decoration:none;' href='http://www.youtube.com/user/kicarrao?feature=watch' target='_blank'>  
										<img style='border:none;' src='http://www.kicarrao.com.br/img/padrao-email/youtube.png' />
									</a>
								</div> 
							</div>
							<div class='rodape' style='float:left; width:100%;'>
								<a style='display: block; border:none;' href='http://www.kicarrao.com.br' target='_blank'>
									<img style='border:none;' src='http://www.kicarrao.com.br/img/padrao-email/rodape.jpg' alt='KiCarrão' />
								</a>
							</div>
                    	</div>
                      </body>";
	
	
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