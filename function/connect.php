<?php

require_once dirname(__FILE__)."/../config/define.php";

$pdo = new PDO("mysql:host=".HOST.";dbname=".DBNAME,USER,PASS);
$pdo->exec("set names utf8");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
