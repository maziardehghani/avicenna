<?php
use App\Core\Routing\Route;
use App\Middleware\Block;

Route::get('/',['HomeController','index'],[Block::class]);