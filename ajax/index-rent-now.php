<?php 
    require_once '../core/init.php';
    require_once '../classes/session.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $carID = $_POST['id'];
        Session::put('carID', $carID);
    }
    echo 1;
?>