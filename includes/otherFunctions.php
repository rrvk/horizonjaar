<?php

function afbeeldingenGalerijHtml(){
  echo "<!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
        <div id='blueimp-gallery' class='blueimp-gallery'>
        <!-- The container for the modal slides -->
        <div class='slides'></div>
        <!-- Controls for the borderless lightbox -->
        <h3 class='title'></h3>
        <a class='prev'>‹</a>
        <a class='next'>›</a>
        <a class='close'>×</a>
        <a class='play-pause'></a>
        <ol class='indicator'></ol>
        <!-- The modal dialog, which will be used to wrap the lightbox content -->
        <div class='modal fade'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <button type='button' class='close' aria-hidden='true'>&times;</button>
                        <h4 class='modal-title'></h4>
                    </div>
                    <div class='modal-body next'></div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-default pull-left prev'>
                            <i class='glyphicon glyphicon-chevron-left'></i>
                            Previous
                        </button>
                        <button type='button' class='btn btn-primary next'>
                            Next
                            <i class='glyphicon glyphicon-chevron-right'></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>";
}

function createThumbnail($filename) {
  global $config;
  if(preg_match('/[.](jpg)$/', $filename) || preg_match('/[.](jpeg)$/', $filename)) {
    $im = imagecreatefromjpeg($config['img']['path'] .$filename);
  } else if (preg_match('/[.](gif)$/', $filename)) {
    $im = imagecreatefromgif($config['img']['path'] . $filename);
  } else if (preg_match('/[.](png)$/', $filename)) {
    $im = imagecreatefrompng($config['img']['path'] . $filename);
  }

  $ox = imagesx($im);
  $oy = imagesy($im);

  $nx = $config['img']['thumb']['size'];
  $ny = floor($oy * ($config['img']['thumb']['size'] / $ox));

  $nm = imagecreatetruecolor($nx, $ny);

  imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);

  if(!file_exists($config['img']['thumb']['path'])) {
    if(!mkdir($config['img']['thumb']['path'])) {
         die("There was a problem. Please try again!");
    } 
     }

  imagejpeg($nm, $config['img']['thumb']['path'] . $filename);
}

function handelImages($soort){
  global $config;
  $valid_formats = array("jpg", "png", "jpeg", "JPG");
  $count = 0;
  if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
    // Loop $_FILES to exeicute all files
    foreach ($_FILES['files']['name'] as $f => $name) {  
      if ($_FILES['files']['error'][$f] == 4) {
          continue; // Skip file if any error found
      }	       
      if ($_FILES['files']['error'][$f] == 0) {	           
        if(!in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
          setMessage("$name is not a valid format <br/>","alert-warning");
          continue; // Skip invalid file formats
        }
        else{ // No error found! Move uploaded files 
          if (!file_exists($config['img']['path'])) {
            mkdir($config['img']['path'], 0777, true);
          }
          // bekijken of het bestand al bestaat anders er een nummer bij op doen
          $ext = pathinfo($name, PATHINFO_EXTENSION);
          $fileName = $config['mysql']['last_add_id'].$count.$soort.".".$ext;
          $fileName = strtolower($fileName);
          $filePathImgFull = $config['img']['path'].$fileName;
          $filePathImgThumb = $config['img']['thumb']['path'].$fileName;
          while (file_exists($fileName)){
            $count++;
          }
          if(move_uploaded_file($_FILES["files"]["tmp_name"][$f], $filePathImgFull)){
            $sql = "INSERT INTO fototabel (id, path, thumbPath, titel) VALUES ('$soort" . $config['mysql']['last_add_id'] . "' , '" . $filePathImgFull . "', '$filePathImgThumb', '$name');";
            mysqli_query($config['con'], $sql);
            if (empty(mysqli_error($config['con']))){
              createThumbnail($fileName);
              $count++; // Number of successfully uploaded file
              setMessage("$name is geupload <br/>","alert-info");
            }
            else{
              setMessage("Foto is niet toegevoed er is een error", 'alert-danger');
            }
          }
        }
      }
    }
  }
}

function mailVersturenAlsGeboden($titel, $id, $naam, $bedrag, $email,$telefoon){
  $headers  = "Reply-To: Horizonjaar 2015 <info@horizonjaar.eu>\r\n"; 
  $headers .= "Return-Path: Horizonjaar 2015 <info@horizonjaar.eu>\r\n";
  $headers .= "From: Horizonjaar 2015 <info@horizonjaar.eu>\r\n"; 
  $headers .= "Organization: Horizonjaar 2015 \r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
  $headers .= "X-Priority: 3\r\n";
  $headers .= "X-Mailer: PHP". phpversion() ."\r\n" ;
  $text ="Hoi will, <br/>"
       . "<br/>"
       . "Er is een bod gepleegd op de volgende advertentie: <a href='http://horizonjaar.eu/?action=showAdvertentieDetail&id=$id'>$titel</a> <br/>"
       . "<br/>"
       . "Het bod is gedaan door: $naam</br>"
       . "Hij heeft &euro;$bedrag geboden</br>"
       . "email: $email</br>"
       . "telefoon: $telefoon</br>"
       . "<br/>"
       . "Doei, Robert";
  mail("williamvk@live.nl", "Er is een nieuw bod geplaatst", $text, $headers);
}

function mailVersturenOverbieden($to, $naam,  $oudBedrag, $nieuwBedrag, $titel, $id){
  $headers  = "Reply-To: Horizonjaar 2015 <info@horizonjaar.eu>\r\n"; 
  $headers .= "Return-Path: Horizonjaar 2015 <info@horizonjaar.eu>\r\n";
  $headers .= "From: Horizonjaar 2015 <info@horizonjaar.eu>\r\n"; 
  $headers .= "Organization: Horizonjaar 2015 \r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
  $headers .= "X-Priority: 3\r\n";
  $headers .= "X-Mailer: PHP". phpversion() ."\r\n" ;
  $text ="Beste $naam, <br/>"
       . "<br/>"
       . "Uw bod op advertentie: $titel is overboden <br/>"
       . "Uw had het volgende geboden &euro;$oudBedrag en het nieuwe bedrag is &euro;$nieuwBedrag <br/>"
       . "Als u weer wilt bieden kunt u dit <a href='http://horizonjaar.eu/?action=showAdvertentieDetail&id=$id'>hier</a> doen <br/>"
       . "<br/>"
       . "Met vriendelijke groeten, <br/>"
       . "Horizonjaar 2015";
  mail($to, "Er is een hogere bod geplaatst", $text, $headers);
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

