<?php

function siteUrl($route)
{
    return $_ENV['APP_URL'] . $route;
}

function view($path,$data=[])
{
    extract($data);

    $path = str_replace(',','/',$path);

    include_once BASEPATH . 'views/' . $path . '.php';
}