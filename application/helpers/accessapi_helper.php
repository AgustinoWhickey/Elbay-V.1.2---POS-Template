<?php

function send_api($url, $params)
 {
    $postData = '';
    foreach($params as $k => $v) 
    { 
      $postData .= $k . '='.$v.'&'; 
    }
    rtrim($postData, '&');

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, false); 
    curl_setopt($ch, CURLOPT_POST, count($postData));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    

    $result=curl_exec($ch);

    curl_close($ch);

    return $result;
 }