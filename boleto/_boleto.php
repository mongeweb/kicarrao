<?php
require_once '../configRoot.php';
$link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL."/home" : sslRedir().PROJECT_URL."/home.php";
$codAnuncio = isset($_SESSION['boleto']['codAnuncio']) ? $_SESSION['boleto']['codAnuncio'] : 0;
$codCliente = isset($_SESSION['boleto']['codCliente']) ? $_SESSION['boleto']['codCliente'] : 0;
$valorPlano = isset($_SESSION['boleto']['valor']) ? $_SESSION['boleto']['valor'] : 0;


if($codCliente == 0 || $valorPlano == 0)
{
    echo 1;
    printf("<script type='text/javascript'>
					location.replace('".$link."');
				</script>");
    die();
}
//echo $codCliente."<br />";
$qCli = mysql_query("SELECT * FROM clientes WHERE cod = '$codCliente' LIMIT 1"); 
$nCli = mysql_num_rows($qCli);
if($nCli < 1)
{
    echo 2;
    printf("<script type='text/javascript'>
				location.replace('".$link."');
			</script>");
    die();
}
else
{
    $tpCli = mysql_fetch_assoc($qCli);
    $tipoAnuncio = $tpCli['tipoAnuncio'];
    $query = mysql_query("SHOW TABLE STATUS LIKE 'boletos'");
    $row = mysql_fetch_array($query);
    $cod = $row['Auto_increment'] ;
    
    
    if($tipoAnuncio == 2)
    { 
        $dias_para_pagamento = 40;
        $data_venc = date("d/m/Y", time()+($dias_para_pagamento*86400));
        $dataVencimento = date("Y-m-d", time()+($dias_para_pagamento*86400));
    }
    else
    {
        $data_venc = "CONTRA-APRESENTAÇÃO";
        $dataVencimento = "0000-00-00";
    }
    $valor_cobrado = $valorPlano; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
    $dataHoje = date("Y-m-d");
    $data = date("d/m/Y");
    
    $nDoc = str_pad($cod,15,0,STR_PAD_LEFT);
    $taxa_boleto = 0;
    $valor_cobrado = str_replace(",", ".",$valor_cobrado);
    $valor_boleto = number_format((float)$valor_cobrado+(float)$taxa_boleto, 2, ',', '');
    
    // Composição Nosso Numero - CEF SIGCB
    $dadosboleto["nosso_numero1"] = substr($nDoc,0,3); // tamanho 3
    $dadosboleto["nosso_numero_const1"] = "2"; //constanto 1 , 1=registrada , 2=sem registro
    $dadosboleto["nosso_numero2"] = substr($nDoc,3,3); // tamanho 3
    $dadosboleto["nosso_numero_const2"] = "4"; //constanto 2 , 4=emitido pelo proprio cliente
    $dadosboleto["nosso_numero3"] = substr($nDoc,6,9); // tamanho 9
    
    
    
    $dadosboleto["numero_documento"] = $nDoc;//"4007700000003823";	// Num do pedido ou do documento
    $dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
    $dadosboleto["data_documento"] = $data; // Data de emissão do Boleto
    //$dadosboleto["data_documento"] = "23/08/2006"; // Data de emissão do Boleto
    $dadosboleto["data_processamento"] = $data; // Data de processamento do boleto (opcional)
    //$dadosboleto["data_processamento"] = "23/08/2006"; // Data de processamento do boleto (opcional)
    $dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula
    
    // DADOS DO SEU CLIENTE
    $dadosboleto["sacado"] = $tpCli['razaoSocialNome'];
    $complemento = $tpCli['complemento'];
    $dadosboleto["endereco1"] = $tpCli['endereco'].", ".$tpCli['numero'].($complemento != '' ? " - ".$complemento : '');
    $dadosboleto["endereco2"] = $tpCli['cidade']." - ".$tpCli['estado']." - ".$tpCli['cep'];
    
    // INFORMACOES PARA O CLIENTE
    $dadosboleto["demonstrativo1"] = "Pagamento de Anúncio no site www.kicarrao.com.br";
    $dadosboleto["demonstrativo2"] = "";
    $dadosboleto["demonstrativo3"] = "";
    
    // INSTRUÇÕES PARA O CAIXA
    $dadosboleto["instrucoes1"] = "";
    $dadosboleto["instrucoes2"] = "";
    $dadosboleto["instrucoes3"] = "";
    $dadosboleto["instrucoes4"] = "";
    
    // DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
    $dadosboleto["quantidade"] = "";
    $dadosboleto["valor_unitario"] = "";
    $dadosboleto["aceite"] = "";		
    $dadosboleto["especie"] = "R$";
    $dadosboleto["especie_doc"] = "";
    
    
    // ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //
    
    
    // DADOS DA SUA CONTA - CEF
    $dadosboleto["agencia"] = "0451"; // Num da agencia, sem digito
    $dadosboleto["conta"] = ""; 	// Num da conta, sem digito
    $dadosboleto["conta_dv"] = ""; 	// Digito do Num da conta
    
    // DADOS PERSONALIZADOS - CEF
    $dadosboleto["conta_cedente"] = "408911"; // Código Cedente do Cliente, com 6 digitos (Somente Números)
    $dadosboleto["carteira"] = "SR";  // Código da Carteira: pode ser SR (Sem Registro) ou CR (Com Registro) - (Confirmar com gerente qual usar)
    
    // SEUS DADOS
    $dadosboleto["identificacao"] = "Kicarrao - Código Aberto de Sistema de Boletos";
    $dadosboleto["cpf_cnpj"] = "14575022/0001-94";
    $dadosboleto["endereco"] = "";//"Rua teste, 123";
    $dadosboleto["cidade_uf"] = "";//"Porto Alegre/RS";
    $dadosboleto["cedente"] = "Portal Kicarrao.com.br";
    
    // NÃO ALTERAR!
    include("include/funcoes_cef_sigcb.php"); 
    include("include/layout_cef.php");
    
    $sBol = "INSERT INTO boletos (dataCadastro, codBoleto, codAnuncio, codCliente, nDoc, dataProcessamento, dataVencimento, valor)
            VALUES('$dataHoje','$cod','$codAnuncio','$codCliente','$nDoc','$dataHoje','$dataVencimento','$valorPlano')";
    //echo $valorPlano;//$dadosboleto["codigo_barras"]." - ".$dadosboleto["linha_digitavel"];
    for($a=0;$a<5;$a++)
    {
        $qBol = mysql_query($sBol);
        if($qBol)
        {
            break;
        }    
    }
    
    unset($_SESSION['boleto']);
}

?>