<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('/cara-bermain', 'rules')->name('rules');
Route::view('/main', 'game')->name('game');
Route::view('/surat', 'decrypt')->name('surat');