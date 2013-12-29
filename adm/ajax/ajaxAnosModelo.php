<?php
$ano = isset($_POST['ano']) ? $_POST['ano'] : '';
$anos = array();
if($ano != '')
{
    $anosRange = range($ano,date("Y",strtotime("+1 Year")));
    
    foreach($anosRange as $k => $ano)
    {
        $anos[] = array
		(
			'ano' => $ano,
		);
    }
}
echo json_encode($anos);
?>