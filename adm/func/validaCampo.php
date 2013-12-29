<?php



// Função para transformar strings em Maiúscula ou Minúscula com acentos
// $palavra = a string propriamente dita 


function reordenarSubProdutos($filtro,$valor)
{
    $sqlOrdem = mysql_query("SELECT * FROM subProdutos WHERE $filtro = '$valor' ORDER BY ordem ASC");
	$qtdObjs = mysql_num_rows($sqlOrdem);
    if ($qtdObjs > 0)
    {
        for ($n = 0; $n < $qtdObjs; $n++) 
        {
            $tpOrdem = mysql_fetch_assoc($sqlOrdem);
            $ordem = $n + 1;
            $uptOrdem = "UPDATE subProdutos SET 
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

function reordenarGeneros()
{
    $sqlOrdem = mysql_query("SELECT * FROM generos ORDER BY ordem ASC");
	$qtdObjs = mysql_num_rows($sqlOrdem);
    if ($qtdObjs > 0)
    {
        for ($n = 0; $n < $qtdObjs; $n++) 
        {
            $tpOrdem = mysql_fetch_assoc($sqlOrdem);
            $ordem = $n + 1;
            $uptOrdem = "UPDATE generos SET 
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
function reordenarFotos($filtro,$codTro)
{
    $sqlOrdem = mysql_query("SELECT * FROM arquivos WHERE $filtro = '$codTro' AND tipo = '2' AND referencia = 'trofeus' ORDER BY capa DESC,ordem ASC");
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



function validaCampo($str, $tipo = 'tudo', $vazio = false)
{
    
    $retorno = false;
    $padrao             = '';
     
    $dataBrPattern      = '(?P\d{1,2})[\/\-](?P\d{1,2})[\/\-](?P\d{4})';
    $dataEnPattern      = '(?P\d{4})[\/\-](?P\d{1,2})[\/\-](?P\d{1,2})';
    $timePattern        = '(?P[0-1]\d|[2][0-3]):(?P[0-5]\d)(:(?P[0-5]\d))?';
    $datePattern        = sprintf('((%s)|(%s))', $dataEnPattern, $dataBrPattern);
    $dataBrTimePattern  = sprintf('(%s( (%s))?)', $dataBrPattern, $timePattern);
    $dataEnTimePattern  = sprintf('(%s( (%s))?)', $dataEnPattern, $timePattern);
    $dateTimePattern    = sprintf('(%s( (%s))?)', $datePattern, $timePattern);
    $urlPattern = '((?P(ht|f)tp(s?))\:\/\/|~\/|\/){1}([0-9a-zA-Z]+:[0-9a-zA-Z]+@)?((?P[a-zA-Z]{1}([0-9a-zA-Z-]+\.?)*(\.[0-9a-zA-Z]{2,5}){1})(?P:[0-9]{1,5})?)+(?P(\/?[0-9a-zA-Z_-]+\/)+|\/?)(?P[0-9a-zA-Z]+([0-9a-zA-Z_-]?[0-9a-zA-Z]+)?(?P\.[0-9a-zA-Z]{3,4})?)?([,][0-9a-zA-Z]+)*(?P(\?[0-9a-zA-Z]+=[0-9a-zA-Z]+)?(&[0-9a-zA-Z]+=[0-9a-zA-Z]+)*([,][0-9a-zA-Z]*)*)?';
    
    switch ($tipo) {
            case 'alfa':
            case 'alpha':
                $padrao = '/^[[:alpha:]]*$/';
                break;
         
            case 'alphanumeric':
            case 'alfanumerico':
                $padrao = '/^[[:alnum:]]*$/';
                break;
         
            case 'cep':
                /** CEP no formato 12345-678 **/
                $padrao = '/^\d{5}\-\d{3}$/';
                break;
         
            case 'cnpj':
                /** CNPJ no Formato 012.345.678/9101-11 ou 012345678910111 **/
                $padrao = '/^(\d{2,3}).?(\d{3}).?(\d{3})\/?(\d{4})-?(\d{2})/';
                break;
         
            case 'cpf':
                /** CPF no Formato 123.456.789-10 **/
                $padrao = '/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/';
                break;
         
            case 'data':
                /** data no formato DD/MM/AAAA ou AAAA-MM-DD **/
                $padrao = sprintf('/^%s$/U', $datePattern);
                break;
         
            case 'dataHora':
                /** data e hora no formato DD/MM/AAAA HH:MM:SS ou AAAA-MM-DD HH:MM:SS **/
                $padrao = sprintf('/^%s$/U', $dateTimePattern);
                break;
         
            case 'dataBr':
                /** data no formato DD/MM/AAAA **/
                $padrao = sprintf('/^%s$/U', $dataBrPattern);
                break;
         
            case 'dataBrHora':
                /** data e hora no formato DD/MM/AAAA HH:MM:SS **/
                $padrao = sprintf('/^%s$/U', $dataBrTimePattern);
                break;
         
            case 'dataEn':
                /** data no formato AAAA-MM-DD **/
                $padrao = sprintf('/^%s$/U', $dataEnPattern);
                break;
         
            case 'dataEnHora':
                /** data e hora no formato AAAA-MM-DD HH:MM:SS **/
                $padrao = sprintf('/^%s$/U', $dataEnTimePattern);
                break;
         
            case 'email':
                /** Maiúsculas, minúsculas, numeros, underline, ponto e traço
                 * @ ponto mais 2 a 4 maiúsculas e minúsculas **/
                $padrao = '/^[[:alnum:]_\.\-]+@(?P<domain>[[:alnum:]_\.\-]*[[:alnum:]_\-]+\.[[:alpha:]]{2,4})$/';
                break;
         
            case 'float':
                $padrao = '/^\d+(.\d{1,2})?$/';
                break;
         
            case 'fone1':
                /** Telefone no formato 055663333-4444 ou 3333-4444 **/
                $padrao = '/^(?P<ddd>0(((\d{2}){2})|(\d{2})))?(?P<fone>\d{3,5}\-\d{4})$/';
                break;
         
            case 'fone2':
                /** Telefone no formato DDD e país 55 13 9999-9999 **/
                $padrao = '/^(?P<pais>\d{2}) (?P<ddd>\d{2}) (?P<fone>\d{4}\-\d{4})$/';
                break;
         
            case 'fone3':
                /** Telefone no formato 0800 sem espaços (080000(0)0000) **/
                $padrao = '/^0800\d{6,7}$/';
                break;
         
            case 'fone4':
                /** Telefone no formato 0800-00(0)-0000 **/
                $padrao = '/^0800\-\d{2,3}\-\d{4}$/';
                break;
         
            case 'fone5':
                /** Telefone no formato DDD (55) 9999-9999 **/
                $padrao = '/^\(\d{2}\) \d{4}\-\d{4}$/';
                break;
         
            case 'hora':
                /** hora no formato 99:99:99 **/
                $padrao = sprintf('/^%s$/U', $timePattern);
                break;
         
            case 'inteiro':
                /** Somente números inteiros **/
                $padrao = '/^\d+$/';
                break;
         
            case 'ip':
                /** Endereço IP ex: 192.168.100.1 **/
                $padrao = '/^([1-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])' . '(\.([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])){3}$/';
                break;
         
            case 'metaRefresh':
                /** <meta http-equiv="refresh" content="120; url=http://www.seudominio.com.br" /> **/
                $padrao = '/^(?P<seconds>\d+)(; url=(?P<refresh>' . $urlRegExp . '))?$/';
                break;
         
            case 'nome':
                // se a página é utf-8 uso
                $str = $str;
                /** Maiúsculas e minúsculas com ecento e espaço **/
                $padrao = '/^(?P<nome>[a-zA-ZÀ-ú]+)(?P<sobrenome>[a-zA-Z À-ú]+)$/i';
                break;
         
            case 'rg':
                $padrao = '/^\d{10}$/';
                break;
         
            case 'senha':
                /** Maiúsculas, minúsculas, underline, virgula, mais, igual e traço. **/
                $padrao = '/^[+=,-_[:alnum:]]{4,}$/';
                break;
         
            case 'sexo':
                /** Masculino ou feminino **/
                $padrao = '/^(?P<sexo>m|f)$/i';
                break;
         
            case 'tudo':
                $padrao = '/.*$/';
                break;
         
            case 'uf':
                /** Sigla dos estados brasileiros **/
                $padrao = '/^(?P<uf>(A[CLPM])|(BA)|(CE)|(DF)|(ES)|(GO)|(M[AGST])|(P[ABEIR])|(R[JNORS])|(S[CEP])|(TO))$/i';
                break;
         
            case 'url':
                /** URL com subpasta e arquivo **/
                $padrao = '/^' . $urlRegExp . '$/';
                break;
         
            case 'usuario':
                /** Maiúsculas, minúsculas, underline, ponto e numeros **/
                $padrao = '/^[[:alnum:]_\.]{5,}$/';
                break;
         
            default:
                return $retorno = -1;
 
    }
    
    if (!empty($str) || is_numeric($str)) {
    $retorno = preg_match($padrao, $str, $partes);
    //se validou
   
   
   
   
   
   
   if ($retorno) {
          //verifico se é data
         switch ($tipo) {
              case 'data':
              case 'dataHora':
              case 'dataBr':
              case 'dataBrHora':
              case 'dataEn':
              case 'dataEnHora':
                  $dia = $mes = $ano = $hora = $minuto = $segundo = 0;
   
                  $dia = isset($partes['dia']) && !empty($partes['dia']) ? $partes['dia'] : $dia;
                  $dia = isset($partes['day']) && !empty($partes['day']) ? $partes['day'] : $dia;
   
                  $mes = isset($partes['mes']) && !empty($partes['mes']) ? $partes['mes'] : $mes;
                  $mes = isset($partes['month']) && !empty($partes['month']) ? $partes['month'] : $mes;
   
                  $ano = isset($partes['ano']) && !empty($partes['ano']) ? $partes['ano'] : $ano;
                  $ano = isset($partes['year']) && !empty($partes['year']) ? $partes['year'] : $ano;
   
                  $hora = isset($partes['hora']) && !empty($partes['hora']) ? $partes['hora'] : $hora;
                  $minuto = isset($partes['minuto']) && !empty($partes['minuto']) ? $partes['minuto'] : $minuto;
                  $segundo = isset($partes['segundo']) && !empty($partes['segundo']) ? $partes['segundo'] : $segundo;
   
                  //verifica se é uma data válida
                  $retorno = checkdate($mes, $dia, $ano);
                  unset($dia, $mes, $ano, $hora, $minuto, $segundo);
                  break;
          }
     }
 
    
    
    
    } else {
        if ($vazio) {
            /** sendo permitido $vazio e $str vazia **/
            $retorno = 1;
        } else {
            /** sendo vedado $vazio e $str vazia **/
            $retorno = 0;
        }
    }
    return $retorno;
    
    
}
?>