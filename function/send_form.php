<?php

require "connect.php";

require_once dirname(__FILE__)."/../class/ClassCrud.php";

$db = new CrudDb();

if ($_POST['idPeople'] == ''){

    $db->insertRegistry($pdo,'people');    

} else {

    $db->updateRegistry($pdo,'people');

} 

header("Location:".BASEURL);
