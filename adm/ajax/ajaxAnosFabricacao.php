<?php
$anosRange = range(1900,date("Y"));
$anos = array();
foreach($anosRange as $k => $ano)
{
    $anos[] = array
    (
    	'ano'			=> $ano,
    );
}
echo json_encode($anos);
?>