$(document).ready(function(){
	//Imprime valores genéricos nos inputs quando não estão preenchidos
	/*jQuery("input").focus(function(){	
		jQuery(this).parent().children("label").css({'display':'none'});
		jQuery(this).blur(function(){
			if(jQuery(this).val()==""){
				jQuery(this).parent().children("label").css({'display':'block'});
			}
		})
	})
	jQuery("textarea").focus(function(){	
		jQuery(this).parent().children("label").css({'display':'none'});
		jQuery(this).blur(function(){
			if(jQuery(this).val()==""){
				jQuery(this).parent().children("label").css({'display':'block'});
			}
		})
	})*/
	
	jQuery("div.menuitem").click(function(){
		var link = $(this).attr('rel');
		document.location.replace(link);
	})
	
	jQuery("input#nome").val("Nome")
		.focus(function(){
			if(jQuery(this).val()=="Nome"){
				jQuery(this).val("");
			}									 
		})
		.blur(function(){
			if(jQuery(this).val()==""){
				jQuery(this).val("Nome"); 
			}
        })
		
	jQuery("input#email").val("E-mail")
		.focus(function(){
			if(jQuery(this).val()=="E-mail"){
				jQuery(this).val("");
			}									 
		})
		.blur(function(){
			if(jQuery(this).val()==""){
				jQuery(this).val("E-mail"); 
			}
        })
	
	jQuery("input#nomenews").val("Nome")
		.focus(function(){
			if(jQuery(this).val()=="Nome"){
				jQuery(this).val("");
			}									 
		})
		.blur(function(){
			if(jQuery(this).val()==""){
				jQuery(this).val("Nome"); 
			}
        })
		
	jQuery("input#emailnews").val("E-mail")
		.focus(function(){
			if(jQuery(this).val()=="E-mail"){
				jQuery(this).val("");
			}									 
		})
		.blur(function(){
			if(jQuery(this).val()==""){
				jQuery(this).val("E-mail"); 
			}
        })		
	
	jQuery("input#empresa").val("Empresa")
		.focus(function(){
			if(jQuery(this).val()=="Empresa"){
				jQuery(this).val("");
			}									 
		})
		.blur(function(){
			if(jQuery(this).val()==""){
				jQuery(this).val("Empresa"); 
			}
        })
	
	jQuery("input#cnpj").val("CNPJ")
		.focus(function(){
			if(jQuery(this).val()=="CNPJ"){
				jQuery(this).val("");
			}									 
		})
		.blur(function(){
			if(jQuery(this).val()==""){
				jQuery(this).val("CNPJ"); 
			}
        })
		
	jQuery("input#telefone").val("Telefone")
		.focus(function(){
			if(jQuery(this).val()=="Telefone")
            {
				jQuery(this).val("");
			}									 
		})
		.blur(function(){
			if(jQuery(this).val()==""){
				jQuery(this).val("Telefone"); 
			}
        })
	
	jQuery("input#celular").val("Celular")
		.focus(function(){
			if(jQuery(this).val()=="Celular"){
				jQuery(this).val("");
			}									 
		})
		.blur(function(){
			if(jQuery(this).val()==""){
				jQuery(this).val("Celular"); 
			}
        })	
		
	jQuery("input#regiao").val("Região")
		.focus(function(){
			if(jQuery(this).val()=="Região"){
				jQuery(this).val("");
			}									 
		})
		.blur(function(){
			if(jQuery(this).val()==""){
				jQuery(this).val("Região"); 
			}
        })
	
	jQuery("input#cidade").val("Cidade")
		.focus(function(){
			if(jQuery(this).val()=="Cidade"){
				jQuery(this).val("");
			}									 
		})
		.blur(function(){
			if(jQuery(this).val()==""){
				jQuery(this).val("Cidade"); 
			}
        })	
		
		
	jQuery("input#assunto").val("Assunto")
		.focus(function(){
			if(jQuery(this).val()=="Assunto"){
				jQuery(this).val("");
			}									 
		})
		.blur(function(){
			if(jQuery(this).val()==""){
				jQuery(this).val("Assunto"); 
			}
        })	
		
	jQuery("textarea#mensagem").val("Mensagem")
		.focus(function(){
			if(jQuery(this).val()=="Mensagem"){
				jQuery(this).val("");
			}									 
		})
		.blur(function(){
			if(jQuery(this).val()==""){
				jQuery(this).val("Mensagem"); 
			}
        })				
	
	//Mostra bloco com saiba mais quando passar o mouse no box
	jQuery("div.linksaiba").css({'display':'none'});
	jQuery("div.linksaiba2").css({'display':'none'});
	jQuery("div.linkbox").mouseenter(function(){
		jQuery("div.linksaiba").css({'display':'block'});
		jQuery("div.linkbox").mouseleave(function(){
			jQuery("div.linksaiba").css({'display':'none'});
		})
	})
	jQuery("div.linkbox2").mouseenter(function(){
		jQuery("div.linksaiba2").css({'display':'block'});
		jQuery("div.linkbox2").mouseleave(function(){
			jQuery("div.linksaiba2").css({'display':'none'});
		})
	})
	
	//Troca a cor das setas do carrossel Onde Estamos
	jQuery("div.setaesq").mouseenter(function(){
		jQuery("div.setaesq img").attr("src","http://"+PROJECT_IMG_URL+"/setaesqhover.png");
		jQuery(this).mouseleave(function(){
			jQuery("div.setaesq img").attr("src","http://"+PROJECT_IMG_URL+"/setaesq.png");
		})
	})
	jQuery("div.setadir").mouseenter(function(){
		jQuery("div.setadir img").attr("src","http://"+PROJECT_IMG_URL+"/setadirhover.png");
		jQuery(this).mouseleave(function(){
			jQuery("div.setadir img").attr("src","http://"+PROJECT_IMG_URL+"/setadir.png");
		})
	})
    
    //Muda fundo ao redor dos blocos do menu e a cor da fonte dos mesmos
	jQuery("div.topo div.menuitem a").css({'color':'#534741'});
	jQuery("div.topo div.menuitem div.menulinha img").attr("src","http://"+PROJECT_IMG_URL+"/linhacurvadaescura.png");
	jQuery("div.topo div.menuitem").mouseenter(function()
    {
		jQuery(this).addClass("menuhover");
		jQuery(this).children("a").css({'color':'#534741'});
		jQuery(this).find("div.menutexto > div.menulinha > img").attr("src","http://"+PROJECT_IMG_URL+"/linhacurvadaescura.png");
		jQuery(this).mouseleave(function(){
			jQuery(this).removeClass("menuhover");
			jQuery(this).children("a").css({'color':'#534741'});
			jQuery(this).find("div.menutexto > div.menulinha > img").attr("src","http://"+PROJECT_IMG_URL+"/linhacurvadaescura.png");
		})
	})
	
	jQuery("div#menulookbook").mouseenter(function(){
		jQuery(this).find("a > img").attr("src","http://"+PROJECT_IMG_URL+"/iconelookbookhover.png");
		jQuery(this).mouseleave(function(){
			jQuery(this).find("a > img").attr("src","http://"+PROJECT_IMG_URL+"/iconelookbook.png");
		})
	})
	jQuery("div#menulojaonline").mouseenter(function(){
		jQuery(this).find("a > img").attr("src","http://"+PROJECT_IMG_URL+"/iconelojaonlinehover.png");
		jQuery(this).mouseleave(function(){
			jQuery(this).find("a > img").attr("src","http://"+PROJECT_IMG_URL+"/iconelojaonline.png");
		})
	})
	jQuery("div#menufaleconosco").mouseenter(function(){
		jQuery(this).find("a > img").attr("src","http://"+PROJECT_IMG_URL+"/iconefaleconoscohover.png");
		jQuery(this).mouseleave(function(){
			jQuery(this).find("a > img").attr("src","http://"+PROJECT_IMG_URL+"/iconefaleconosco.png");
		})
	})
	/*if(jQuery("div.topo div.menuitem").hasClass("menuhover")){
		jQuery("div.topo div.menuitem div.menulinha").attr("src","img/linhacurvadaescura.png");
	}else{
		jQuery("div.topo div.menuitem div.menulinha").attr("src","img/linhacurvadamenor.png");
	}*/
	
	jQuery("div.topointerno div.menuitem a").css({'color':'#FFF'});
	//jQuery("div.topointerno div.menuitem div.menulinha img").attr("src","img/linhacurvadamenor.png");
	jQuery("div.topointerno div.menuitem").mouseenter(function()
    {
		jQuery(this).addClass("menuhover");
		jQuery(this).children("a").css({'color':'#534741'});
		jQuery(this).find("div.menutexto > div.menulinha > img").attr("src","http://"+PROJECT_IMG_URL+"/linhacurvadaescura.png");
		jQuery(this).mouseleave(function(){
			jQuery(this).removeClass("menuhover");
			jQuery(this).children("a").css({'color':'#FFF'});
			jQuery(this).find("div.menutexto > div.menulinha > img").attr("src","http://"+PROJECT_IMG_URL+"/linhacurvadamenor.png");
		})
	})
	/*jQuery("div.topointerno div.menuitem div.menulinha").attr("src","img/linhacurvadamenor.png");
	jQuery("div.topointerno div.menuitem").hasClass("menuhover", function(){
		jQuery("div.topointerno div.menuitem div.menulinha").attr("src","img/linhacurvadaescura.png");
	})*/
	
	jQuery("div.detalhelook").css({'display':'none'});
	jQuery("div.carrolook div.maisinfo").click(function(){
		jQuery("div.detalhelook").css({'display':'block'});
		jQuery(this).css({'display':'none'});
		jQuery("div.fechar").click(function(){
			jQuery("div.detalhelook").css({'display':'none'});
			jQuery("div.carrolook div.maisinfo").css({'display':'block'});
		})
	})
	
	jQuery("div.bordfoto").mouseenter(function(){
		jQuery(this).addClass("bordfotohover");
		jQuery(this).mouseleave(function(){
			jQuery(this).removeClass("bordfotohover");
		})
	})
	
	
	
	//Função para select personalizado
	jQuery('div.identinput select').each(function(){

            var title = jQuery(this).attr('title');

            if( jQuery('option:selected', this).val() != '' ) title = jQuery('option:selected',this).text();

            jQuery(this)

                .css({'z-index':10,'opacity':0})

                .after('<div class="dropmask">' + title + '</div>')

                .change(function(){

                    val = jQuery('option:selected',this).text();

                    jQuery(this).next().text(val);

                })

    });
	
	
	jQuery("div.loginesq").hide();
	jQuery("#esqsenha").click(function(){
		jQuery("div.loginesq").show();
		jQuery("div.fecharesq").click(function(){
			jQuery("div.loginesq").hide();
		})
	})
	jQuery("div.loginident").hide();
	jQuery("#esqsenhaident").click(function(){
		jQuery("div.loginident").show();
		jQuery("div.fecharident").click(function(){
			jQuery("div.loginident").hide();
		})
	})
	
	//links do rodape
	jQuery("p.pol1").click(function(){
		jQuery("div.sup1").parent().find("div.supitem").removeClass("supmenuhover");
		jQuery("div.sup1").addClass("supmenuhover");
	})
	jQuery("p.pol2").click(function(){
		jQuery("div.sup2").parent().find("div.supitem").removeClass("supmenuhover");
		jQuery("div.sup2").addClass("supmenuhover");
	})
	jQuery("p.pol3").click(function(){
		jQuery("div.sup3").parent().find("div.supitem").removeClass("supmenuhover");
		jQuery("div.sup3").addClass("supmenuhover");
	})
	jQuery("p.pol4").click(function(){
		jQuery("div.sup4").parent().find("div.supitem").removeClass("supmenuhover");
		jQuery("div.sup4").addClass("supmenuhover");
	})
	jQuery("p.pol5").click(function(){
		jQuery("div.sup5").parent().find("div.supitem").removeClass("supmenuhover");
		jQuery("div.sup5").addClass("supmenuhover");
	})
	
	//hacks ie
	if(jQuery.browser.msie){
		if((jQuery.browser.version)==9.0){
			jQuery("div.titulopagina").css({'margin-top':'114px'});
		}

		if((jQuery.browser.version)==8)
        {
			jQuery("label.valor").css({'top':'5px'});
			jQuery("div.bordadosbloco").css({
				'-ms-filter':'progid:DXImageTransform.Microsoft.Alpha(Opacity=50)',
				'filter':'alpha(opacity=50)'
			})
			jQuery("div.titulopagina").css({"margin-top":"108px"});
			jQuery("div.titulopagina").addClass("ie8rotate");
		}
	}
	
	if(jQuery.browser.webkit){
		/*$("input.calcfrete").css({'margin-right':'17px'});*/
	}
    $(".menuitem" + ".menuativo").unbind("mouseleave , mouseenter");
	
	/*$("div.formpagimg").each(function(){
		$("div.formpagimg").click(function(){
			$(this).addClass("pagimghover");
			$("div.formpagtexto").show();
		})
		$("div.formpagimg").removeClass("pagimghover");
	})*/
})


/*
$(window).scroll(function() {
		var a = $(window).scrollTop();
		if (a > 50) {
				$(".topo").addClass("topomovel");
				$(".topomovel").removeClass("topo");
				$(".topomovel").css({
						position: "fixed"
				}, 1000);
				$(".topointerno").css({
						position: "fixed"
				}, 1000);
				
				
		} else {
				$(".topomovel").addClass("topo");
				$(".topo").removeClass("topomovel");
				$(".topo").css({
					position: "relative"
				}, 1000);
				$(".topointerno").css({
						position: "relative"
				}, 1000);
				
		}
});
*/

$(window).scroll(function()
{
    var a = $(window).scrollTop();
    if (a > 0) 
    {
        $(".topo").addClass("topomovel");
        $(".topomovel").removeClass("topo");
        $(".topomovel").css({"position": "fixed"});
        $(".topointerno").css({"position": "fixed"});
		$("div.centrointerno").css({'margin-top':'152px'});
        
    }
    else 
    {
        $(".topomovel").addClass("topo");
        $(".topo").removeClass("topomovel");
        $(".topo").css({"position":"relative"});
        $(".topointerno").css({"position": "relative"});
        $("div.centrointerno").css({'margin-top':'0px'});
    }
});









