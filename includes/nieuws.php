<?php
function showNieuws(){
  global $config;
  $sql = "SELECT id, titel, nieuwsBericht FROM nieuws ORDER BY id desc";
  $resultaat = mysqli_query($config['con'], $sql);
  while ($record = mysqli_fetch_assoc($resultaat)){
    echo "<div class='row'>";
    // foto ophalen
    $foto = "<img class = 'foto' title ='not found' src ='" . $config['img']['notfound'] . "'>";
    $resultaat2 = mysqli_query($config['con'], "SELECT path,titel, thumbPath FROM fototabel WHERE id= 'N" . $record['id'] . "' LIMIT 1");
    if (mysqli_num_rows($resultaat)>0){
      if ($record2 = mysqli_fetch_assoc($resultaat2)){
        $foto = "<img class = 'foto' src = '" . $record2['thumbPath'] . "' title = '" . $record2['titel'] . "' />";// $record2['bedrag'];
      }
    }
    // voor het plaatje
      echo "<a href='?action=showNieuwsDetail&id=" . $record['id'] . "'>";
        echo "<div class='col-md-4'>";
          echo $foto;
        echo "</div>";
        // voor de tekst
        echo "<div class='col-md-8 text'>";
          echo "<h3>" . $record['titel'] . "</h3>";
          $omschrijving = $record['nieuwsBericht'];
          if (strlen($omschrijving)>200){
            $omschrijving = substr($record['nieuwsBericht'],0,200)."...";
          }
          echo "<p class='lead'>" . $omschrijving . "</p>";
        echo "</div>";
      echo "</a>";
    echo "</div>";
    echo "<div><p></p></div>";
  }
}

function getNieuwsDetail($id){
  afbeeldingenGalerijHtml();
  global  $config;
  $id = mysqli_real_escape_string($config['con'], $id);
  if (!is_numeric($id)){
    echo"grapsjas geen letters doen he"; 
    return;}
    $sql="SELECT titel,nieuwsbericht FROM nieuws WHERE id = $id";
    //setMessage($sql);
  $resultaat = mysqli_query($config['con'], $sql);
  echo "<div>";
  if ($record = mysqli_fetch_assoc($resultaat)){
    // fotos ophalen
    $resultaat2 = mysqli_query($config['con'], "SELECT thumbPath, path,titel FROM fototabel WHERE id= 'N" . $id. "';");
    $i=0;
    $foto=array();
    while ($record2 = mysqli_fetch_assoc($resultaat2)){
      $foto[$i] = "<a href='" . $record2['path'] . "'  titel='" . $record2['titel'] . "' data-gallery><img class ='img-thumbnail fotoOverview' src = '" . $record2['thumbPath'] . "' title = '" . $record2['titel'] . "' /></a>";// $record2['bedrag'];
      $i++;
    }
    echo "<h1>".$record['titel']. "</h1>";
    if (count($foto)>0){
      echo "<div class='row'>";
        echo "<div class= 'col-md-8' id='links'>";
        foreach ($foto as $key => $value) {
          echo $value;
        }
        echo "</div>";
      echo "</div>";
    }
    echo "<div><p></p></div>";
    echo "<div class='row'>";
      echo "<div class='col-md-12 text'>"; 
        echo "<p class='lead'>".nl2br($record['nieuwsbericht']) . "</p>";
      echo "</div>";
    echo "</div>";
  }
  else{
    echo "Er is geen nieuwsbericht gevonden met dit id";
  }
  echo "</div>";
}

function nieuweNieuwsBericht(){
  handelNieuweNieuwsPost();
  formStart("horizonAdvertentie", "enctype='multipart/form-data'");
  formAdvertentieTitel();
  formAdvertentieOmschrijving();
  formAdvertentieAfbeelding();
  formEnd("submitNieuws");

}

function handelNieuweNieuwsPost(){
  global $config;
  if (isset($_POST['submitNieuws']) && !empty($_POST['submitNieuws'])){
    $titel =checkAdvertentieTitel(true);
    $omschrijving=checkAdvertentieOmschrijving(true);
    if ($titel!==false && $omschrijving!==false){
      $titel = mysqli_real_escape_string($config['con'], $titel);
      $omschrijving = mysqli_real_escape_string($config['con'], $omschrijving);
      $sql = "INSERT INTO nieuws (titel, nieuwsBericht) VALUES ('$titel', '$omschrijving');";
      mysqli_query($config['con'], $sql);
      if (empty(mysqli_error($config['con']))){
        $config['mysql']['last_add_id'] = mysqli_insert_id($config['con']);
        handelImages("N");
        setMessage("nieuwe Nieuwsbericht toegevoegd");
      }
      else{
        setMessage("Error Nieuwsbericht is niet toegevoegd", "alert-danger");
      }
    }
  }
}

function editNieuws(){
  global $config; 
  if (!checkEditNieuwsPost()){
    $resultaat = mysqli_query($config['con'], "SELECT id,titel FROM nieuws");
    echo "Hier kun je je nieuwsbericht wijzigen, selecteer hier onder een nieuwsbericht";
    echo "<form method='post'>";
      echo "<select name='idNieuws' class='form-control'>";
      while ($record = mysqli_fetch_assoc($resultaat)){
        echo "<option value='" . $record['id'] . "'>" . $record['titel'] . "</option>";
      }
      echo "</select><br/>";
      echo "<input type ='submit' class='btn' name='editNiews'>";
    echo "</form>";
  }
}

function checkEditNieuwsPost(){
  global $config;
  if (isset($_POST['editNiews']) && !empty($_POST['editNiews'])){
    $id = $_POST['idNieuws'];
    $id = mysqli_real_escape_string($config['con'], $id);
    $resultaat = mysqli_query($config['con'], "SELECT titel, nieuwsBericht FROM nieuws WHERE id = $id");
    if ($record = mysqli_fetch_assoc($resultaat)){
      formStart("");
      formAdvertentieTitel($record['titel']);
      formAdvertentieOmschrijving($record['nieuwsBericht']);
      echo "<input type='hidden' name='id' value='$id'>";
      formEnd("editNieuwsPost");
    }
    return true;
  }
  else{
    // kijken of het wijzigen is ingevuld
    if (isset($_POST['editNieuwsPost']) && !empty($_POST['editNieuwsPost'])){
      $titel = mysqli_real_escape_string($config['con'], $_POST['titel']);
      $omschrijving = mysqli_real_escape_string($config['con'], $_POST['omschrijving']);
      $id = mysqli_real_escape_string($config['con'], $_POST['id']);
      $sql = "UPDATE nieuws SET titel = '" . $titel . "', nieuwsBericht = '" . $omschrijving . "' WHERE id = " . $id;
      $resultaat = mysqli_query($config['con'], $sql);
      if (empty(mysqli_error($config['con']))){
        setMessage("Nieuwsbericht is Gewijzigd", "alert-success");
      }
      else{
        setMessage("Er is een fout op getreden","alert-danger");
      }
    }
    return false;
  }
}
function deleteNieuws(){
  global $config; 
  checkDeleteNieuwsPost(); 
  $resultaat = mysqli_query($config['con'], "SELECT id,titel FROM nieuws");
    echo "Hier kun je je een nieuwsbericht verwijderen, selecteer hier onder een nieuwsbericht";
    echo "<form method='post'>";
      echo "<select name='idDell' class='form-control'>";
      while ($record = mysqli_fetch_assoc($resultaat)){
        echo "<option value='" . $record['id'] . "'>" . $record['titel'] . "</option>";
      }
      echo "</select><br/>";
      echo "<input type ='submit' class='btn' name='deleteNieuws' value='Verwijderen'>";
    echo "</form>";
}

function checkDeleteNieuwsPost(){
  global $config;
  if (isset($_POST['deleteNieuws']) && !empty($_POST['deleteNieuws'])){
    $id = $_POST['idDell'];
    // deleten van add en foto verwijzingen en biedingen
    $id = mysqli_real_escape_string($config['con'], $id);
    $sql = "DELETE FROM nieuws WHERE id = $id";
    $resultaat = mysqli_query($config['con'], $sql);
    if (empty(mysqli_error($config['con']))){
      $sql = "SELECT path, thumbPath FROM fototabel WHERE id = 'N$id'";
      $resultaat = mysqli_query($config['con'], $sql);
      if (mysqli_num_rows($resultaat)>0){
        while ($record = mysqli_fetch_assoc($resultaat)){
          deleteImages($record['path']);
          deleteImages($record['thumbPath']);          
        } 
      }
      setMessage("Nieuwsbericht is verwijderd", "alert-success");
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

