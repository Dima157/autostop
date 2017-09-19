<?php
require_once 'application/autoload.php';
require 'vendor/autoload.php';
session_start();
//echo $_SESSION['id'];
$res = DB::PDO();
Route::Run();
