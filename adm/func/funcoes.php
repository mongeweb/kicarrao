<?
function reordenarClientes()
{
    $sqlOrdem = mysql_query("SELECT * FROM clientes WHERE tipoAnuncio = '2' ORDER BY ordem ASC");
	$qtdObjs = mysql_num_rows($sqlOrdem);
    if ($qtdObjs > 0)
    {
        for ($n = 0; $n < $qtdObjs; $n++)
        {
            $tpOrdem = mysql_fetch_assoc($sqlOrdem);
            $ordem = $n + 1;
            $uptOrdem = "UPDATE clientes SET
                         ordem = '{$ordem}' WHERE cod = '{$tpOrdem['cod']}'";
            for($c=0;$c<5;$c++)
            {
                $upOrd = mysql_query($uptOrdem);
                if($upOrd)
                {
                    break;
                }
            }
        }
    }
    return $qtdObjs + 1;
}

function reordenarAutoCat()
{
    $sqlOrdem = mysql_query("SELECT * FROM guiaAutomotivoCategorias ORDER BY ordem ASC");
	$qtdObjs = mysql_num_rows($sqlOrdem);
    if ($qtdObjs > 0)
    {
        for ($n = 0; $n < $qtdObjs; $n++)
        {
            $tpOrdem = mysql_fetch_assoc($sqlOrdem);
            $ordem = $n + 1;
            $uptOrdem = "UPDATE guiaAutomotivoCategorias SET
                         ordem = '{$ordem}' WHERE cod = '{$tpOrdem['cod']}'";
            for($c=0;$c<5;$c++)
            {
                $upOrd = mysql_query($uptOrdem);
                if($upOrd)
                {
                    break;
                }
            }
        }
    }
    return $qtdObjs + 1;
}

function reordenarAuto()
{
    $sqlOrdem = mysql_query("SELECT * FROM guiaAutomotivo ORDER BY ordem ASC");
	$qtdObjs = mysql_num_rows($sqlOrdem);
    if ($qtdObjs > 0)
    {
        for ($n = 0; $n < $qtdObjs; $n++)
        {
            $tpOrdem = mysql_fetch_assoc($sqlOrdem);
            $ordem = $n + 1;
            $uptOrdem = "UPDATE guiaAutomotivo SET
                         ordem = '{$ordem}' WHERE cod = '{$tpOrdem['cod']}'";
            for($c=0;$c<5;$c++)
            {
                $upOrd = mysql_query($uptOrdem);
                if($upOrd)
                {
                    break;
                }
            }
        }
    }
    return $qtdObjs + 1;
}

/*
function reordenarFotos($filtro,$codTro)
{
    $sqlOrdem = mysql_query("SELECT * FROM arquivos WHERE $filtro = '$codAlbun' AND tipo = '2' AND referencia = 'trofeus' ORDER BY capa DESC,ordem ASC");
	$qtdObjs = mysql_num_rows($sqlOrdem);
    if ($qtdObjs > 0)
    {
        for ($n = 0; $n < $qtdObjs; $n++) 
        {
            $tpOrdem = mysql_fetch_assoc($sqlOrdem);
            $ordem = $n + 1;
            $uptOrdem = "UPDATE arquivos SET
                         ordem = '{$ordem}' WHERE codigo = '{$tpOrdem['codigo']}'";
            for($c=0;$c<5;$c++)
            {
                $upOrd = mysql_query($uptOrdem);
                if($upOrd)
                {
                    break;
                }
            }
        }
    }
    return $qtdObjs + 1;
}
*/

function set($string)
{
    if(isset($string))
        return $string;
    else
        return "";
}

function remEscape($string)
{
    return stripcslashes($string);
}

function escape($string)
{
    global $conexao;
    if(!get_magic_quotes_gpc())
    {
        if (function_exists('mysql_real_escape_string'))
        {
            return mysql_real_escape_string($string, $conexao);
        }
        elseif(function_exists('mysql_escape_string'))
        {
            return mysql_escape_string($string);
        }
        return addslashes($string);
    }
    else
    {
        return $string;
    }
}



// Função para transformar strings em Maiúscula ou Minúscula com acentos
// $palavra = a string propriamente dita 
// $tp = tipo da conversão: 1 para maiúsculas e 0 para minúsculas 
function converte($str, $tp) { 
    if ($tp == "1") $palavra = strtr(strtoupper($str),"àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ","ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß"); 
    elseif ($tp == "0") $palavra = strtr(strtolower($str),"ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß","àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ"); 
    return $palavra; 
}

function limitador($string, $limit, $break=" ", $pad="...")
{ // return with no change if string is shorter than $limit
if(strlen($string) <= $limit)
    {
        return $string; // is $break present between $limit and the end of the string?
    }
if(false !== ($breakpoint = strpos($string, $break, $limit)))
{
    if($breakpoint < strlen($string) - 1)
    {
        $string = substr($string, 0, $breakpoint) . $pad; 
    } 
}
 return $string;
}

?>