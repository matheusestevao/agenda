<?php

require "connect.php";
include "../class/ValidateSystem.php";

$val = new ValidateSystem();

if (isset($_POST['zip'])) {

    $zip = $_POST['zip'];

    $dateZip = $val->searchZip($zip);

    echo json_encode($dateZip);
    exit;
} else {

    $email = isset($_POST['email']) ? $_POST['email'] : '';

    $dateEmail = $val->validateEmail($pdo,$email);

    echo json_encode($dateEmail);
    exit;
}

?>