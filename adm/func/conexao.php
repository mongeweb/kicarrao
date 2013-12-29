<?php
function conexao()
{
    $link = @mysql_connect(HOST, USER, PASS,false,1);
	if (!$link)
    {
	   //die('Não conseguiu conectar: ' . mysql_error());
       die();
	}
	
	$db_selected = @mysql_select_db(BD, $link);
	$charset = @mysql_set_charset('utf8');
    if (!$db_selected)
    {
	   //die ('Não pode selecionar o banco : ' . mysql_error());
       die();
	}
	return $link;
}


?>