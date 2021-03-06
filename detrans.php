<?php require_once 'configRoot.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pt-br" xmlns:fb="http://ogp.me/ns/fb#" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php require_once PROJECT_INC_PATH.'head.php';
    require_once PROJECT_INC_PATH."publicidade.php";
    ?>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/js/maphighlight.js"></script>
    <script type="text/javascript">
    $(function()
    {
        $("div.maislocais").hide();
        $("div.menoslocais").hide();
    	$('img[usemap="#Map"]').maphilight({
    		fill : true,
    		fillColor : "A60F09",
    		fillOpacity : 1,
    		stroke : false
    	});
    	$("#Map").children('area')
    	.mouseover(function(){
    		$('#localizacaomapa').html($(this).attr('title'));
    	})
    	.bind('click',function(){		
    		$('.localblocowrap').children().remove();
    		$('.localblocowrap')	
    		.append('<br clear="all" /><img style="margin-left: 109px;" id="loading" src="<?=ssl().PROJECT_URL;?>/img/loading.gif" alt="loading" />');
    		
    		$.ajax(
    		{
    			type: "GET",
    			url: "http://<?=PROJECT_URL;?>/ajaxMapa.php", //URL de destino
    			data:{
    					estado: $(this).attr('alt')
    					//,tipoFrete: _tipoFrete 
    				 },
    			dataType: "html", //Tipo de Retorno
    			success: function(data)
    			{ //Se ocorrer tudo certo
    				
    				$("#twitter-wjs").remove();
                    if(data != "")
    				{
    					$('.localblocowrap').html(data);
                        car();			
    				}
                    else
    				{
    					$('.localblocowrap').html('<p>Nenhum representante encontrado.</p>')
    				}
                                   
    			}
    		});
    	});
        $("#Map area").mouseover(function(){
            _alt = $(this).attr("alt");
            $("div.mapatexto > div.mapatextoitem").each(function(){
                if(_alt == $(this).attr("id")){
                    _idEstado = $(this).attr("id");
                }
            })
            console.log(_alt+" "+_idEstado);
            if(_alt == _idEstado){
                $(this).parent().parent().find("div.mapatexto > div#"+_idEstado).show();
            }
            $(this).mouseout(function(){
                $(this).parent().parent().find("div.mapatexto > div#"+_idEstado).hide();
            })
        })
        if($.browser.msie){
            if($.browser.version == 8){
                $("div#am div.mapatextolinha").css({'margin-top':'15px'});
                $("div#pa div.mapatextolinha").css({'margin-top':'15px'});
                $("div#rr div.mapatextolinha").css({'margin-top':'15px'});
                $("div#ap div.mapatextolinha").css({'margin-top':'15px'});
                $("div#ma div.mapatextolinha").css({'margin-top':'15px'});
                $("div#mt div.mapatextolinha").css({'margin-top':'-10px'});
                $("div#ce div.mapatextolinha").css({'margin-top':'15px'});
                $("div#pi div.mapatextolinha").css({'margin-top':'15px','margin-left':'15px'});
            }
        }
    })
    </script>
</head>

<body>
<div class="mestre">
	<?php require_once PROJECT_INC_PATH.'topo.php';?>
    <?php require_once PROJECT_INC_PATH.'menu.php';?>
    <div class="ofertabloco">
        <div class="centroinside">
            <div class="breadcrumb">
            <?
            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
            ?>
                <a href="<?=$link;?>">Home</a>&nbsp; &gt; &nbsp;<span>Detrans</span>
            </div>
        </div>
    </div>
    <div class="centro">
    	<div class="centroinside">
            <div class="noticiablocogeral">
                <div class="fipebloco">
                    <div class="mapa">
                        <div class="mapatexto">
                            <div class="mapatextoitem" id="ac">
                                <span>AC</span>
                                <div class="mapatextolinha">&nbsp;</div>
                            </div>
                            <div class="mapatextoitem" id="al">
                                <span>AL</span>
                                <div class="mapatextolinha">&nbsp;</div>
                            </div>
                            <div class="mapatextoitem" id="ap">
                                <span>AP</span>
                                <div class="mapatextolinha">&nbsp;</div>
                            </div>
                            
                            <div class="mapatextoitem" id="am">
                                <span>AM</span>
                                <div class="mapatextolinha">&nbsp;</div>
                            </div>
                            <div class="mapatextoitem" id="ba">
                                <span>BA</span>
                                <div class="mapatextolinha">&nbsp;</div>
                            </div>
                            <div class="mapatextoitem" id="ce">
                                <span>CE</span>
                                <div class="mapatextolinha">&nbsp;</div>
                            </div>
                            
                            <div class="mapatextoitem" id="df">
                                <span>DF</span>
                                <div class="mapatextolinha">&nbsp;</div>
                            </div>
                            <div class="mapatextoitem" id="es">
                                <span>ES</span>
                                <div class="mapatextolinha">&nbsp;</div>
                            </div>
                            <div class="mapatextoitem" id="go">
                                <span>GO</span>
                                <div class="mapatextolinha">&nbsp;</div>
                            </div>
                            
                            <div class="mapatextoitem" id="ma">
                                <span>MA</span>
                                <div class="mapatextolinha">&nbsp;</div>
                            </div>
                            <div class="mapatextoitem" id="mt">
                                <span>MT</span>
                                <div class="mapatextolinha">&nbsp;</div>
                            </div>
                            <div class="mapatextoitem" id="ms">
                                <span>MS</span>
                                <div class="mapatextolinha">&nbsp;</div>
                            </div>
                            
                            <div class="mapatextoitem" id="mg">
                                <span>MG</span>
                                <div class="mapatextolinha">&nbsp;</div>
                            </div>
                            <div class="mapatextoitem" id="pa">
                                <span>PA</span>
                                <div class="mapatextolinha">&nbsp;</div>
                            </div>
                            <div class="mapatextoitem" id="pb">
                                <span>PB</span>
                                <div class="mapatextolinha">&nbsp;</div>
                            </div>
                            
                            <div class="mapatextoitem" id="pr">
                                <span>PR</span>
                                <div class="mapatextolinha">&nbsp;</div>
                            </div>
                            <div class="mapatextoitem" id="pe">
                                <span>PE</span>
                                <div class="mapatextolinha">&nbsp;</div>
                            </div>
                            <div class="mapatextoitem" id="pi">
                                <span>PI</span>
                                <div class="mapatextolinha">&nbsp;</div>
                            </div>
                            
                            <div class="mapatextoitem" id="rj">
                                <span>RJ</span>
                                <div class="mapatextolinha">&nbsp;</div>
                            </div>
                            <div class="mapatextoitem" id="rn">
                                <span>RN</span>
                                <div class="mapatextolinha">&nbsp;</div>
                            </div>
                            <div class="mapatextoitem" id="rs">
                                <span>RS</span>
                                <div class="mapatextolinha">&nbsp;</div>
                            </div>
                            
                            <div class="mapatextoitem" id="ro">
                                <span>RO</span>
                                <div class="mapatextolinha">&nbsp;</div>
                            </div>
                            <div class="mapatextoitem" id="rr">
                                <span>RR</span>
                                <div class="mapatextolinha">&nbsp;</div>
                            </div>
                            <div class="mapatextoitem" id="sc">
                                <span>SC</span>
                                <div class="mapatextolinha">&nbsp;</div>
                            </div>
                            
                            <div class="mapatextoitem" id="sp">
                                <span>SP</span>
                                <div class="mapatextolinha">&nbsp;</div>
                            </div>
                            <div class="mapatextoitem" id="se">
                                <span>SE</span>
                                <div class="mapatextolinha">&nbsp;</div>
                            </div>
                            <div class="mapatextoitem" id="to">
                                <span>TO</span>
                                <div class="mapatextolinha">&nbsp;</div>
                            </div>
                        </div>
                        <img src="<?=ssl().PROJECT_URL;?>/img/mapa.png" alt="Onde Estamos" usemap="#Map" />
                        <map name="Map" id="Map">
                        	<area alt="ac" title="Acre" shape="poly" coords="0,127,1,132,9,142,9,147,12,148,16,151,17,153,25,154,29,151,31,149,32,153,32,158,32,163,37,164,42,164,48,164,52,165,55,161,60,161,62,159,65,157,68,153,63,151,57,149,53,146,48,144,42,141,37,138,32,135,26,135,21,134,13,131,7,128" href="http://www.detran.ac.gov.br" target="_blank" />
                            <area alt="al" title="Alagoas" shape="poly" coords="364,147,366,144,370,145,371,147,377,147,381,146,384,142,388,143,390,143,389,146,388,149,385,151,382,154,379,156,375,154,370,151,367,150" href="http://www.detran.al.gov.br" target="_blank" />
                            <area alt="ap" title="Amapá" shape="poly" coords="226,11,230,14,230,17,230,21,232,24,232,27,233,30,234,33,237,34,240,36,242,38,243,40,240,43,236,47,232,50,228,53,226,57,224,60,222,63,219,63,218,60,216,56,213,53,211,50,210,46,209,43,206,40,203,37,198,35,195,32,194,31,198,31,202,31,205,30,209,31,212,31,215,29,217,25,218,22,220,18,223,14" href="http://www.detran.ap.gov.br" target="_blank" />
                            <area alt="am" title="Amazonas" shape="poly" coords="4,126,3,124,3,122,6,120,7,119,7,115,7,113,10,106,15,102,19,99,24,99,28,98,31,96,34,97,36,98,38,98,39,96,40,92,41,87,41,81,43,76,44,71,44,66,43,63,42,62,42,60,42,58,39,56,38,54,38,51,38,48,39,48,42,48,46,47,45,43,42,42,40,42,39,39,40,37,41,36,46,35,50,35,54,35,56,34,59,36,60,35,61,33,63,32,65,33,66,35,67,38,66,41,69,41,71,41,73,43,74,45,77,45,78,45,80,43,82,43,84,45,86,44,87,43,90,41,92,39,95,38,96,37,97,35,99,33,102,31,104,32,107,33,108,35,109,38,111,41,112,44,112,48,113,51,113,54,114,57,113,60,115,62,116,64,118,66,121,68,123,68,124,66,124,62,126,60,128,59,130,61,133,62,136,59,138,55,140,52,143,50,145,51,149,51,152,51,152,55,152,58,153,61,155,62,157,65,160,68,161,69,165,70,168,70,171,72,174,74,177,74,178,74,177,77,176,80,174,84,172,87,171,90,168,95,166,100,164,105,161,110,158,115,156,120,157,123,158,127,157,131,156,135,155,139,151,141,143,141,133,141,120,140,114,138,111,134,106,133,101,133,100,136,98,139,96,142,90,143,88,145,84,147,77,147,74,148,70,151,64,149,55,146,48,142,41,138,35,135,30,133" href="http://www.detran.am.gov.br" target="_blank" />
                            <area alt="ba" title="Bahia" shape="poly" coords="285,158,282,162,280,165,279,168,282,170,282,172,281,175,281,178,282,182,282,186,281,190,281,193,282,196,284,199,284,203,285,205,288,202,292,201,294,199,297,197,299,196,303,196,305,196,306,199,307,201,309,201,311,200,313,200,315,201,318,203,321,205,324,205,326,206,329,208,331,210,336,210,340,211,343,213,345,215,344,218,343,221,341,224,339,226,340,229,341,232,342,235,345,236,348,233,351,230,350,227,352,223,352,219,353,215,354,211,353,206,353,199,352,193,352,189,354,185,354,181,358,180,360,182,362,179,366,175,368,172,364,168,362,164,362,161,364,159,364,153,363,149,360,146,356,143,352,141,348,141,345,144,342,146,338,149,335,147,334,143,332,141,329,144,326,146,324,148,317,150,313,149,310,148,307,148,307,151,307,154,306,157,302,160,297,162,294,163,290,161" href="http://www.detran.ba.gov.br" target="_blank" />
                            <area alt="ce" title="Ceará" shape="poly" coords="332,83,344,83,347,84,351,87,355,89,359,91,362,95,366,97,368,100,367,103,364,107,362,110,359,114,357,117,357,120,357,124,357,127,354,130,349,127,343,127,339,127,340,122,339,121,336,118,335,112,334,107,334,102,334,97,333,92,331,89,331,86" href="http://portal.detran.ce.gov.br/" target="_blank" />
                            <area alt="df" title="Distrito Federal" shape="poly" coords="271,205,260,204,260,213,272,213,272,207" href="http://www.detran.df.gov.br" target="_blank" />
                            <area alt="es" title="Espirito Santo" shape="poly" coords="341,236,344,238,345,240,346,243,345,247,346,250,342,252,341,255,340,257,339,260,337,262,335,265,333,267,329,266,325,264,326,261,327,258,330,256,332,254,334,249,334,244,334,242,334,240,334,237,337,235" href="http://www.detran.es.gov.br" target="_blank" />
                            <area alt="go" title="Goiás" shape="poly" coords="272,206,275,204,277,201,280,202,282,202,282,199,281,196,279,194,279,189,280,185,276,185,274,186,270,187,267,189,264,189,262,188,257,188,255,185,253,184,251,184,249,187,249,188,245,186,242,185,240,183,238,183,236,186,236,190,235,193,234,197,233,200,232,203,230,205,227,207,225,209,225,212,221,213,219,216,218,217,216,220,213,223,212,225,211,228,211,231,212,235,214,237,215,239,217,241,220,242,223,243,226,245,229,247,232,249,234,246,237,243,240,240,244,240,249,239,251,238,254,238,260,238,263,238,265,236,267,234,268,231,267,229,268,226,269,223,268,220,268,217,270,214,266,214,262,213,260,213,260,210,260,206,261,204,264,204,267,205,269,205" href="http://www.detran.goias.gov.br" target="_blank" />
                            <area alt="ma" title="Maranhão" shape="poly" coords="280,156,278,152,277,149,274,145,275,140,278,138,278,135,278,132,274,133,270,131,267,127,268,122,268,117,268,111,265,107,261,106,260,104,263,101,267,99,269,96,271,92,274,88,277,84,278,79,280,74,281,69,283,66,286,68,290,68,292,69,294,72,297,74,298,76,298,78,296,81,296,83,297,85,299,84,301,82,304,81,305,79,308,79,312,78,315,80,318,81,322,82,324,83,324,85,321,87,317,89,315,91,314,94,313,97,313,101,314,104,314,107,312,110,312,112,312,115,314,118,310,120,306,121,302,121,300,123,297,126,295,127,292,128,289,130,287,133,286,135,284,140,283,144,282,147,283,150,283,153" href="http://www.detran.ma.gov.br" target="_blank" />
                            <area alt="mt" title="Mato Grosso" shape="poly" coords="206,234,209,234,210,230,209,227,210,223,213,221,215,217,217,215,220,212,223,210,225,206,228,203,231,201,232,197,233,192,234,187,235,185,235,181,235,176,235,170,235,164,237,160,239,155,239,153,234,152,227,152,219,152,214,151,206,151,198,151,190,151,182,150,175,149,172,148,167,144,164,141,163,136,162,132,160,129,158,131,158,135,157,138,156,142,152,143,148,142,144,142,138,142,131,143,125,143,125,146,125,151,124,155,125,158,125,162,129,163,133,163,137,164,140,166,140,168,140,172,142,175,141,178,141,181,139,185,136,189,135,192,136,196,138,200,138,205,136,206,139,210,139,215,143,216,149,216,157,216,157,218,156,222,156,226,159,227,165,229,169,230,172,228,175,225,180,225,184,226,190,228,197,229,204,228" href="http://www.detran.mt.gov.br" target="_blank" />
                            <area alt="ms" title="Mato Grosso do Sul" shape="poly" coords="202,229,197,231,192,231,187,230,181,228,177,228,173,229,171,231,169,232,165,232,162,231,164,235,164,237,164,239,163,241,163,244,162,247,160,250,160,252,161,255,160,257,159,260,161,263,161,266,161,270,161,273,162,276,166,276,171,276,175,276,178,276,182,277,184,280,184,283,185,286,186,289,187,292,187,294,191,295,194,293,198,294,200,291,202,288,204,285,207,283,210,280,216,276,217,275,220,272,221,268,223,264,224,263,226,260,229,256,231,255,230,249,226,248,220,245,216,243,211,241,210,238,206,234,203,235" href="http://www.detran.ms.gov.br" target="_blank" />
                            <area alt="mg" title="Minas Gerais" shape="poly" coords="298,198,302,198,304,200,305,202,308,203,310,202,313,202,316,204,320,206,324,207,327,208,329,210,329,213,335,213,338,213,341,214,343,215,342,218,340,221,338,223,337,225,337,228,337,230,340,232,337,234,334,234,332,236,332,239,332,242,332,246,332,249,331,252,329,255,326,257,324,259,324,263,321,267,319,270,318,272,315,274,312,275,306,275,302,276,298,277,294,278,290,279,288,281,284,282,283,283,280,284,277,281,277,277,277,272,277,269,274,268,271,265,270,260,269,256,267,254,264,255,260,255,256,255,253,256,251,257,249,254,246,253,241,253,236,253,233,253,233,250,235,247,238,243,239,242,243,242,247,241,250,241,253,239,257,239,261,239,264,241,266,238,269,235,270,232,269,229,269,227,270,226,271,223,270,221,270,218,271,215,273,215,274,212,276,211,274,208,275,206,278,205,279,204,282,206,284,207,288,204,292,202" href="https://www.detran.mg.gov.br" target="_blank"/>
                            <area alt='pa' title="Pará" shape="poly" coords="281,66,279,70,279,74,277,77,276,80,275,84,273,87,270,92,268,94,267,98,264,99,261,101,259,103,256,105,255,108,258,111,258,114,257,117,254,120,250,123,248,126,248,129,249,132,248,136,248,139,245,141,243,144,242,146,240,149,238,150,234,150,226,150,219,150,213,150,204,149,198,149,193,149,187,148,183,148,179,148,175,147,171,146,166,140,165,136,164,133,162,130,161,128,159,124,159,123,159,118,160,114,162,111,165,107,167,102,169,97,172,92,175,86,177,82,179,78,180,74,181,72,179,72,177,72,174,72,171,70,168,68,165,67,161,68,159,66,158,63,156,61,156,59,154,58,154,54,153,50,153,46,153,41,156,39,160,38,164,36,167,34,172,34,178,34,181,34,182,31,182,28,185,28,188,27,191,27,192,29,193,31,193,34,197,36,203,39,206,41,207,44,209,48,210,52,213,56,215,60,218,64,222,66,219,68,221,70,225,69,228,68,230,66,231,67,233,69,235,71,237,72,240,73,243,74,246,73,247,73,251,73,255,70,258,66,261,62,263,61,270,62,275,63" href="http://www.detran.pa.gov.br" target="_blank" />
                            <!--<area alt='pa' title="Pará" shape="poly" coords="240,56,239,60,238,62,239,66,239,69,243,69,246,67,249,67,251,65,253,65,255,62,256,59,257,57,251,56,246,56" href="#" />-->
                            <area alt="pb" title="Paraíba" shape="poly" coords="370,116,369,118,369,120,370,122,373,122,376,123,379,121,380,119,383,119,387,119,390,120,393,121,394,123,394,126,391,127,388,129,387,130,384,130,379,131,378,132,375,134,374,135,373,133,373,131,374,127,373,126,370,126,367,128,365,129,361,130,358,130,359,126,358,123,358,121,359,119,363,119,366,119" href="http://www.detran.pb.gov.br" target="_blank" />
                            <area alt="pr" title="Paraná" shape="poly" coords="228,283,220,283,213,283,209,283,207,285,204,288,202,292,200,295,199,300,199,304,199,308,197,310,200,310,202,311,202,314,204,317,207,318,215,318,218,319,222,321,227,321,229,318,234,317,236,315,239,315,243,315,245,316,248,316,249,315,253,316,257,316,258,313,259,310,260,308,258,307,256,306,254,304,253,303,249,303,249,301,247,297,246,295,245,294,245,288,243,286,239,286,233,285" href="http://www.detran.pr.gov.br" target="_blank" />
                            <area alt="pe" title="Pernambuco" shape="poly" coords="390,129,388,131,386,132,383,133,379,133,377,135,375,136,372,135,371,132,372,129,371,127,369,128,366,130,364,131,361,131,357,132,352,131,350,130,348,129,345,129,340,128,338,129,338,131,339,134,338,136,335,138,334,139,335,142,337,145,339,147,341,144,345,142,348,140,351,139,354,140,357,142,360,144,363,144,366,142,369,143,371,145,374,145,378,145,381,144,383,142,384,140,387,141,391,141,392,139,393,136,394,133,394,129" href="http://www.detran.pe.gov.br" target="_blank" />
                            <area alt="pi" title="Piauí" shape="poly" coords="326,83,324,87,322,89,319,90,317,92,315,96,315,100,315,104,315,107,315,108,314,111,314,115,315,117,315,119,313,122,309,123,304,123,301,124,299,126,296,129,293,130,290,132,288,136,286,139,285,143,285,147,286,152,285,156,288,157,290,159,294,161,299,159,304,156,304,152,305,148,307,146,312,147,317,147,321,146,325,145,328,142,330,140,334,137,337,134,336,130,336,127,338,124,336,121,334,116,333,111,333,106,332,99,331,94,329,88,329,84" href="http://www.detran.pi.gov.br" target="_blank" />
                            <area alt="rj" title="Rio de Janeiro" shape="poly" coords="323,266,322,269,321,272,318,274,315,275,312,276,308,277,305,278,301,278,298,279,299,281,301,283,300,286,303,284,305,284,309,284,311,282,313,282,314,284,318,284,322,284,323,282,325,279,327,277,331,276,332,274,333,271,332,268,327,267" href="http://www.detran.rj.gov.br" target="_blank" />
                            <area alt="rn" title="Rio Grande do Norte" shape="poly" coords="377,121,378,119,379,118,380,117,383,117,387,118,391,118,392,116,391,113,391,111,391,108,390,107,387,105,385,105,382,105,379,105,376,105,374,103,370,103,368,104,366,107,365,109,363,111,362,114,360,117,364,117,367,115,369,114,372,115,372,117,372,120,373,120" href="http://www.detran.rn.gov.br" target="_blank" />
                            <area alt="rs" title="Rio Grande do Sul" shape="poly" coords="221,376,223,377,224,373,228,372,230,371,232,365,236,361,236,358,233,359,230,359,228,358,227,361,226,364,225,367,222,369,220,371,219,374,218,378,217,381,216,385,213,388,212,390,209,392,206,392,207,389,209,385,209,383,206,381,203,378,201,375,198,374,196,372,193,370,191,369,188,367,185,364,183,366,181,366,179,363,177,360,174,358,172,356,170,357,167,359,166,356,169,353,172,351,175,347,178,343,182,341,185,337,189,335,193,332,198,329,200,328,208,328,212,328,216,329,221,330,225,332,229,333,231,337,234,339,237,341,242,341,243,343,242,346,241,349,243,350,242,354,240,358,237,364" href="http://www.detran.rs.gov.br" target="_blank" />
                            <area alt="ro" title="Rondônia" shape="poly" coords="76,149,73,152,75,152,80,151,84,151,86,152,86,156,85,159,85,161,85,165,85,168,87,170,89,174,93,177,96,178,101,178,103,180,106,180,108,183,111,185,116,185,118,188,121,188,126,189,130,189,132,189,135,187,138,184,140,180,139,175,138,172,138,169,139,167,136,166,133,165,128,165,124,165,123,164,123,160,123,156,123,152,123,148,123,145,122,143,120,142,117,142,115,140,112,138,109,135,105,135,102,137,100,140,97,143,95,144,92,145,88,147" href="http://www.detran.ro.gov.br" target="_blank" />
                            <area alt="rr" title="Roraima" shape="poly" coords="139,0,133,2,125,9,121,10,117,11,113,12,112,15,108,15,106,13,103,13,100,13,98,10,96,9,93,10,95,12,98,14,99,16,97,19,97,22,97,26,102,27,105,28,106,30,108,32,109,34,112,39,113,42,114,46,114,49,114,51,115,54,116,57,116,60,117,63,121,66,122,62,123,59,126,58,128,57,131,60,134,59,136,56,137,52,140,50,143,49,147,49,150,48,150,43,150,39,147,36,143,33,141,30,140,26,140,22,140,18,143,14,143,10,139,6,138,6" href="http://www.detran.rr.gov.br" target="_blank" />
                            <area alt="sc" title="Santa Catarina" shape="poly" coords="253,317,249,317,248,318,244,318,243,317,238,317,235,318,233,319,230,320,229,322,223,322,220,321,217,321,214,320,210,320,207,320,205,320,205,323,205,326,209,326,213,326,217,327,220,328,224,330,228,331,230,334,233,336,236,339,240,339,244,340,244,343,243,346,244,348,247,346,250,344,252,342,255,340,256,336,256,333,256,329,256,325,256,321" href="http://www.detran.sc.gov.br" target="_blank" />
                          	<area alt="sp" title="São Paulo" shape="poly" coords="250,301,249,297,247,293,246,289,246,287,244,285,243,284,239,283,234,284,230,283,228,281,224,281,219,281,214,280,217,277,220,274,222,271,223,266,226,262,229,259,233,255,237,255,247,255,249,257,252,259,255,257,262,256,266,256,269,259,269,265,271,269,275,270,275,274,275,279,276,283,279,285,283,285,289,282,293,281,296,281,298,283,298,286,297,288,292,289,289,291,285,293,280,294,275,296,271,299,267,302,264,305,258,305,254,302" href="http://www.detran.sp.gov.br" target="_blank" />
                          	<area alt="se" title="Sergipe" shape="poly" coords="364,150,365,152,366,154,366,158,366,160,365,162,364,164,364,166,367,168,370,168,372,165,375,162,378,158,374,155,369,153" href="http://www.detran.se.gov.br" target="_blank" />
                            <area alt="to" title="Tocantins" shape="poly" coords="259,107,259,108,259,110,260,113,259,116,258,119,256,121,253,122,250,124,250,128,250,130,251,133,251,136,249,139,248,142,245,144,243,148,242,151,241,156,239,159,238,163,237,167,237,173,237,178,240,179,242,181,244,184,247,185,250,182,253,181,255,182,259,185,263,186,266,186,271,185,274,183,278,182,280,181,279,177,280,175,280,172,278,169,277,167,278,164,280,161,282,158,279,156,276,153,275,150,272,145,272,140,277,135,272,134,268,131,265,127,266,124,267,120,267,114,265,110,263,108" href="http://www.detran.to.gov.br" target="_blank" />
                        </map>
                  </div>
                </div>
                <div class="noticiapropaganda">
                    <?php
                    imprimeBannerLateralDetrans();
                    imprimeBannerLateralPequenoDetrans();
                    ?>
                </div>
            </div>
    	</div>
    </div>
    <?php require_once PROJECT_INC_PATH.'rodapebloco.php';?>
</div>
</body>
</html>