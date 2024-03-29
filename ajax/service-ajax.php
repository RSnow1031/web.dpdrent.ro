<?php 
    require_once '../core/init.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $params = $_REQUEST;
        $params['data_preluare'] = $params['data_preluare'] . ' ' .$params['pickup_time'];
        $cURL = curl_init("https://app.dpdrent.ro/servicii/servicii-booking");
        curl_setopt($cURL, CURLOPT_POST, true);
        curl_setopt($cURL, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($cURL);
        curl_close($cURL);

        if ($response == 1)
        {
            header('Location: servicii.php');
            die();
        }

    }

?>