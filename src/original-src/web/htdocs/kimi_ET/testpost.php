<?php

function httpPost($purl, $pdata)
{
    $curl = curl_init($purl);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($pdata));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	

    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}


$myurl = './setticketcallinfo2.php';
$data = array('key1' => 'value1', 'key2' => 'value2');

$JsonData = json_encode($data, JSON_UNESCAPED_UNICODE);
// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'  => "Content-type: application/json\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);

//$result = httpPost($myurl, $data);

    $curl = curl_init($url);
	//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	//curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($curl);
    curl_close($curl);
//var_dump($response);

//$context  = stream_context_create($options);
//var_dump($options);
//$result = file_get_contents($url, false, $context);
//if ($result === FALSE) { /* Handle error */ }

var_dump($result);

?>