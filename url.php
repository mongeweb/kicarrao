<?php
require_once 'configRoot.php';
$url = explode('/', isset($_GET['conteudo']) ? $_GET['conteudo'] : '');
$uri = explode('/', isset($_SERVER['REQUEST_URI']) ? preg_replace('/^\//', '', $_SERVER['REQUEST_URI'], 1) : '');

$codigoSecao = isset($uri[0]) && !empty($uri[0]) ? $uri[0] : ''; //menu
$codigoConteudo = isset($uri[1]) && !empty($uri[1]) ? $uri[1] : ''; //codigo

switch ($codigoSecao) {
    case 'home':
    case 'home-dev':
    case 'fale-conosco':
    case 'noticia':
    case 'noticias':
    case 'guia-automotivo':
    case 'fipe':
    case 'detrans':
    case 'busca':
    case 'busca2':
    case 'boleto':
    case 'busca-avancada':
    case 'revendas':
    /*case 'revenda-lista':*/
    case 'planos':
    case 'planos-dev':
    case 'anuncio-loja':
    case 'anuncio-dados':
    case 'anuncio-dados-dev':
    case 'anuncio-renovacao-dados':
    case 'anuncio-fotos':
    case 'anuncio-fotos-dev':
    case 'anuncio-renovacao-fotos':
    case 'anuncio-finalizacao':
    case 'anuncio-finalizacao-dev':
    case 'anuncio-confirmacao':
    case 'anuncio-confirmacao-dev':
    case 'anuncio-renovacao-finalizacao':
    case 'anuncio-renovacao-confirmacao':
    case 'anuncio-finalizacao-revenda':
    case 'anuncio-dados-revenda':
    case 'anuncio-planos-revenda':
    case 'confirmacao-de-envio':
    case 'identificacao':
    case 'identificacao-dev':
	case 'identificacao-revenda':
    case 'login':
    case 'login-dev':
    case 'favoritos':
    case 'recuperarsenha':
    case 'meu-cadastro':
    case 'detalhe':
    case 'meus-anuncios':
    case 'meus-anuncios-dev':
    case 'deslogar':
    case 'politica-de-privacidade':
	case 'publicidade':
    case 'anuncios':
    case 'revenda':
    case 'imprimir':
		break;
    default :
        header('Location: ' .ssl().INDEX_URL);
        break;
}

switch ($codigoSecao) {

	case 'home':
        $MG_MR_Settings['pagUriIndex'] = 1;
		break;
    case 'home-dev':
        $MG_MR_Settings['pagUriIndex'] = 1;
		break;	
    case 'noticias':
        $MG_MR_Settings['pagUriIndex'] = 1;
        $pagina = isset($codigoConteudo) && !empty($codigoConteudo) ? $codigoConteudo : 1; //pagina
		break;
    case 'noticia':
        $cod = $codigoConteudo;
		break;
    case 'anuncio-dados':
        $cod = $codigoConteudo;
		break;
    case 'anuncio-dados-dev':
        $cod = $codigoConteudo;
		break;
    case 'anuncio-renovacao-dados':
        $cod = $codigoConteudo;
		break;
    case 'anuncio-fotos':
        $cod = $codigoConteudo;
		break;
    case 'anuncio-fotos-dev':
        $cod = $codigoConteudo;
		break;
    case 'anuncio-renovacao-fotos':
        $cod = $codigoConteudo;
		break;
    case 'anuncio-finalizacao':
        $cod = $codigoConteudo;
		break;
    case 'anuncio-finalizacao-dev':
        $cod = $codigoConteudo;
		break;
    case 'anuncio-renovacao-finalizacao':
        $cod = $codigoConteudo;
		break;
    case 'detalhe':
        $cod = $codigoConteudo;
		break;
    /*case 'revenda-lista':
        $MG_MR_Settings['pagUriIndex'] = 1;
        $cod = $codigoConteudo;
        foreach($uri as $pos => $val)
        {
            if($pos > 1)
            {
                $temp = explode(":",$val);
                if(count($temp) > 1)
                {
                    $tempTipo = $temp[0];
                    $tempVal = $temp[1];
                    switch($tempTipo)
                    {
                        case "order":  
                            $order = $tempVal;
    						break;
                        case "p":  
                            $pagina = $tempVal;
    						break;
                    }
                } 
            }
        }
		break;*/
    case 'favoritos':
        $MG_MR_Settings['pagUriIndex'] = 1;
        foreach($uri as $pos => $val)
        {
            if($pos > 0)
            {
                $temp = explode(":",$val);
                if(count($temp) > 1)
                {
                    $tempTipo = $temp[0];
                    $tempVal = $temp[1];
                    switch($tempTipo)
                    {
                        case "order":  
                            $order = $tempVal;
    						break;
                        case "p":  
                            $pagina = $tempVal;
    						break;
                    }
                } 
            }
        }
		break;
    case 'revendas':
        $MG_MR_Settings['pagUriIndex'] = 1;
        foreach($uri as $pos => $val)
        {
            if($pos > 0)
            {
                $temp = explode(":",$val);
                if(count($temp) > 1)
                {
                    $tempTipo = $temp[0];
                    $tempVal = $temp[1];
                    switch($tempTipo)
                    {
                        case "e":
                            $estado = $tempVal;
    						break;
                        case "c":  
                            $cidade = $tempVal;
    						break;
                        case "p":  
                            $pagina = $tempVal;
    						break;
                        case "b":  
                            $buscaRevenda = $tempVal;
    						break;
                    }
                } 
            }
        }
		break;
    case 'meus-anuncios':
        $MG_MR_Settings['pagUriIndex'] = 1;
        $pagina = isset($codigoConteudo) && !empty($codigoConteudo) ? $codigoConteudo : 1; //pagina
        $debug = 0;
        foreach($uri as $posicoes)
        {
            $partes = explode(":",$posicoes);
            $indice = $partes[0];
            if($indice == "debug")
            {
                $debug = 1;
            }     
        }
        
		break;
	case 'publicidade':
        $cod = $codigoConteudo;
		break;
    case 'imprimir':
        $cod = $codigoConteudo;
		break;
	case 'guia-automotivo':
		$MG_MR_Settings['pagUriIndex'] = 1;
        foreach($uri as $pos => $val)
        {
            if($pos > 0)
            {
                $temp = explode(":",$val);
                if(count($temp) > 1)
                {
                    $tempTipo = $temp[0];
                    $tempVal = $temp[1];
                    switch($tempTipo)
                    {
                        case "c":
                            $cat = $tempVal;
    						break;
                        case "p":  
                            $pagina = $tempVal;
    						break;
                        case "e":
                            $estadoGuia = $tempVal;
    						break;
                        case "ci":  
                            $cidadeGuia = $tempVal;
    						break;
                        case "ca":  
                            $categoria = $tempVal;
    						break;
                    }
                } 
            }
        }
		break;		
    default :
        break;
}

$include = '';
switch ($codigoSecao) {
    case 'home':
        $include = 'home.php';
		$titulo = "Venda de Carros Usados em Porto Alegre, Canoas, Dois Irmãos, Esteio, Novo Hamburgo, Curitiba - KiCarrão";
		$palavras = "Venda de carros em Porto Alegre, Canoas, Dois Irmãos, Esteio, Novo Hamburgo, Curitiba";
		$descricao = "No Kicarrão você encontra as melhores ofertas de carros usados em Porto Alegre, Canoas, Dois Irmãos, Esteio, Novo Hamburgo, Curitiba. As grandes ofertas de venda do kicarrão tornam a procura mais fácil!";
        break;
    case 'home-dev':
        $include = 'home-dev.php';
		$titulo = "Venda de Carros Usados em Porto Alegre, Canoas, Dois Irmãos, Esteio, Novo Hamburgo, Curitiba - KiCarrão";
		$palavras = "Venda de carros em Porto Alegre, Canoas, Dois Irmãos, Esteio, Novo Hamburgo, Curitiba";
		$descricao = "No Kicarrão você encontra as melhores ofertas de carros usados em Porto Alegre, Canoas, Dois Irmãos, Esteio, Novo Hamburgo, Curitiba. As grandes ofertas de venda do kicarrão tornam a procura mais fácil!";
        break;
    case 'noticias':
        $include = 'noticias.php';
		$titulo = "Notícias Automotivas - KiCarrão";
		$palavras = "noticias automotivas, noticia automotiva, notícias automobilisticas, notícia automobilistica";
		$descricao = "Notícias do Mundo Automotivo.";
        break;
    case 'noticia':
        $include = 'noticias-detalhe.php';
		$titulo = "Notícia Automotiva - KiCarrão";
		$palavras = "noticia automotiva, noticias automotivas, noticias automobilisticas, noticia automobilistica";
		$descricao = "Notícia do Mundo Automotivo.";
        break;
    case 'guia-automotivo':
        $include = 'guia-automotivo.php';
		$titulo = "Guia Automotivo em Porto Alegre, Canoas, Dois Irmãos, Esteio, Novo Hamburgo, Curitiba - KiCarrão";
		$palavras = "Guia Automotivo";
		$descricao = "Guia Automotivo em Porto Alegre, Canoas, Dois Irmãos, Esteio, Novo Hamburgo, Curitiba";
        break;
    case 'fipe':
        $include = 'fipe.php';
		$titulo = "Tabela Fipe - KiCarrão";
		$palavras = "Tabela Fipe de Porto Alegre, Canoas, Dois Irmãos, Esteio, Novo Hamburgo, Curitiba";
		$descricao = "Veja aqui a tabela fipe atualizada diariamente!";
        break;
    case 'detrans':
        $include = 'detrans.php';
		$titulo = "Encontre Aqui Todas as Localizações do Detran - KiCarrão";
		$palavras = "detran, detran brasil, detran RS, detran porto Alegre, detran rio grande do sul";
		$descricao = "Encontre um detran mais perto de você, na sua cidade.";
        break;
    case 'busca':
        $include = 'busca.php';
		$titulo = "Faça sua Busca por Carros, Motos, Náutica - KiCarrão";
		$palavras = "carros porto alegre,veiculos novos,venda de carro,venda de carros porto alegre, kicarrao";
		$descricao = "Aqui no Kicarrão você encontra as melhores ofertas de carros usados e novos em Porto Alegre, Canoas, Dois Irmãos, Esteio, Novo Hamburgo, Curitiba";
        break;
    case 'busca2':
        $include = 'busca2.php';
		$titulo = "Faça sua Busca por Carros, Motos, Náutica - KiCarrão";
		$palavras = "carros porto alegre,veiculos novos,venda de carro,venda de carros porto alegre, kicarrao";
		$descricao = "Aqui no Kicarrão você encontra as melhores ofertas de carros usados e novos em Porto Alegre, Canoas, Dois Irmãos, Esteio, Novo Hamburgo, Curitiba";
        break;
    case 'boleto':
        $include = 'boleto.php';
		$titulo = "Boleto";
		$palavras = "";
		$descricao = "";
        break;
    case 'busca-avancada':
        $include = 'busca-avancada.php';
		$titulo = "Busca Avançada de Veículos em Porto Alegre, Canoas, Dois Irmãos, Esteio, Novo Hamburgo, Curitiba | KiCarrão";
		$palavras = "Busca Avançada";
		$descricao = "Busca Avançada de Veículos em Porto Alegre, Canoas, Dois Irmãos, Esteio, Novo Hamburgo, Curitiba";
        break;
    case 'revendas':
        $include = 'revendas.php';
		$titulo = "teste";
		$palavras = "kicarrao, kicarrão, revenda, revendas de carros em porto alegre Canoas, Dois Irmãos, Esteio, Novo Hamburgo, Curitiba, concessionárias, concessionarias, revenda de carro, revenda de moto, revendedora de automóveis, loja de carros, loja de motos, RS";
		$descricao = "Aqui no Kicarrão você encontra muitas opções de carros e motos em Porto Alegre, Canoas, Dois Irmãos, Esteio, Novo Hamburgo, Curitiba";
        break;
    case 'planos':
	   $include = 'anuncio-planos.php';
	    $titulo = "Comprar e Vender, Carros e Motos, Novos e Usados è no Kicarrão! Anuncie Já";
		$palavras = "anuncio grátis de carro, anuncio grátis de moto, anuncio de carros, anuncio de motos, kicarrao, kicarrão, kicarro";
		$descricao = "Comprar e Vender, Carros e Motos, Novos e Usados è no Kicarrão! Anuncie Já";
        break;
    case 'planos-dev':
	   $include = 'anuncio-planos-dev.php';
	    $titulo = "Comprar e Vender, Carros e Motos, Novos e Usados è no Kicarrão! Anuncie Já";
		$palavras = "anuncio grátis de carro, anuncio grátis de moto, anuncio de carros, anuncio de motos, kicarrao, kicarrão, kicarro";
		$descricao = "Comprar e Vender, Carros e Motos, Novos e Usados è no Kicarrão! Anuncie Já";
        break;
    case 'fale-conosco':
        $include = 'fale-conosco.php';
		$titulo = "Fale Conosco e Bons Negócios - KiCarrão";
		$palavras = "kicarrao, kicarrão, kicarro, fale conosco";
		$descricao = "Fale Conosco! Bons Negócios - Kicarrão";
        break;
    /*case 'revenda-lista':
        $include = 'revenda-lista.php';
        break;*/
    case 'detalhe':
        $include = 'busca-detalhes.php';
		$titulo = "Venda de Veículos Particulares - KiCarrão";
		$palavras = "kicarrao, kicarrão, kicarro, venda de carros, venda de motos, compra de carros, venda de carro";
		$descricao = "Veja os datahes dos veículos à venda na revenda";		
        break;
    case 'anuncio-loja':
        $include = 'anuncio-loja.php';
		$titulo = "";
		$palavras = "";
		$descricao = "";
        break;
    case 'anuncio-dados':
        $include = 'anuncio-dados.php';
		$titulo = "";
		$palavras = "";
		$descricao = "";
        break;
    case 'anuncio-dados-dev':
        $include = 'anuncio-dados-dev.php';
		$titulo = "";
		$palavras = "";
		$descricao = "";
        break;
    case 'anuncio-renovacao-dados':
        $include = 'anuncio-renovacao-dados.php';
		$titulo = "";
		$palavras = "";
		$descricao = "";
        break;
    case 'anuncio-fotos':
        $include = 'anuncio-fotos.php';
		$titulo = "";
		$palavras = "";
		$descricao = "";
        break;
    case 'anuncio-fotos-dev':
        $include = 'anuncio-fotos-dev.php';
		$titulo = "";
		$palavras = "";
		$descricao = "";
        break;
    case 'anuncio-renovacao-fotos':
        $include = 'anuncio-renovacao-fotos.php';
		$titulo = "";
		$palavras = "";
		$descricao = "";
        break;
    case 'favoritos':
        $include = 'favoritos.php';
		$titulo = "";
		$palavras = "";
		$descricao = "";
        break;
    case 'anuncio-finalizacao':
        $include = 'anuncio-finalizacao.php';
		$titulo = "";
		$palavras = "";
		$descricao = "";
        break;
    case 'anuncio-finalizacao-dev':
        $include = 'anuncio-finalizacao-dev.php';
		$titulo = "";
		$palavras = "";
		$descricao = "";
        break;
    case 'anuncio-confirmacao':
        $include = 'anuncio-confirmacao.php';
		$titulo = "";
		$palavras = "";
		$descricao = "";
        break;
    case 'anuncio-confirmacao-dev':
        $include = 'anuncio-confirmacao-dev.php';
		$titulo = "";
		$palavras = "";
		$descricao = "";
        break;
    case 'anuncio-renovacao-finalizacao':
        $include = 'anuncio-renovacao-finalizacao.php';
		$titulo = "";
		$palavras = "";
		$descricao = "";
        break;
    case 'anuncio-renovacao-confirmacao':
        $include = 'anuncio-renovacao-confirmacao.php';
		$titulo = "";
		$palavras = "";
		$descricao = "";
        break;
    case 'anuncio-finalizacao-revenda':
        $include = 'anuncio-finalizacao-revenda.php';
		$titulo = "";
		$palavras = "";
		$descricao = "";
        break;
    case 'anuncio-dados-revenda':
        $include = 'anuncio-dados-revenda.php';
		$titulo = "";
		$palavras = "";
		$descricao = "";
        break;
    case 'anuncio-planos-revenda':
        $include = 'anuncio-planos-revenda.php';
		$titulo = "";
		$palavras = "";
		$descricao = "";
        break;
    case 'confirmacao-de-envio':
        $include = 'confirmacao-de-envio.php';
		$titulo = "";
		$palavras = "";
		$descricao = "";
        break;    
    case 'identificacao':
        $include = 'identificacao.php';
		$titulo = "";
		$palavras = "";
		$descricao = "";
        break;
	case 'identificacao-dev':
        $include = 'identificacao-dev.php';
		$titulo = "";
		$palavras = "";
		$descricao = "";
        break;
	case 'identificacao-revenda':
        $include = 'identificacao-revenda.php';
		$titulo = "";
		$palavras = "";
		$descricao = "";
        break;
    case 'login':
        $include = 'login.php';
		$titulo = "Login";
		$palavras = "";
		$descricao = "";
        break;
    case 'login-dev':
        $include = 'login-dev.php';
		$titulo = "Login";
		$palavras = "";
		$descricao = "";
        break;
    case 'recuperarsenha':
        $include = 'esqueciminhasenha.php';
		$titulo = "Esqueci Minha Senha";
		$palavras = "";
		$descricao = "";
        break;
    case 'meu-cadastro':
        $include = 'meu-cadastro.php';
		$titulo = "Meu Cadastro | KiCarrão";
		$palavras = "";
		$descricao = "";
        break;
    case 'meus-anuncios':
        $include = 'meus-anuncios.php';
		$titulo = "Meus Anuncios | KiCarrão";
		$palavras = "Anúncios, Anuncios";
		$descricao = "";
        break;	
    case 'meus-anuncios-dev':
        $include = 'meus-anuncios-dev.php';
		$titulo = "Meus Anuncios | KiCarrão";
		$palavras = "Anúncios, Anuncios";
		$descricao = "";
        break;	
    case 'deslogar':
        $include = 'deslogar.php';
		$titulo = "Sair";
		$palavras = "";
		$descricao = "";
        break;
    case 'politica-de-privacidade':
        $include = 'politica-de-privacidade.php';
		$titulo = "Politica de Privacidade";
		$palavras = "";
		$descricao = "";
        break;
	case 'publicidade':
        $include = 'publicidade.php';
		$titulo = "Publicidade";
		$palavras = "";
		$descricao = "";
        break;
    case 'revenda':
		$titulo = "Venda de Carros Usados em Porto Alegre, Canoas, Dois Irmãos, Esteio, Novo Hamburgo, Curitiba | KiCarrão";
		$palavras = "Revenda de Carro em Poto Alegre, Revendas de Carros em Esteio, Revendas de Carros em Canoas,Revendas de Carros em Curitiba";
		$descricao = "Revenda de Carros em Porto Alegre, Canoas, Dois Irmãos, Esteio, Novo Hamburgo, Curitiba";
        $nomeRevUrl = isset($uri[1]) ? $uri[1] : '';
        $estadoUrlRevendas = isset($uri[2]) ? $uri[2] : '';
        $cidadeUrlRevendas = isset($uri[3]) ? $uri[3] : '';
        $include = 'revenda-lista.php';
        $MG_MR_Settings['pagUriIndex'] = 1;
        foreach($uri as $pos => $val)
        {
            $temp = explode(":",$val);
            if(count($temp) > 1)
            {
                $tempTipo = $temp[0];
                $tempVal = $temp[1];
                switch($tempTipo)
                {
                    case "order":  
                        $order = $tempVal;
						break;
                    case "p":  
                        $pagina = $tempVal;
						break;
                }
            } 
        }
        break;
    case 'anuncios':
		$titulo = "Venda de Carros Usados em Porto Alegre, Canoas, Dois Irmãos, Esteio, Novo Hamburgo, Curitiba | KiCarrão";
		$palavras = "Revenda de Carro em Poto Alegre, Revendas de Carros em Esteio, Revendas de Carros em Canoas,Revendas de Carros em Curitiba";
		$descricao = "Revenda de Carros em Porto Alegre, Canoas, Dois Irmãos, Esteio, Novo Hamburgo, Curitiba";
        $revPar = isset($uri[1]) ? $uri[1] : '';
        if($revPar == 'revenda')
        {
            $cod = isset($uri[4]) ? explode('-',$uri[4]) : array();
            $nomeRevUrl = isset($uri[2]) ? $uri[2] : '';
        }
        else
        {
            $cod = isset($uri[3]) ? explode('-',$uri[3]) : array();
            $nomeRevUrl = '';
        }
        
        $cod = isset($cod[(count($cod)-1)]) ? (int)$cod[(count($cod)-1)] : '';
        $include = 'busca-detalhe.php';
        
        break;
    case 'imprimir':
        $include = 'busca-detalhe-imprimir.php';
		$titulo = "Imprimir Anúncio | KiCarrão";
		$palavras = "Anúncios, Anuncios";
		$descricao = "";
        break;					
}

if (!is_file($include)) {
    header('Location: ' .ssl(). INDEX_URL);
    //header('Location: http://' . PROJECT_URL . '/index.html');
}
require_once $include;
exit;
?>