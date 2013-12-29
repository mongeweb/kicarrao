<?php
/**
 * imprimeTinymce()
 * 
 * Função que imprime o editor Tinymce.
 * 
 * @author Diego Lopes da Silva
 * @copyright 03/2013
 * @version 1.0
 * 
 * Histórico:
 * 
 * Data			| Versão | Modificação
 * ------------------------------------------------------------------------------------------------
 * 22/03/2013	|	1.0	 | Criado
 * ------------------------------------------------------------------------------------------------
 * 
 * @param string $name
 * @param string $value
 * @param integer $width
 * @param integer $height
 * @return void
 */
function imprimeTinymce($name = 'texto', $value = '', $width = 545, $height = 450)
{
?>
    <!-- TinyMCE -->
    <script type="text/javascript" src="http://<?=ADMIN_URL;?>/tinymce/tiny_mce.js"></script>
    <script type="text/javascript">
    	tinyMCE.init({
    		// General options
    		file_browser_callback: 'openKCFinder',
    		mode : "exact",
            elements : '<?=$name;?>',
    		language : "pt",
    		theme : "advanced",
    		width: <?=$width;?>,
    		height: <?=$height;?>,
    		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,inlinepopups,insertdatetime,preview,searchreplace,print,contextmenu,paste,directionality,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",
    
    		// Theme options
    		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,copy,paste,pastetext,pasteword,|,forecolor,backcolor",
    		theme_advanced_buttons2 : "styleselect,formatselect,fontselect,fontsizeselect",
            theme_advanced_buttons3 : "search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,preview",
    		theme_advanced_buttons4 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,advhr,|,print",
    		theme_advanced_buttons5 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,pagebreak,restoredraft,|,ltr,rtl",
    		theme_advanced_toolbar_location : "top",
    		theme_advanced_toolbar_align : "left",
    		theme_advanced_statusbar_location : "bottom",
    		theme_advanced_resizing : true,
    
    		// Example content CSS (should be your site CSS)
    		content_css : "http://<?=ADMIN_URL;?>/tinymce/css/content.css",
    
    		// Drop lists for link/image/media/template dialogs
    		template_external_list_url : "http://<?=ADMIN_URL;?>/tinymce/lists/template_list.js",
    		external_link_list_url : "http://<?=ADMIN_URL;?>/tinymce/lists/link_list.js",
    		external_image_list_url : "http://<?=ADMIN_URL;?>/tinymce/lists/image_list.js",
    		media_external_list_url : "http://<?=ADMIN_URL;?>/tinymce/lists/media_list.js",
    
    		// Style formats
    		style_formats : [
    			{title : 'Bold text', inline : 'b'},
    			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
    			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
    			{title : 'Example 1', inline : 'span', classes : 'example1'},
    			{title : 'Example 2', inline : 'span', classes : 'example2'},
    			{title : 'Table styles'},
    			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
    		],
    
    		// Replace values for the template plugin
    		template_replace_values : {
    			username : "Some User",
    			staffid : "991234"
    		}
    	});
    	function openKCFinder(field_name, url, type, win)
        {
            tinyMCE.activeEditor.windowManager.open(
            {
                file: 'http://<?=ADMIN_URL;?>/tinymce/kcfinder/browse.php?opener=tinymce&type=' + type,
                title: 'KCFinder',
                width: <?=$width;?>,
                height: <?=$height;?>,
                resizable: "yes",
                inline: true,
                close_previous: "no",
                popup_css: false
            },
            {
                window: win,
                input: field_name
            });
            return false;
        }
    </script>
    <textarea id="<?=$name;?>" name="<?=$name;?>" rows="15" cols="80" style="width: <?=$width;?>px; height: <?=$height;?>px"><?=$value;?></textarea>
<?php
}
?>
    		
