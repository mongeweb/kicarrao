<?php
function combustivel($cod)
{
    switch($cod)
    {
        case 1:
            $combustivel = 'Gasolina';
            break;
        case 2:
            $combustivel = 'Álcool';
            break;
        case 3:
            $combustivel = 'Flex';
            break;
        case 4:
            $combustivel = 'Gás - GNV';
            break;
        case 5:
            $combustivel = 'Diesel';
            break;
        case 6:
            $combustivel = 'Biodiesel';
            break;
        case 7:
            $combustivel = 'Eletricidade';
            break;
        default:
            $combustivel = '';
            break;
    }
    return $combustivel;
}

function ssl()
{
    $prot = '';
    if($_SERVER['SERVER_PORT'] == 80)
    {
        $prot = "http://";
    }
    elseif($_SERVER['SERVER_PORT'] == 443)
    {
        $prot = "https://";
    }
    return $prot;
}

function sslRedir()
{
    global $restrita;
    
    $protRedir = '';
    if($restrita == 1)
    {
        $protRedir = "https://";
    }
    else
    {
        if($_SERVER['SERVER_PORT'] == 80)
        {
            $protRedir = "http://";
        }
        elseif($_SERVER['SERVER_PORT'] == 443)
        {
            $protRedir = "https://";
        }
    }
    return $protRedir;
}

function desconto($valOriginal,$descProd)
{
    $descProd = (int)$descProd;
    $descCli = isset($_SESSION['descCli']) ? (int)$_SESSION['descCli'] : 0;
    
    if($descCli > 0)
    {
        $x = ($valOriginal*$descCli)/100;
    }
    else
    {
        $x = ($valOriginal*$descProd)/100;    
    }
    $retorno = ($valOriginal-$x);
    
    return number_format($retorno,2,".","");
}

function descontoPedidos($valOriginal,$desc)
{
    $desc = (int)$desc;
    $x = ($valOriginal*$desc)/100;
    $retorno = ($valOriginal-$x);
    return number_format($retorno,2,".","");
}


function atualizaSubtotalCarrinho()
{
    $qtdProdutos = 0;
    $subTotal = (float)0;
    $disp = 0;
    foreach($_SESSION['produtos'] as $a => $aCodProduto)
    {
        foreach($_SESSION['produtos'][$a] as $b => $bCodSubProduto)
        {        
            if((int)$_SESSION['produtos'][$a][$b]['disponibilidade'] > 0)
            {
                $disp = 1;
            }
            $subTotal += ($_SESSION['produtos'][$a][$b]['valorUnitario']) * $_SESSION['produtos'][$a][$b]['qtd'];
            $qtdProdutos += $_SESSION['produtos'][$a][$b]['qtd'];
        }    
    }
    $_SESSION['disponibilidade'] = $disp;
    $_SESSION['subTotal'] = $subTotal;
    $_SESSION['itensCarrinho'] = $qtdProdutos;
}

function status($codStatus, $servicoPagamento)
{
    if($servicoPagamento == "cielo")
    {
        switch($codStatus)
        {
            case 5:
            case 9:
            case 12:
                $retorno = "<span style='color: #000000 !important;'>Cancelado</span>";
                break;
            case 6:
                $retorno = "<span style='color: #000000 !important;'>Completo</span>";
                break;
            case 4:
                $retorno = "<span style='color: #000000 !important;'>Aprovado</span>";
                break;
            default:
            case 0:
            case 1:
            case 2:
            case 10:
                $retorno = "<span style='color: #000000 !important;'>Aguardando Pagamento</span>";
                break;
        }
    }
    elseif($servicoPagamento == "pagseguro")
    {
        switch($codStatus)
        {
            case "Cancelado":
                $retorno = "<span style='color: #000000 !important;'>Cancelado</span>";
                break;
            case "Completo":
                $retorno = "<span style='color: #000000 !important;'>Completo</span>";
                break;
            case "Aprovado":
                $retorno = "<span style='color: #000000 !important;'>Aprovado</span>";
                break;
            default:
            case "Aguardando Pagto":
                $retorno = "<span style='color: #000000 !important;'>Aguardando Pagamento</span>";
                break;
        }
    }    
    return $retorno;
}
function dataBr($dataEn)
{
    $dataBr_inicial = explode('-', $dataEn);
    $dataBr = $dataBr_inicial[2].'/'.$dataBr_inicial[1].'/'.$dataBr_inicial[0];
    return $dataBr;
}
function dataEn($dataBr)
{
    
    $dataEn_inicial = explode('/', $dataBr);
    $dataEn = $dataEn_inicial[2].'-'.$dataEn_inicial[1].'-'.$dataEn_inicial[0];
    return $dataEn; 
}
/*
function status($status)
{
    switch($status)
    {
        case "Cancelado":
            
            break;
        case "Completo":
            
            break;
        case "Aprovado":
            
            break;
        default:
        case "Aguardando Pagto":
            
            break;
    }
    return $retorno;
}
*/
function registraStats($cod,$conteudo)
{
    $conexao = conexao();
    $hoje = date('Y-m-d');
    $ip = $_SERVER['REMOTE_ADDR'];
    $verifica = mysql_query("SELECT * FROM $conteudo WHERE ip = '$ip' AND dataClick = '$hoje' AND codReferencia = '$cod'");
    $numVerifica = mysql_num_rows($verifica);
    if($numVerifica == 0)
    {
        $insere = mysql_query("INSERT INTO $conteudo (codReferencia, dataClick, ip) VALUES ('{$cod}', '{$hoje}', '{$ip}')");
    }
    mysql_close();
}
?>