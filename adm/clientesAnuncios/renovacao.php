<?php
require_once '../../configRoot.php';

$link = 'http://'.ADMIN_URL.'/principal.php?id=10&subid=1&tipoAnuncio=1';
$codAnuncio = isset($_GET['c']) ? base64_decode($_GET['c']) : 0;
$codCliente = isset($_GET['codCliente']) ? $_GET['codCliente'] : 0;

if($codAnuncio < 1 || $codCliente < 1)
{
    //echo 1;
    printf("<script type='text/javascript'>
				document.location.replace('".$link."');
			</script>");
    die();
}
$qAnunc = mysql_query("SELECT cod FROM clientesAnuncios WHERE codRenovacao = '$codAnuncio'");
$nAnunc = mysql_num_rows($qAnunc);

if($nAnunc < 1)
{
    $q = mysql_query("SELECT ca.* FROM clientesAnuncios AS ca
                      INNER JOIN clientes AS c ON c.cod = ca.codCliente
                      WHERE ca.cod = '$codAnuncio' AND c.cod = '$codCliente' AND c.tipoAnuncio = '1'");
    
    echo mysql_error();
    $n = mysql_num_rows($q);
    if($n > 0)
    {
        $tp = mysql_fetch_assoc($q);
        ///*
        if($tp['status'] == 1)
        {
            //*/
            $qPlano = mysql_query("SELECT * FROM planosParticular WHERE cod = '{$tp['codPlanoParticular']}'");
            $tpPlano = mysql_fetch_assoc($qPlano);
            echo mysql_error();
            
            $dataHoje = date("Y-m-d");
            $dataVencimento = time()+strtotime("+30 days");
            $sql = "INSERT INTO clientesAnuncios 
                    (dataCadastro, codCliente, tipoVeiculo, marca, modelo, versao, placa, anoFabricacao, anoModelo, cor, combustivel,
                    km, nPortas, valor, nParcelas, valorParcela, valorEntrada, caractVeiculo , plano,
                    nFotos, planoValor, nDias, dataLiberacaoAnuncio, dataValidadeAnuncio, codPlanoParticular, codRenovacao)
                    VALUES
                    ('{$dataHoje}', '{$tp['codCliente']}', '{$tp['tipoVeiculo']}', '{$tp['marca']}', '{$tp['modelo']}', '{$tp['versao']}', '{$tp['placa']}', '{$tp['anoFabricacao']}', '{$tp['anoModelo']}', '{$tp['cor']}', '{$tp['combustivel']}',
                    '{$tp['km']}', '{$tp['nPortas']}', '{$tp['valor']}', '{$tp['nParcelas']}', '{$tp['valorParcela']}', '{$tp['valorEntrada']}', '{$tp['caractVeiculo']}', '{$tpPlano['plano']}',
                    '{$tpPlano['nFotos']}', '{$tpPlano['valor']}', '{$tpPlano['tempo']}', '{$dataHoje}', '{$dataVencimento}', '{$tp['codPlanoParticular']}', '{$tp['cod']}');";
            for($a=0;$a<5;$a++)
            {
                $qNew = mysql_query($sql);
                if($qNew)
                {
                    
                    $codNovoAnuncio = mysql_insert_id();
                    $qFotosTipo = mysql_query("SELECT codigo FROM arquivos WHERE codReferencia = '{$codAnuncio}' AND tipo = '1' ORDER BY capa DESC");
                    $nFotosTipo = mysql_num_rows($qFotosTipo);
                    for($b=0;$b<$nFotosTipo;$b++)
                    {
                        $tpFotosTipo = mysql_fetch_assoc($qFotosTipo);
                        $qFotos = mysql_query("SELECT * FROM arquivos WHERE codigo = '{$tpFotosTipo['codigo']}' AND codReferencia = '{$codAnuncio}' ORDER BY capa DESC");
                        $nFotos = mysql_num_rows($qFotos);
                        $token = date('dmYHis').rand(1,99999);
                        for($c=0;$c<$nFotos;$c++)
                        {
                            $tpFotos = mysql_fetch_assoc($qFotos);
                            $copy = false;
                            $ext = pathinfo($tpFotos['arquivo'], PATHINFO_EXTENSION);
                            
                            $arquivo = "foto_".date("Ymdhis")."_".rand(0,99999).".$ext";
                            
                            for($d=0;$d<5;$d++)
                            {
                                $copy = copy(PROJECT_PATH."/arquivos/clientesAnuncios/".$tpFotos['arquivo'], PROJECT_PATH."/arquivos/clientesAnuncios/".$arquivo);
                                if($copy)
                                {
                                    $sqlIns = "INSERT INTO arquivos (referencia, codReferencia,tipo, arquivo, codigo, capa)
                                            VALUES ('clientesAnuncios', '{$codNovoAnuncio}','{$tpFotos['tipo']}', '{$arquivo}','$token', '{$tpFotos['capa']}')";
                            		for($e=0;$e<5;$e++)
                                    {
                                        $qIns = mysql_query($sqlIns);
                                        if($qIns)
                                        {
                                            break;
                                        }
                                    }
                                    break;
                                }
                            }
                        }
                    }
                    $valorPlano = $tpPlano['valor'];
                    if($valorPlano > 0)
                    {
                        $query = mysql_query("SHOW TABLE STATUS LIKE 'boletos'");
                        $row = mysql_fetch_array($query);
                        $codAuto = $row['Auto_increment'] ;
                        $nDoc = str_pad($codAuto,15,0,STR_PAD_LEFT);
                        $dataVencimento = "0000-00-00";
                        $sBol = "INSERT INTO boletos (dataCadastro, codBoleto, codAnuncio, codCliente, nDoc, dataProcessamento, dataVencimento, valor)
                                VALUES('$dataHoje','$codAuto','$codNovoAnuncio','$codCliente','$nDoc','$dataHoje','$dataVencimento','$valorPlano')";
                        for($f=0;$f<5;$f++)
                        {
                            $qBol = mysql_query($sBol);
                            if($qBol)
                            {
                                $codBoleto = mysql_insert_id();
                                echo "COD ANUNCIO: $codNovoAnuncio - COD BOLETO: $codBoleto";
                                printf("<script type='text/javascript'>
                            				alert('Anúncio renovado com sucesso!');
                                            document.location.replace('".$link."');
                            			</script>");
                                die();
                            }    
                        }
                    }
                    /*
                    require_once PROJECT_FUNC_PATH.'cadastroEmail.php';
                    $nomeRemetente = "Kicarrão";
                    $assunto = "Cadastro - Kicarrão";
                    $conteudoEmail = array
                                     (
                                        'nome'      => 'teste',
                                        'email'     => 'teste@teste.teste',
                                        'senha'     => 'teste321'
                                     );
                    
                    $emailDestinatario = array('diego@monge.com.br');//array($email);
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
                    if($conf)
                    {
                        echo " <script> \n";
                        echo " alert(\"Anúncio cadastrado com sucesso!\");\n";
                    	echo " </script> \n";
                    }
                    */
                    //echo $sql;
                    break;
                }
            }
        ///*
        }
        else
        {
            //echo 2;
            printf("<script type='text/javascript'>
        				alert('Este anúncio não pode ser renovado!');
                        document.location.replace('".$link."');
        			</script>");
            die();
        }
        //*/
    }
    else
    {
        //echo 3;
        printf("<script type='text/javascript'>
    				alert('Anúncio não encontrado!');
                    document.location.replace('".$link."');
    			</script>");
        die();
    }
}
else
{
    //echo 3;
    printf("<script type='text/javascript'>
				alert('Anúncio já renovado!');
                document.location.replace('".$link."');
			</script>");
    die();
}



?>
