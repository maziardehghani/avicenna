<?php


define('BASEPATH',__DIR__ ."/../");

include BASEPATH . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(BASEPATH);
$dotenv->load();

$request = new \App\Core\Requests();


include "helpers/helpers.php";
include "routes/web.php";
