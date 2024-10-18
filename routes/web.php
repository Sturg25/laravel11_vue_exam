<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'index');


Route::view('/{pathMatch}','index')->where('pathMatch', '.*');



