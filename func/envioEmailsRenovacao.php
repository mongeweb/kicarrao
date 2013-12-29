<?php
function envioEmailsRenovacao()
{
    $dataHoje = date('Y-m-d');
    $dataUmDia = date('Y-m-d', strtotime("+1 days"));
    $dataTresDia = date('Y-m-d', strtotime("+3 days"));
    $dataCincoDia = date('Y-m-d', strtotime("+5 days"));
    $horaHoje = date('H');
    $dataHoraHoje = date('Y-m-d H:i:s');
    
    $sqlDataHora = mysql_query("SELECT HOUR(dataHoraEnvio) AS horaEnvio, DATE(dataHoraEnvio) AS dataEnvio, total FROM enviosRenovacaoDataHora WHERE cod = '1'");
    $tpDataHora = mysql_fetch_assoc($sqlDataHora);
    
    if(($tpDataHora['dataEnvio'] == $dataHoje && $horaHoje > $tpDataHora['horaEnvio'] && $tpDataHora['total'] == 0) || $dataHoje > $tpDataHora['dataEnvio'])
    {
        if($dataHoje > $tpDataHora['dataEnvio'])
        {  
            $upDataHora = "UPDATE enviosRenovacaoDataHora SET dataHoraEnvio = '{$dataHoraHoje}', total = '0' WHERE cod = '1'";
            for($x = 0;$x < 5;$x++)
            {
                $updateDataHora = mysql_query($upDataHora);
                if($updateDataHora)
                    break;
            }
        }
        
        $sqlVerificaRenClientes = mysql_query("SELECT * FROM enviosRenovacoesClientes ORDER BY diasRenovacao");
        $numVerificaRenClientes = mysql_num_rows($sqlVerificaRenClientes);
        
        if($numVerificaRenClientes == 0)
        {
            $sqlAnunciosVerificaEmail = mysql_query("SELECT ca.cod, ca.codCliente, ca.dataValidadeAnuncio, vm.marca, c.razaoSocialNome, c.sobrenome, c.email, vv.versao,
                                    (SELECT a.arquivo FROM arquivos AS a WHERE a.codReferencia = ca.cod
                                    AND a.referencia = 'clientesAnuncios' AND a.tipo = 1 ORDER BY a.capa DESC LIMIT 1) AS arquivo
                                    FROM clientesAnuncios AS ca 
                                    INNER JOIN clientes AS c ON c.cod = ca.codCliente
                                    INNER JOIN veiculosMarcas AS vm ON vm.cod = ca.marca
                                    LEFT JOIN veiculosVersoes AS vv ON vv.cod = ca.versao
                                    WHERE c.tipoAnuncio = 1 AND ca.codPlanoParticular > 0 AND (ca.dataValidadeAnuncio = '{$dataUmDia}') OR (ca.dataValidadeAnuncio = '{$dataTresDia}') OR (ca.dataValidadeAnuncio = '{$dataCincoDia}')");
            $numAnunciosVerificaEmail = mysql_num_rows($sqlAnunciosVerificaEmail);
            for($xx = 0;$xx < $numAnunciosVerificaEmail;$xx++)
            {
                $tpAnunciosVerificaEmail = mysql_fetch_assoc($sqlAnunciosVerificaEmail);
                $diasParaVencer = $tpAnunciosVerificaEmail['dataValidadeAnuncio'] == $dataUmDia ? 1 : ($tpAnunciosVerificaEmail['dataValidadeAnuncio'] == $dataTresDia ? 3 : ($tpAnunciosVerificaEmail['dataValidadeAnuncio'] == $dataCincoDia ? 5 : 0));
                if($diasParaVencer > 0)
                {
                    $dadosAnuncio = $tpAnunciosVerificaEmail['marca'].' '.$tpAnunciosVerificaEmail['versao'];
                    $nomeSobrenome = $tpAnunciosVerificaEmail['razaoSocialNome'].' '.$tpAnunciosVerificaEmail['sobrenome'];
                    $linkRenovacao = '';
                    $linkAnuncio = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/detalhe/'.$tpAnunciosVerificaEmail['cod'] : sslRedir().PROJECT_URL.'/busca-detalhe.php?cod='.$tpAnunciosVerificaEmail['cod'];
                    $sqlInsereRenClientes = "INSERT INTO enviosRenovacoesClientes 
                                            (dataCadastro, codAnuncio, codCliente, dadosAnuncio, foto, diasParaVencer, email, nome, linkAnuncio, linkRenovacao) VALUES 
                                            ('{$dataHoje}', '{$tpAnunciosVerificaEmail['cod']}', '{$tpAnunciosVerificaEmail['codCliente']}', '{$dadosAnuncio}', '{$tpAnunciosVerificaEmail['arquivo']}', '{$diasParaVencer}', '{$tpAnunciosVerificaEmail['email']}', '{$nomeSobrenome}', '{$linkAnuncio}', '{$linkRenovacao}')";
                    for($xy = 0;$xy < 5;$xy++)
                    {
                        $queryInsereRenClientes = mysql_query($sqlInsereRenClientes);
                        if($queryInsereRenClientes)
                            break;
                    }
                    $sqlInsereRenClientesBkp = "INSERT INTO enviosRenovacoesClientesBkp 
                                            (dataCadastro, codAnuncio, codCliente, dadosAnuncio, foto, diasParaVencer, email, nome, linkAnuncio, linkRenovacao) VALUES 
                                            ('{$dataHoje}', '{$tpAnunciosVerificaEmail['cod']}', '{$tpAnunciosVerificaEmail['codCliente']}', '{$dadosAnuncio}', '{$tpAnunciosVerificaEmail['arquivo']}', '{$diasParaVencer}', '{$tpAnunciosVerificaEmail['email']}', '{$nomeSobrenome}', '{$linkAnuncio}', '{$linkRenovacao}')";
                    for($xy = 0;$xy < 5;$xy++)
                    {
                        $queryInsereRenClientesBkp = mysql_query($sqlInsereRenClientesBkp);
                        if($queryInsereRenClientesBkp)
                            break;
                    }
                }   
            }
        }
        $sqlEnviosRenClientes = mysql_query("SELECT * FROM enviosRenovacoesClientes ORDER BY diasRenovacao");
        $numEnviosRenClientes = mysql_num_rows($sqlEnviosRenClientes);
        for($x = 0;$x < $numEnviosRenClientes;$x++)
        {
            $tpEnviosRenClientes = mysql_fetch_assoc($sqlEnviosRenClientes);
            $enviaEmail = enviarEmailsRenovacao($tpEnviosRenClientes['codAnuncio'], $tpEnviosRenClientes['codCliente'], $tpEnviosRenClientes['dadosAnuncio'], $tpEnviosRenClientes['foto'], $tpEnviosRenClientes['diasParaVencer'], $tpEnviosRenClientes['email'], $tpEnviosRenClientes['nome'],  $tpEnviosRenClientes['linkAnuncio'],  $tpEnviosRenClientes['linkRenovacao']);
            if($enviaEmail)
            {
                $apagaEnviosRenClientes = "DELETE FROM enviosRenovacoesClientes WHERE cod = '{$tpEnviosRenClientes['cod']}'";
                for($xy = 0;$xy < 5;$xy++)
                {
                    $queryApagaEnviosRenClientes = mysql_query($apagaEnviosRenClientes);
                    if($queryApagaEnviosRenClientes)
                        break;
                }
            
                if($x == ($numEnviosRenClientes-1))
                {
                    $upDataHora = "UPDATE enviosRenovacaoDataHora SET dataHoraEnvio = '{$dataHoraHoje}', total = '1' WHERE cod = '1'";
                    for($xx = 0;$xx < 5;$xx++)
                    {
                        $updateDataHora = mysql_query($upDataHora);
                        if($updateDataHora)
                            break;
                    }
                    break;
                }
                if($x >= 249)
                {
                    break;
                }
            }
        }
    }
}
?>