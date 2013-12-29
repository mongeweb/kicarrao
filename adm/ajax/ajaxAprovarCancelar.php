<?php
require_once '../../configRoot.php';
require_once ADMIN_FUNC_PATH.'conexao.php';
require_once PROJECT_FUNC_PATH.'funcoes.php';
$conexao = conexao(); # Função Implemantada

$codAnuncio = isset($_POST['codAnuncio']) ? $_POST['codAnuncio'] : '';
$tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';
$array = array();

if($codAnuncio != '')
{
	$hoje = date('Y-m-d');
    $sqlAnuncio = mysql_query("SELECT nDias, codRenovacao, codCliente FROM clientesAnuncios WHERE cod = '$codAnuncio'");
    $tpAnuncio = mysql_fetch_assoc($sqlAnuncio);
    $nDias = $tpAnuncio['nDias'];
    $codCliente = $tpAnuncio['codCliente'];
    $validadeAnuncio = date('Y-m-d', strtotime("+".$nDias." days"));
    if($tipo == '1')
    {
        if($tpAnuncio['codRenovacao'] > 0)
        {
            $sqlAnuncioAntigo = mysql_query("SELECT dataValidadeAnuncio FROM clientesAnuncios WHERE cod = '{$tpAnuncio['codRenovacao']}'");
            $tpAnuncioAntigo = mysql_fetch_assoc($sqlAnuncioAntigo);
            $dataValidade = $tpAnuncioAntigo['dataValidadeAnuncio'];
            $timeValidade = strtotime($dataValidade);
            $time = $timeValidade-time();
            $diasTot = (int)floor($time/86400);
            $diasTot = $diasTot > 0 ? $diasTot : 0;
            $validadeAnuncio = date('Y-m-d', strtotime("+".($nDias+$diasTot)." days"));
            
            $sqlUpdateAntigo = mysql_query("UPDATE clientesAnuncios SET
                            status = '3'
                            WHERE cod = {$tpAnuncio['codRenovacao']}");
        }
        $sql = "UPDATE clientesAnuncios SET 
                    status = '$tipo',
                    aprovado = 1,
                    dataValidadeAnuncio = '$validadeAnuncio',
                    dataLiberacaoAnuncio = '$hoje'
                    WHERE cod='$codAnuncio'";
                    
                    
	}
    else
    {
        $sql = "UPDATE clientesAnuncios SET 
                    status = '$tipo'
                    WHERE cod='$codAnuncio'";
    }
    
    for($a=0;$a<5;$a++)
    {
        $query = mysql_query($sql);		
        if($query)
        {
            break;
        }
    }
    
	if($query)
	{
		if($tipo == '1')
        {
            require_once PROJECT_FUNC_PATH.'cadastroEmail.php';
            $sqlEmailCliente = mysql_query("SELECT email FROM clientes WHERE cod = '$codCliente'");
            $tpEmailCliente = mysql_fetch_assoc($sqlEmailCliente);
            $nomeRemetente = "Kicarrão";
            $assunto = "Anúncio Aprovado - Kicarrão";
            $conteudoEmail = array
                             (
                                'codCliente'    => $codCliente,
                                'codAnuncio'    => $codAnuncio
                             );
            
            $emailDestinatario = array($tpEmailCliente['email']);//array($email);
            $emailRemetente = $emailResposta  = 'noreply@kicarrao.com.br';
            $twitter = '';
            $facebook = 'kicarrao';
            
            for($a=0;$a<5;$a++)
            {
                $conf = confirmacaoAnuncio($emailRemetente, $emailDestinatario, $emailResposta, $assunto, $nomeRemetente, $conteudoEmail, $twitter, $facebook);		
                if($conf)
                {
                    break;
                }
            }  
        }
        $array['retorno'] = 1;
	}
	else
	{
		$array['retorno'] = 0;
	}
}
else
{
	$array['retorno'] = 0;
}
echo json_encode($array);
?>