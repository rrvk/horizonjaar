<?php
$config['build'] = "site";
$config['mail']['kopen'] = "williamvk@live.nl";
$config['img']['thumb']['path'] = "images/thumbs/";
$config['img']['thumb']['size'] = 200;
$config['img']['path'] = "images/fullsized/";
$config['img']['notfound'] = "images/no-image-found.jpg";
    
if ($config['build'] == "localhost"){
    // voor localhost
    $config['mysql']['hostname'] = "localhost";
    $config['mysql']['username'] = "root";
    $config['mysql']['password'] = "";
    $config['mysql']['database'] = "horizonsite";
    $config['url'] = "http://localhost/horizonsite/";
}
elseif($config['build']=="site"){
    // voor online
    $config['mysql']['hostname'] = "localhost";
    $config['mysql']['username'] = "roberul109_hor";
    $config['mysql']['password'] = "roberul109_";
    $config['mysql']['database'] = "roberul109_hor";
    $config['url'] = "http://horizonjaar.eu/";
}
$config['php']['post_max_size'] = 30*1024*1024;
$config['mysql']['last_add_id'] = 0;
  
$config['pagetitle'] = "Horizon Site"; // titel van het systeem
$config['defaultaction'] = "home";

$config['con'] ="";
$config['encr']= [
        'cost' => 12,
    ];

function databaseConnect(){
    global $config;
    $config['con'] = mysqli_connect( 
    $config['mysql']['hostname'],
    $config['mysql']['username'],
    $config['mysql']['password'],
    $config['mysql']['database']);			
}

function databaseDisconnect() {
    global $config;
    mysqli_close($config['con']);	
}
?>
