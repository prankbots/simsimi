<?php
/*
copyright @ medantechno.com
Modified by Ilyasa
2017
*/
require_once('./line_class.php');

$channelAccessToken = 'cjeKJhzQw99iPoOfA2HT+m36UbzTJz/k8ydhLyulU4AiEF2wf/djlUAtWlIiNz+1GBuBmzPncbsmrDGP7SH0SFiNE+KZ3texYrirn4/4pnKX2m85lnY3Icqo2sU/SlZU1f4D6HA04NGzF3z4DAyVQlGUYhWQfeY8sLGRXgo3xvw='; //Your Channel Access Token
$channelSecret = '0328a12fc2018eb18b070ce55b33e1ad';//Your Channel Secret

$client = new LINEBotTiny($channelAccessToken, $channelSecret);

$userId 	= $client->parseEvents()[0]['source']['userId'];
$replyToken = $client->parseEvents()[0]['replyToken'];
$message 	= $client->parseEvents()[0]['message'];
$profil = $client->profil($userId);
$pesan_datang = $message['text'];

if($message['type']=='sticker')
{	
	$balas = array(
							'UserID' => $profil->userId,	
                                                        'replyToken' => $replyToken,							
							'messages' => array(
								array(
										'type' => 'text',									
										'text' => 'Sticker palakan aja di pamerin.'										
									
									)
							)
						);
						
}
else
$pesan=str_replace(" ", "%20", $pesan_datang);
$key = 'm9NYsr-fKud~Sxgctdvkj0C1FOewZLAg3Krz8UI9'; //API SimSimi
$url = 'http://sandbox.api.simsimi.com/request.p?key='.$key.'&lc=id&ft=1.0&text='.$pesan;
$json_data = file_get_contents($url);
$url=json_decode($json_data,1);
$diterima = $url['response'];
if($message['type']=='text')
{
if($url['result'] == 404)
	{
		$balas = array(
							'UserID' => $profil->userId,	
                                                        'replyToken' => $replyToken,													
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Mohon Gunakan Bahasa Indonesia Yang Benar :D.'
									)
							)
						);
				
	}
else
if($url['result'] != 100)
	{
		
		
		$balas = array(
							'UserID' => $profil->userId,
                                                        'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Maaf '.$profil->displayName.' Server Kami Sedang Sibuk Sekarang.'
									)
							)
						);
				
	}
	else{
		$balas = array(
							'UserID' => $profil->userId,
                                                        'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => ''.$diterima.''
									)
							)
						);
						
	}
}
 
$result =  json_encode($balas);

file_put_contents('./reply.json',$result);


$client->replyMessage($balas);
