<?php
ini_set("log_errors", 1);
ini_set("error_log", "log/error.log");
set_error_handler(function ($errno, $errstr, $errfile, $errline){onError($errno, $errstr, $errfile, $errline);});
function onError($errno, $errstr, $errfile, $errline){
  error_log($errno." ".$errstr." ".$errfile." ".$errline);
  echo ""; 
}
//error_reporting(0);
$a = $_GET['a'];
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

