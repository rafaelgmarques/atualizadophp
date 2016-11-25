<?php

    /*
    Rafael Gonçalves Marques
    201613428
    */

	$conecta = mysqli_connect("localhost", "root", "","atualizadophp") or print (mysql_error());
	//$result = mysqli_query($conecta,"atualizadophp");
	print "Conexão OK!"; 
	mysqli_query($conecta,"insert into telegram values (2,'dfsdd','sddfgs',2);"); 
	mysqli_close($conecta);
	
    $file = "message_id.txt";
    
    ########################MegaSena######################################
    for ($i = 1; $i <= 6; $i++) {//gera os 6 numeros
        $n[] = str_pad(rand(1, 60), 2, '0', STR_PAD_LEFT); 
    }
    sort($n); //ordena os números
    $mega = implode(' - ', $n);//exibe os numeros
    ########################MegaSena######################################

    $url=file_get_contents('https://api.telegram.org/bot267280014:AAHI1LpAoTNse_37pLe0z0kj70bn7KGJrKM/getUpdates');
    $x=json_decode($url,true);
    $xLen=count($x['result']);

    for ($i=0;$i<$xLen;$i++) {
        $id = $x['result'][$i]['message']['chat']['id'];
        $text = $x['result'][$i]['message']['text'];
        $message = $x['result'][$i]['update_id'];
        $ids[$i] = $id; 
        $texts[$i] = $text;
        $messages[$i] = $message;
    }
    
    $str = file_get_contents($file);
    $arrUpdateId =  explode( ',', $str );
    
    for ($i=0;$i<$xLen;$i++) {
        if (!in_array($messages[$i], $arrUpdateId)){
            if ($texts[$i] == '/megaSena') {
            $url = 'https://api.telegram.org/bot267280014:AAHI1LpAoTNse_37pLe0z0kj70bn7KGJrKM/sendMessage?chat_id='.$ids[$i]."&text=$mega";
            file_get_contents($url);
            file_put_contents($file, $messages[$i].",", FILE_APPEND | LOCK_EX);
        }
    }    
    }
?>
