<?php
$first_url         = explode('"', explode('action="', $result)[1])[0];

$params = explode('<input type="', $result);
$first_params = True;
$post_params = '';

foreach ($params as $value) {
    if (!$first_params){
        if ($post_params != ''){
            $post_params .= '&';
        }
        if (explode('"', $value)[2] == 'TDS2_Navigator_language'){
            $post_params .= 'TDS2_Navigator_language=pt-PT';
        } elseif (explode('"', $value)[2] == 'TDS2_Navigator_javaEnabled'){
            $post_params .= 'TDS2_Navigator_javaEnabled=false';
        } elseif (explode('"', $value)[2] == 'TDS2_Navigator_jsEnabled'){
            $post_params .= 'TDS2_Navigator_jsEnabled=true';
        } elseif (explode('"', $value)[2] == 'TDS2_Screen_colorDepth'){
            $post_params .= 'TDS2_Screen_colorDepth=24';
        } elseif (explode('"', $value)[2] == 'TDS2_Screen_height'){
            $post_params .= 'TDS2_Screen_height=1080';
        } elseif (explode('"', $value)[2] == 'TDS2_Screen_width'){
            $post_params .= 'TDS2_Screen_width=1920';
        } elseif (explode('"', $value)[2] == 'TDS2_Screen_PixelDepth'){
            $post_params .= 'TDS2_Screen_PixelDepth=';
        } elseif (explode('"', $value)[2] == 'TDS2_TimezoneOffset'){
            $post_params .= 'TDS2_TimezoneOffset=0';
        } else {
            $post_params .= explode('"', $value)[2];
            $post_params .= '=';
            $post_params .= urlencode(html_entity_decode(explode('"', $value)[4]));
        }
    }
    $first_params = False;
}

curl_setopt_array($ch, array(
    CURLOPT_URL => $first_url,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_FOLLOWLOCATION => 1,
    CURLOPT_PROXY => $proxy,
    CURLOPT_COOKIEJAR => getcwd().'/cookies/'.$cid.'.txt',
    CURLOPT_COOKIEFILE => getcwd().'/cookies/'.$cid.'.txt',
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => $post_params,
    CURLOPT_HTTPHEADER => array(
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36',
    )
));
$first_request = curl_exec($ch);

$second_url         = explode('"', explode('action="', $first_request)[1])[0];

$params = explode('<input type="', $first_request);
$second_params = True;
$post_params = '';

foreach ($params as $value) {
    if (!$second_params){
        if ($post_params != ''){
            $post_params .= '&';
        }
        if (explode('"', $value)[2] == 'TDS2_Navigator_language'){
            $post_params .= 'TDS2_Navigator_language=pt-PT';
        } elseif (explode('"', $value)[2] == 'TDS2_Navigator_javaEnabled'){
            $post_params .= 'TDS2_Navigator_javaEnabled=false';
        } elseif (explode('"', $value)[2] == 'TDS2_Navigator_jsEnabled'){
            $post_params .= 'TDS2_Navigator_jsEnabled=true';
        } elseif (explode('"', $value)[2] == 'TDS2_Screen_colorDepth'){
            $post_params .= 'TDS2_Screen_colorDepth=24';
        } elseif (explode('"', $value)[2] == 'TDS2_Screen_height'){
            $post_params .= 'TDS2_Screen_height=1080';
        } elseif (explode('"', $value)[2] == 'TDS2_Screen_width'){
            $post_params .= 'TDS2_Screen_width=1920';
        } elseif (explode('"', $value)[2] == 'TDS2_Screen_PixelDepth'){
            $post_params .= 'TDS2_Screen_PixelDepth=';
        } elseif (explode('"', $value)[2] == 'TDS2_TimezoneOffset'){
            $post_params .= 'TDS2_TimezoneOffset=0';
        } else {
            $post_params .= explode('"', $value)[2];
            $post_params .= '=';
            $post_params .= urlencode(html_entity_decode(explode('"', $value)[4]));
        }
    }
    $second_params = False;
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
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36',
    )
));
$second_request = curl_exec($ch);

if (strpos($second_request, 'info_message_auth')!==false){
    if (!$what_3ds){
        $end_time = microtime(true);
        $execution_time = intval($end_time - $start_time); 
        exit("LIVE;Aprovada ($execution_time"."s)");
    }
    $_vbv = 'Desconhecido';
    if (strpos($second_request, 'Mobile Token')!==false){
        $_vbv = 'Mobile Token';
    }
    if (strpos($second_request, 'Token Físico')!==false){
        $_vbv = 'Token Físico';
    }
    if (strpos($second_request, 'SMS')!==false){
        $_vbv = 'SMS '.explode(',', explode('receberá no celular ', $second_request)[1])[0];
    }
    $end_time = microtime(true);
    $execution_time = intval($end_time - $start_time); 
    exit('LIVE;'.$_vbv);
}
exit('NÃO IDENTIFICADO');

