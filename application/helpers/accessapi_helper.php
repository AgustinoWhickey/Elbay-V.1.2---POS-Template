<?php

function api_data_post($url, $params){

    $data_string = json_encode($params);

    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");

    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_string))
    );

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string); 

    $result = curl_exec($curl);

    curl_close($curl);

    echo $result;
 }

 function api_data_get($url){

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $url,
        CURLOPT_USERAGENT => 'Elbay API Request'
    ));

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
 }

 function is_logged_in()
 {
    $ci = get_instance();
    if(!$ci->session->userdata('email')){
       redirect('auth');
   } 
 }