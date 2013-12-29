<?php
require_once "configRoot.php"; 
require_once PROJECT_FUNC_PATH."phpQuery.php";

function simple_curl($url,$post=array(),$get=array())
{
        $url = explode('?',$url,2);
        if(count($url)===2)
        {
                $temp_get = array();
                parse_str($url[1],$temp_get);
                $get = array_merge($get,$temp_get);
        }

        $ch = curl_init($url[0]."?".http_build_query($get));
        curl_setopt ($ch, CURLOPT_POST, 1);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        //curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        return curl_exec ($ch);
}

$cep = isset($_GET['cep']) ? $_GET['cep'] : '';
$cep = str_ireplace('-','',$cep);
$html = @simple_curl('http://www.buscacep.correios.com.br/servicos/dnec/consultaLogradouroAction.do',array(
        'relaxation'=>$cep,
        'TipoConsulta'=>'relaxation',
        'Metodo'=>'listaLogradouro',
        'StartRow'=>'1',
        'EndRow'=>'10'
));

//echo $html;
phpQuery::newDocumentHTML($html, $charset = 'utf-8');
$logradouro = trim(pq('div.ctrlcontent > div > table > tr:eq(0) > td:eq(0)')->html());
$bairro = trim(pq('div.ctrlcontent > div > table > tr:eq(0) > td:eq(1)')->html());
$cidade = trim(pq('div.ctrlcontent > div > table > tr:eq(0) > td:eq(2)')->html());
$uf = trim(pq('div.ctrlcontent > div > table > tr:eq(0) > td:eq(3)')->html());
$cep = trim(pq('div.ctrlcontent > div > table > tr:eq(0) > td:eq(4)')->html());
$dados = array();
if($cidade != '' && $uf != '' && $cep != '')
{
    $dados['erro'] = 0;
    $dados['logradouro'] = $logradouro;
    $dados['bairro'] = $bairro != '' ? $bairro : 'Centro';
    $dados['cidade'] = $cidade;
    $dados['estado'] = $uf;
    $contaCep = explode('-',$cep);
    if(count($contaCep) > 1)            
        $dados['cep'] = $cep;
    else
    {
        $cepPronto = '';
        for($a=0;$a<8;$a++)
        {
            if($a == 5)
            {
                $cepPronto .= "-";
            }
            $cepPronto .= $cep[$a];
        }
        $dados['cep'] = $cepPronto;
    }           
}
else
{
    $dados['erro'] = 'CEP não encontrado!';
}
//echo count($dados);



die(json_encode($dados));