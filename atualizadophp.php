<?php
    /*
    Rafael Gonçalves Marques
    201613428
    */

	$conecta = mysqli_connect("localhost", "root", "","atualizadophp") or print (mysql_error()); //conectando ao BD
	
	$url=file_get_contents('https://api.telegram.org/bot267280014:AAHI1LpAoTNse_37pLe0z0kj70bn7KGJrKM/getUpdates');
    $x=json_decode($url,true);
    $xLen=count($x['result']);
	
	for ($i=0;$i<$xLen;$i++) //capturando dados do JSON
	{
		$idUpdate[$i] = $x['result'][$i]['update_id'];	
        $idChat[$i] = $x['result'][$i]['message']['chat']['id'];
        $text[$i] = $x['result'][$i]['message']['text'];
    }
	
	$file = "idUpdate.txt"; //criando arquivo de texto
	$str = file_get_contents($file);
    $arrFile =  explode( ',', $str);
	
	for ($i = 1; $i <= 6; $i++) //gera os 6 numeros da megaSena
	{
        $n[] = str_pad(rand(1, 60), 2, '0', STR_PAD_LEFT); 
    }
    sort($n); //ordena os números
    $mega = implode(' - ', $n);//exibe os numeros
	
	for ($i=0;$i<$xLen;$i++) 
	{
		if (!in_array($idUpdate[$i], $arrFile))
		{
			if ($text[$i] == '/megaSena') 
			{
				$url = 'https://api.telegram.org/bot267280014:AAHI1LpAoTNse_37pLe0z0kj70bn7KGJrKM/sendMessage?chat_id='.$idChat[$i]."&text=$mega";
				file_get_contents($url);
				file_put_contents($file, $idUpdate[$i].",", FILE_APPEND | LOCK_EX);
				print ($mega);
				mysqli_query($conecta,"insert into boot values ($idUpdate[$i],$idChat[$i],$mega,1);");
			}
		}
	}
	mysqli_close($conecta);
?>