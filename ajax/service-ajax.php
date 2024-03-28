<?php 
    require_once '../core/init.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $message = $_POST['message'];

    }

    echo 1;
?>