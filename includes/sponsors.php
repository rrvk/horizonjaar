<?php
function sponsors(){
  global $config;
  $sql = "SELECT id, naam, omschrijving,link FROM sponsors"; 
  $resultaat = mysqli_query($config['con'], $sql);
  while ($record = mysqli_fetch_assoc($resultaat)){
    echo "<div class='row'>";
    // foto ophalen
    $foto = "<img class = 'foto' title ='not found' src ='" . $config['img']['notfound'] . "'>";
    $resultaat2 = mysqli_query($config['con'], "SELECT path,titel, thumbPath FROM fototabel WHERE id= 'S" . $record['id'] . "' LIMIT 1");
    if (mysqli_num_rows($resultaat)>0){
      if ($record2 = mysqli_fetch_assoc($resultaat2)){
        $foto = "<a href='" . $record['link'] . "'><img class = 'foto' src = '" . $record2['thumbPath'] . "' title = '" . $record2['titel'] . "' /></a>";// $record2['bedrag'];
      }
    }
    echo "<div class='col-md-4'>";
      echo $foto;
    echo "</div>";
    echo "<a href='" . $record['link'] . "'>";
    echo "<div class='col-md-8 text'>";
      echo "<h3>" . $record['naam'] . "</h3>";
      $omschrijving = $record['omschrijving'];
      /*if (strlen($omschrijving)>200){
        $omschrijving = substr($record['omschrijving'],0,200)."...";
      }*/ 
      echo "<p class='lead'>" . $omschrijving . "</p>";
    echo "</div>";
    echo "</a>";
    echo "</div>";
    echo "<div><p></p></div>";
  }
}

function addSponsors(){
  handelNieuweSponsorPost();
  formStart("","enctype='multipart/form-data'");
  formAdvertentieTitel();
  formAdvertentieOmschrijving();
  formAdvertentieAfbeelding();
  formSponsorLink();
  formEnd("submitSponsor");
}

function formSponsorLink($link =""){
    if (isset($_POST['link']) && !empty($_POST['link'])){
        $link= $_POST['link'];
    }
    echo "<div class='form-group'>"
          . "<label for='titel'>Link:</label>"
          . "<input class='form-control' id='link' name='link' value='$link'/>"
        . "</div>";  
}

function checkSponsorLink($verplicht){
  if (isset($_POST['link']) && !empty($_POST['link'])){
        if (strlen($_POST['link']) <=300){
            return $_POST['link'];
        }
        else{
            setMessage("Link is te lang", "alert-danger");
            return false; 
        }
    }elseif($verplicht){
        setMessage("Link mag niet leeg zijn", "alert-danger");
        return false;
    }
    else{
        return "";
    }
}

function handelNieuweSponsorPost(){
  global $config;
  if (isset($_POST['submitSponsor']) && !empty($_POST['submitSponsor'])){
    $titel =checkAdvertentieTitel(true);
    $omschrijving=checkAdvertentieOmschrijving(false);
    $link=checkSponsorLink(false);
    if ($titel!==false && $omschrijving!==false){
      $titel = mysqli_real_escape_string($config['con'], $titel);
      $omschrijving = mysqli_real_escape_string($config['con'], $omschrijving);
      $link = mysqli_real_escape_string($config['con'], $link);
      $sql = "INSERT INTO sponsors (naam, omschrijving,link) VALUES ('$titel', '$omschrijving', '$link');";
      mysqli_query($config['con'], $sql);
      if (empty(mysqli_error($config['con']))){
        $config['mysql']['last_add_id'] = mysqli_insert_id($config['con']);
        handelImages("S");
        setMessage("nieuwe Sponsor toegevoegd");
      }
      else{
        setMessage("Error Sponsor is niet toegevoegd", "alert-danger");
      }
    }
  }
}

function editSponsors(){
  global $config; 
  if (!checkEditSponsorPost()){
    $resultaat = mysqli_query($config['con'], "SELECT id,naam FROM sponsors");
    echo "Hier kun je je sponsor wijzigen, selecteer hier onder een sponsor";
    echo "<form method='post'>";
      echo "<select name='idSponsor' class='form-control'>";
      while ($record = mysqli_fetch_assoc($resultaat)){
        echo "<option value='" . $record['id'] . "'>" . $record['naam'] . "</option>";
      }
      echo "</select><br/>";
      echo "<input type ='submit' class='btn' name='editSponsor'>";
    echo "</form>";
  }
}

function checkEditSponsorPost(){
  global $config;
  if (isset($_POST['editSponsor']) && !empty($_POST['editSponsor'])){
    $id = $_POST['idSponsor'];
    $id = mysqli_real_escape_string($config['con'], $id);
    $resultaat = mysqli_query($config['con'], "SELECT naam, omschrijving,link FROM sponsors WHERE id = $id");
    if ($record = mysqli_fetch_assoc($resultaat)){
      formStart("");
      formAdvertentieTitel($record['naam']);
      formAdvertentieOmschrijving($record['omschrijving']);
      formSponsorLink($record['link']);
      echo "<input type='hidden' name='id' value='$id'>";
      formEnd("editSponsorPost");
    }
    return true;
  }
  else{
    // kijken of het wijzigen is ingevuld
    if (isset($_POST['editSponsorPost']) && !empty($_POST['editSponsorPost'])){
      $titel = mysqli_real_escape_string($config['con'], $_POST['titel']);
      $omschrijving = mysqli_real_escape_string($config['con'], $_POST['omschrijving']);
      $link = mysqli_real_escape_string($config['con'], $_POST['link']);
      $id = mysqli_real_escape_string($config['con'], $_POST['id']);
      $sql = "UPDATE sponsors SET naam = '" . $titel . "', omschrijving = '" . $omschrijving . "', link='" . $link . "' WHERE id = " . $id;
      $resultaat = mysqli_query($config['con'], $sql);
      if (empty(mysqli_error($config['con']))){
        setMessage("Sponsor is Gewijzigd", "alert-success");
      }
      else{
        setMessage("Er is een fout op getreden","alert-danger");
      }
    }
    return false;
  }
}

function deleteSponsors(){
  global $config; 
  checkDeleteSponsorPost(); 
  $resultaat = mysqli_query($config['con'], "SELECT id,naam FROM sponsors");
    echo "Hier kun je je een nieuwsbericht verwijderen, selecteer hier onder een nieuwsbericht";
    echo "<form method='post'>";
      echo "<select name='idDell' class='form-control'>";
      while ($record = mysqli_fetch_assoc($resultaat)){
        echo "<option value='" . $record['id'] . "'>" . $record['naam'] . "</option>";
      }
      echo "</select><br/>";
      echo "<input type ='submit' class='btn' name='deleteSponsor' value='Verwijderen'>";
    echo "</form>";
}

function checkDeleteSponsorPost(){
  global $config;
  if (isset($_POST['deleteSponsor']) && !empty($_POST['deleteSponsor'])){
    $id = $_POST['idDell'];
    $id = mysqli_real_escape_string($config['con'], $id);
    // deleten van add en foto verwijzingen en biedingen
    $sql = "DELETE FROM sponsors WHERE id = $id";
    $resultaat = mysqli_query($config['con'], $sql);
    if (empty(mysqli_error($config['con']))){
      $sql = "SELECT path, thumbPath FROM fototabel WHERE id = 'S$id'";
      $resultaat = mysqli_query($config['con'], $sql);
      if (mysqli_num_rows($resultaat)>0){
        while ($record = mysqli_fetch_assoc($resultaat)){
          deleteImages($record['path']);
          deleteImages($record['thumbPath']);          
        } 
      }
      setMessage("Sponsor is verwijderd", "alert-success");
    }
    else{
      setMessage("Er is een fout op getreden","alert-danger");
    }
  }
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

