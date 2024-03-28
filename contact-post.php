<?php 
    require_once './core/init.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $params = $_REQUEST;

        $cURL = curl_init("https://dpdrent.ro/contact/process-message");
        curl_setopt($cURL, CURLOPT_POST, true);
        curl_setopt($cURL, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($cURL);
        curl_close($cURL);
    }
    
    header("Location: ../contact.php");
    exit();
?>