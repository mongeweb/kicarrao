<?php
require_once '../configRoot.php';
require_once ADMIN_FUNC_PATH.'redireciona.php';
require_once ADMIN_PATH.'sessao_verifica.php';
require_once ADMIN_FUNC_PATH.'validaCampo.php';
require_once ADMIN_FUNC_PATH.'verifica.php';
require_once ADMIN_FUNC_PATH.'funcoes.php';

$id = (isset($_GET['id'])) ? $_GET['id'] : '' ;
$subid = (isset($_GET['subid'])) ? $_GET['subid'] : '' ;
$cod = (isset($_GET['cod'])) ? $_GET['cod'] : '' ;

/// inicializa variaveis de sessao para os menus
$cod_user = (isset($_SESSION[ADMIN_SESSION_NAME.'_cod_user'])) ? $_SESSION[ADMIN_SESSION_NAME.'_cod_user'] : '' ;
$nivel_user = (isset($_SESSION[ADMIN_SESSION_NAME.'_nivel'])) ? $_SESSION[ADMIN_SESSION_NAME.'_nivel'] : '' ;
$menu = (isset($_SESSION[ADMIN_SESSION_NAME.'_menu'])) ? $_SESSION[ADMIN_SESSION_NAME.'_menu'] : '' ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?=ADMIN_TITLE;?></title>

    <meta http-equiv="Content-Type" content="text/html; charset= utf-8"/>
    <link href="http://<?=ADMIN_CSS_URL;?>/estilo.css" rel="stylesheet" type="text/css"/>
    
    <script src="http://<?=ADMIN_JS_URL;?>/jquery.min.js" type="text/javascript"></script>
    <script src="http://<?=ADMIN_JS_URL;?>/jquery.maskMoney.js" type="text/javascript"></script>
    <script src="http://<?=ADMIN_JS_URL;?>/jquery.maskedinput.js" type="text/javascript"></script>
    <script src="http://<?=ADMIN_JS_URL;?>/validador1.4.js" type="text/javascript"></script>    
    <script src="http://<?=ADMIN_JS_URL;?>/permissoes.js" type="text/javascript"></script>
    <script src="http://<?=ADMIN_JS_URL;?>/validacao.js" type="text/javascript"></script>
    <script src="http://<?=ADMIN_JS_URL;?>/ajaxFunctions1.1.js" type="text/javascript"></script>
    <script src="http://<?=ADMIN_JS_URL;?>/OpenWindow.js" type="text/javascript"></script>
    <script src="http://<?=ADMIN_JS_URL;?>/checkboxFunctions.js" type="text/javascript"></script>
    <script src="http://<?=ADMIN_JS_URL;?>/ordena.js" type="text/javascript"></script>
      
    <script type="text/javascript" src="http://<?=ADMIN_JS_URL;?>/jquery.ContArq.js"></script>
    
    <script type="text/javascript">
    try{
        xmlhttp = new XMLHttpRequest();
    }catch(ee){
        try{
            xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
        }catch(e){
            try{
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }catch(E){
                xmlhttp = false;
            }
        }
    }
</script>
<script language="JavaScript" type="text/JavaScript">
    $(document).ready(function()
    {		
    });
</script>
</head>
<body>
    <div>
        <table width="960" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td>
                    <img width="960" src="http://<?=ADMIN_IMG_URL;?>/cartola.jpg" border="0" />
                </td>
            </tr>
        </table>
        <div id="menu" class="menu">
        	<?php 
                require_once ADMIN_INC_PATH.'menu.php';
                menu(); 
            ?>
        </div>
        <div style="width: 960px;">
        
            <?php
                switch($id) {
                    case 1: 
                            if($subid == 1){
                                include ADMIN_PATH."usuarios/usuarios_lista.php";
                                break;
                            }
                            if($subid == 2){
                                include ADMIN_PATH."usuarios/usuarios_novo.php";
                                break;
                            }
                            if($subid ==3){
                                include ADMIN_PATH."usuarios/usuarios_edita.php";
                                break;
                            }
                            if($subid ==4){
                                include ADMIN_PATH."usuarios/usuarios_visualiza.php";
                                break;
                            }
                            if($subid ==5){
                                include ADMIN_PATH."usuarios/usuarios_permissoes.php";
                                break;
                            }
                    case 2: 
                            if($subid == 1){
                                include ADMIN_PATH."noticias/noticias_lista.php";
                                break;
                            }
                            if($subid == 2){
                                include ADMIN_PATH."noticias/noticias_novo.php";
                                break;
                            }
                            if($subid ==3){
                                include ADMIN_PATH."noticias/noticias_edita.php";
                                break;
                            }
                            if($subid ==4){
                                include ADMIN_PATH."noticias/noticias_visualiza.php";
                                break;
                            }
                    case 3: 
                            if($subid == 1){
                                include ADMIN_PATH."guiaAutoMotivo/guiaAutoMotivo_lista.php";
                                break;
                            }
                            if($subid == 2){
                                include ADMIN_PATH."guiaAutoMotivo/guiaAutoMotivo_novo.php";
                                break;
                            }
                            if($subid ==3){
                                include ADMIN_PATH."guiaAutoMotivo/guiaAutoMotivo_edita.php";
                                break;
                            }
                            if($subid ==4){
                                include ADMIN_PATH."guiaAutoMotivo/guiaAutoMotivo_visualiza.php";
                                break;
                            }
                            if($subid ==5){
                                include ADMIN_PATH."guiaAutoMotivo/guiaAutoMotivo_ordena.php";
                                break;
                            }
                    case 4: 
                            if($subid == 1){
                                include ADMIN_PATH."guiaAutoMotivoCat/guiaAutoMotivoCat_lista.php";
                                break;
                            }
                            if($subid == 2){
                                include ADMIN_PATH."guiaAutoMotivoCat/guiaAutoMotivoCat_novo.php";
                                break;
                            }
                            if($subid ==3){
                                include ADMIN_PATH."guiaAutoMotivoCat/guiaAutoMotivoCat_edita.php";
                                break;
                            }
                            if($subid ==4){
                                include ADMIN_PATH."guiaAutoMotivoCat/guiaAutoMotivoCat_visualiza.php";
                                break;
                            }
                            if($subid ==5){
                                include ADMIN_PATH."guiaAutoMotivoCat/guiaAutoMotivoCat_ordena.php";
                                break;
                            } 
                    case 5: 
                            if($subid == 1){
                                include ADMIN_PATH."planos/planos_lista.php";
                                break;
                            }
                            if($subid == 2){
                                include ADMIN_PATH."planos/planos_novo.php";
                                break;
                            }
                            if($subid == 3){
                                include ADMIN_PATH."planos/planos_edita.php";
                                break;
                            }
                            if($subid == 4){
                                include ADMIN_PATH."planos/planos_visualiza.php";
                                break;
                            }
                            if($subid == 5){
                                include ADMIN_PATH."planos/planos_ordena.php";
                                break;
                            }
                    case 6: 
                            if($subid == 1){
                                include ADMIN_PATH."clientes/clientes_lista.php";
                                break;
                            }
                            if($subid == 2){
                                include ADMIN_PATH."clientes/clientes_novo.php";
                                break;
                            }
                            if($subid == 3){
                                include ADMIN_PATH."clientes/clientes_edita.php";
                                break;
                            }
                            if($subid == 4){
                                include ADMIN_PATH."clientes/clientes_visualiza.php";
                                break;
                            }
                            if($subid == 5){
                                include ADMIN_PATH."clientes/clientes_ordena.php";
                                break;
                            }
                    case 7: 
                            if($subid == 1){
                                include ADMIN_PATH."marcas/marcas_lista.php";
                                break;
                            }
                            if($subid == 2){
                                include ADMIN_PATH."marcas/marcas_novo.php";
                                break;
                            }
                            if($subid == 3){
                                include ADMIN_PATH."marcas/marcas_edita.php";
                                break;
                            }
                            if($subid == 4){
                                include ADMIN_PATH."marcas/marcas_visualiza.php";
                                break;
                            }
                    case 8: 
                            if($subid == 1){
                                include ADMIN_PATH."modelos/modelos_lista.php";
                                break;
                            }
                            if($subid == 2){
                                include ADMIN_PATH."modelos/modelos_novo.php";
                                break;
                            }
                            if($subid == 3){
                                include ADMIN_PATH."modelos/modelos_edita.php";
                                break;
                            }
                            if($subid == 4){
                                include ADMIN_PATH."modelos/modelos_visualiza.php";
                                break;
                            }
                    case 9: 
                            if($subid == 1){
                                include ADMIN_PATH."versoes/versoes_lista.php";
                                break;
                            }
                            if($subid == 2){
                                include ADMIN_PATH."versoes/versoes_novo.php";
                                break;
                            }
                            if($subid == 3){
                                include ADMIN_PATH."versoes/versoes_edita.php";
                                break;
                            }
                            if($subid == 4){
                                include ADMIN_PATH."versoes/versoes_visualiza.php";
                                break;
                            }
                    case 10: 
                            if($subid == 1){
                                include ADMIN_PATH."clientesAnuncios/clientesAnuncios_lista.php";
                                break;
                            }
                            if($subid == 2){
                                include ADMIN_PATH."clientesAnuncios/clientesAnuncios_novo.php";
                                break;
                            }
                            if($subid == 3){
                                include ADMIN_PATH."clientesAnuncios/clientesAnuncios_edita.php";
                                break;
                            }
                            if($subid == 4){
                                include ADMIN_PATH."clientesAnuncios/clientesAnuncios_visualiza.php";
                                break;
                            }
                    case 11: 
                            if($subid == 1){
                                include ADMIN_PATH."publicidades/publicidades_lista.php";
                                break;
                            }
                            if($subid == 2){
                                include ADMIN_PATH."publicidades/publicidades_novo.php";
                                break;
                            }
                            if($subid == 3){
                                include ADMIN_PATH."publicidades/publicidades_edita.php";
                                break;
                            }
                            if($subid == 4){
                                include ADMIN_PATH."publicidades/publicidades_visualiza.php";
                                break;
                            }
                    case 12: 
                            if($subid == 1){
                                include ADMIN_PATH."planosRev/planosRev_lista.php";
                                break;
                            }
                            if($subid == 2){
                                include ADMIN_PATH."planosRev/planosRev_novo.php";
                                break;
                            }
                            if($subid == 3){
                                include ADMIN_PATH."planosRev/planosRev_edita.php";
                                break;
                            }
                            if($subid == 4){
                                include ADMIN_PATH."planosRev/planosRev_visualiza.php";
                                break;
                            }
                            if($subid == 5){
                                include ADMIN_PATH."planosRev/planosRev_ordena.php";
                                break;
                            } 
					case 13: 
                            if($subid == 1){
                                include ADMIN_PATH."noticias/noticiasLable_lista.php";
                                break;
                            }
                            if($subid == 2){
                                include ADMIN_PATH."noticias/noticiasLable_novo.php";
                                break;
                            }
                            if($subid == 3){
                                include ADMIN_PATH."noticias/noticiasLable_edita.php";
                                break;
                            }
                    case 15: 
                            if($subid == 1)
                            {
                                include ADMIN_PATH."pagamentos/pagamentos_lista.php";
                                break;
                            }
                            
                    case 90:
                            include ADMIN_PATH."usuarios/permissoes.php";
                            break;
                    case 100:
                            require_once 'ordena.php';
                            break;
                    default: 
							require_once 'home.php';                            
                            break; 
                }
        ?>
        </div>
    </div>
</body>
</html>