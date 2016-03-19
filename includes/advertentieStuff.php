<?php
function getAdvertentieOverzicht($paging, $pagina=0){
  global  $config;
  $resultaat = mysqli_query($config['con'], "SELECT id,titel,omschrijving, richtprijs FROM advertentie ORDER BY id desc");
  while ($record = mysqli_fetch_assoc($resultaat))
  {
    echo "<div class='row'>";
    $bedrag="";
    $foto="";
    // bedrag ophalen
    $resultaat2 = mysqli_query($config['con'], "SELECT bedrag FROM biedtabel WHERE advertentieId=" . $record['id'] . " ORDER BY bedrag desc");
    if ($record2 = mysqli_fetch_assoc($resultaat2)){
      $bedrag = $record2['bedrag'];
    }
    // foto ophalen
    $foto = "<img class = 'foto' title ='not found' src ='" . $config['img']['notfound'] . "'>";
    $resultaat2 = mysqli_query($config['con'], "SELECT path,titel, thumbPath FROM fototabel WHERE id= 'A" . $record['id'] . "' LIMIT 1");
    if (mysqli_num_rows($resultaat2)){
      if ($record2 = mysqli_fetch_assoc($resultaat2)){
        $foto = "<img class = 'foto' src = '" . $record2['thumbPath'] . "' title = '" . $record2['titel'] . "' />";// $record2['bedrag'];
      }
    }
    // voor het plaatje
      echo "<a href='?action=showAdvertentieDetail&id=" . $record['id'] . "'>";
        echo "<div class='col-md-4'>";
          echo $foto;
        echo "</div>";
        // voor de tekst
        echo "<div class='col-md-8 text'>";
          echo "<h3>" . $record['titel'] . "</h3>";
          $omschrijving = $record['omschrijving'];
          if (strlen($omschrijving)>200){
            $omschrijving = substr($record['omschrijving'],0,200)."...";
          }
          echo "<p class='lead'>" . $omschrijving . "</p>";
          echo "<span class='addBedrag'>Richtprijs: &euro;" . $record['richtprijs'] . "</span>";
        echo "</div>";
      echo "</a>";
    echo "</div>";
    echo "<div><p></p></div>";
  }  
}

function nieuweAverventieHtml(){
    formStart("horizonAdvertentie", "enctype='multipart/form-data'");
    formAdvertentieTitel();
    formAdvertentieOmschrijving();
    formAdvertentieStartBedrag();
    formAdvertentieRichtPrijs();
    formAdvertentieBiedenVraag();
    formAdvertentieAfbeelding();
    formEnd("submitAdvertentie");
}

function handelAdvertentiePost(){
  global $config;
  if (isset($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH']>=$config['php']['post_max_size']){
    setMessage("Het formulier is te groot, dit komt door te veel foto's", "alert-danger");
  }
    if (isset($_POST['submitAdvertentie']) && !empty($_POST['submitAdvertentie'])){
        $titel =checkAdvertentieTitel(true);
        $omschrijving=checkAdvertentieOmschrijving(true);
        $startBedrag=checkAdvertentieStartBedrag(true);
        $biedVraag=checkAdvertentieBieden(true);
        $richtPrijs=checkAdvertentieRichtprijs(true);
        if ($titel!==false && $omschrijving!==false && $startBedrag!==false && $biedVraag!==false && $richtPrijs!==false){
          addAdvertentieToevoegen($titel, $omschrijving, $startBedrag, $biedVraag, $richtPrijs);
          handelImages("A");
        }
    }
}

function addAdvertentieToevoegen($titel, $omschrijving, $startBedrag, $biedVraag, $richtPrijs){
    global $config;
    $startBedrag = mysqli_real_escape_string($config['con'], $startBedrag);
    $richtPrijs = mysqli_real_escape_string($config['con'], $richtPrijs);
    $biedVraag = mysqli_real_escape_string($config['con'], $biedVraag);
    $titel = mysqli_real_escape_string($config['con'], $titel);
    $omschrijving = mysqli_real_escape_string($config['con'], $omschrijving);
    $sql = "INSERT INTO advertentie (titel, omschrijving, bieden, richtprijs) VALUES ('$titel', '$omschrijving', $biedVraag, $richtPrijs);";
    mysqli_query($config['con'], $sql);
    setMessage($sql);
    if (empty(mysqli_error($config['con']))){
      $config['mysql']['last_add_id'] = mysqli_insert_id($config['con']);
      $sql = "INSERT INTO biedtabel (advertentieId, gebruikersId, bedrag) VALUES (" . $config['mysql']['last_add_id'] . ", -1 , $startBedrag);";
      mysqli_query($config['con'], $sql);
      if (empty(mysqli_error($config['con']))){
        setMessage("Advertentie is toegevoegd", "alert-success");
      }
      else{
        setMessage("Er is een fout op getreden","alert-danger");
      }
    }
    else{
      setMessage("Er is een fout op getreden","alert-danger");
    }
}

function formAdvertentieAfbeelding(){
  echo "<div class='form-group'>"
          . "<label for='file'>Afbeeldingen:</label>"
          . "<input class='form-control' type='file' id='file' name='files[]' multiple='multiple' accept='image/*' />"
        . "</div>";  
}

function formAdvertentieTitel($titel =""){
    if (isset($_POST['titel']) && !empty($_POST['titel'])){
        $titel= $_POST['titel'];
    }
    echo "<div class='form-group'>"
          . "<label for='titel'>Titel:</label>"
          . "<input class='form-control' id='titel' name='titel' value='$titel'/>"
        . "</div>";  
}

function formAdvertentieOmschrijving($omschrijving=""){
    if (isset($_POST['omschrijving']) && !empty($_POST['omschrijving'])){
        $omschrijving= $_POST['omschrijving'];
    }
     echo "<div class='form-group'>"
          . "<label for='omschrijving'>Omschrijving:</label>"
          . "<textarea class='form-control' id='omschrijving' name='omschrijving' rows='4' cols='50' >"
            . "$omschrijving"
          . "</textarea>" 
        . "</div>";  
}

function formAdvertentieStartBedrag(){
    $startBedrag="";
    if (isset($_POST['startBedrag']) && !empty($_POST['startBedrag'])){
        $startBedrag= $_POST['startBedrag'];
    }
    echo "<div class='form-group'>"
          . "<label for='startBedrag'>Start bedrag:</label>"
          . "<input class='form-control' id='startBedrag' name='startBedrag' value='$startBedrag'/>"
        . "</div>"; 
}

function formAdvertentieRichtPrijs($richtPrijs=""){
    if (isset($_POST['richtPrijs']) && !empty($_POST['richtPrijs'])){
        $richtPrijs= $_POST['richtPrijs'];
    }
    echo "<div class='form-group'>"
          . "<label for='startBedrag'>Richt prijs:</label>"
          . "<input class='form-control' id='richtPrijs' name='richtPrijs' value='$richtPrijs'/>"
        . "</div>"; 
}

function formAdvertentieBiedenVraag(){
    $ja="";
    $nee="";
    if (isset($_POST['biedenVraag']) && !empty($_POST['biedenVraag'])){
        if ($_POST['biedenVraag'] == "ja"){
            $ja = "checked";
        }
        else{
            $nee = "checked";
        }
    }
    echo "<div class='form-group'>"
          . "<label for='biedenVraag'>Bieding toegestaan?</label>"
          . "<br/>Ja<input class='form-control' type='radio' id='biedenVraag' name='biedenVraag' value='ja' $ja /><br>"
          . "Nee<input class='form-control' type='radio' id= 'biedenVraag' name='biedenVraag' value='nee' $nee />"
        . "</div>"; 
}



function checkAdvertentieTitel($verplicht){
    if (isset($_POST['titel']) && !empty($_POST['titel'])){
        if (strlen($_POST['titel']) <=100){
            return $_POST['titel'];
        }
        else{
            setMessage("Titel is te lang", "alert-danger");
            return false; 
        }
    }elseif($verplicht){
        setMessage("Titel mag niet leeg zijn", "alert-danger");
        return false;
    }
    else{
        return "";
    }
}

function checkAdvertentieOmschrijving($verplicht){
    if (isset($_POST['omschrijving']) && !empty($_POST['omschrijving'])){
        if (strlen($_POST['omschrijving']) <=16384){
            return $_POST['omschrijving'];
        }
        else{
            setMessage("Omschrijving is te lang", "alert-danger");
            return false; 
        }
    }elseif($verplicht){
        setMessage("Omschrijving mag niet leeg zijn", "alert-danger");
        return false;
    }
    else{
        return "";
    }
}
function checkAdvertentieRichtprijs($verplicht){
  if (isset($_POST['richtPrijs']) && !empty($_POST['richtPrijs'])){
      if (strlen($_POST['richtPrijs']) <=13){
          $count = substr_count($_POST['richtPrijs'], '.');
          $count +=substr_count($_POST['richtPrijs'], ',');
          if ($count>=2){
              setMessage("Richtbedrag heeft te veel punten en comma's", "alert-danger");
              return false;
          }
          $_POST['richtPrijs'] = str_replace(",", ".", $_POST['richtPrijs']);
          if (is_numeric($_POST['richtPrijs'])){
            return $_POST['richtPrijs'];
          }
          else{
            setMessage("Dit is geen geldig bedrag", "alert-danger");
            return false; 
          }
      }
      else{
          setMessage("Richtbedrag is te groot", "alert-danger");
          return false; 
      }
  }elseif($verplicht){
      setMessage("Richtbedrag mag niet leeg zijn", "alert-danger");
      return false;
  }
  else{
      return "";
  }  
}

function checkAdvertentieStartBedrag($verplicht){
    if (isset($_POST['startBedrag']) && !empty($_POST['startBedrag'])){
        if (strlen($_POST['startBedrag']) <=13){
            $count = substr_count($_POST['startBedrag'], '.');
            $count +=substr_count($_POST['startBedrag'], ',');
            if ($count>=2){
                setMessage("Begin bedrag heeft te veel punten en comma's", "alert-danger");
                return false;
            }
            $_POST['startBedrag'] = str_replace(",", ".", $_POST['startBedrag']);
            if (is_numeric($_POST['startBedrag'])){
              return $_POST['startBedrag'];
            }
            else{
              setMessage("Dit is geen geldig bedrag", "alert-danger");
              return false; 
            }
        }
        else{
            setMessage("Start bedrag is te groot", "alert-danger");
            return false; 
        }
    }elseif($verplicht){
        setMessage("Start bedrag mag niet leeg zijn", "alert-danger");
        return false;
    }
    else{
        return "";
    }
}

function checkAdvertentieBieden($verplicht){
    if (isset($_POST['biedenVraag']) && !empty($_POST['biedenVraag'])){
        switch ($_POST['biedenVraag']){
            case "ja":
                return 1;
                break;
            case "nee":
                return 0;
                break;
            case "true":
                return 1;
                break;
            case "false":
                return 0;
                break;
            case "waar":
                return 1;
                break;
            case "nietwaar":
                return 0;
                break;
            case "1":
                return 1;
                break;
            case "0":
                return 0;
                break;
            case true:
                return 1;
                break;
            case false:
                return 0;
                break;
            default :
                setMessage("Onbekende opgave", "alert-danger");
                return false; 
        }
    }elseif($verplicht){
        setMessage("Bieden mag niet leeg zijn", "alert-danger");
        return false;
    }
    else{
        return "";
    }
}

function handelNieuweBiedPost(){
  global $config;
  if (isset($_SESSION['login']) && $_SESSION['login']==true){
    // afhandelen van de post als er nieuwe bied is
    if (isset($_POST['submitAddBieden']) && !empty($_POST['submitAddBieden'])){
      $bedrag = $_POST['biedenAdd'];
      if (is_numeric($bedrag)){
        $bedrag = str_replace(",", ".", $bedrag);
        $bedrag = number_format($bedrag, 2);
        // de duizend comma's weghalen
        $bedrag = str_replace(",", "", $bedrag);
        // ophalen van het laatste bedrag 
        // id ophalen via get
        if (isset($_GET['id']) && !empty($_GET['id'])){
          $id = $_GET['id'];
          $id = mysqli_real_escape_string($config['con'], $id);
          $resultaat = mysqli_query($config['con'], "SELECT bedrag, gebruikersId FROM biedtabel WHERE advertentieId=" . $id . " ORDER BY bedrag desc LIMIT 1");
          $oudGebruiker = "";
          $oudBedrag = "";
          if ($record = mysqli_fetch_assoc($resultaat)){
            $oudBedrag = $record['bedrag'];
            $oudGebruiker = $record['gebruikersId'];
          }
          if ($oudBedrag>=$bedrag){
            setMessage("Het geboden bedrag($bedrag) is niet hoger dan het vorige bod($oudBedrag) ", "alert-danger");
            return;
          }
          $bedrag = mysqli_real_escape_string($config['con'], $bedrag);
          $sql = "INSERT INTO biedtabel (advertentieid, gebruikersid, bedrag) VALUES ($id, " . $_SESSION['id'] . " , $bedrag);";
          mysqli_query($config['con'], $sql);
          setMessage("Je bod is opgeslagen het hoogste bod is $bedrag");
          // alleen sturen als de vorige gebruiker niet de init was
          if ($oudGebruiker!="-1"){
            // gebruikers gegevens ophalen
            $resultaat = mysqli_query($config['con'], "SELECT gebruikersnaam, email FROM gebruikers WHERE id=" . $oudGebruiker);
            $naam = "";
            $email = "";
            if ($record = mysqli_fetch_assoc($resultaat)){
              $naam = $record['gebruikersnaam'];
              $email = $record['email'];
            }
            // advertentie titel ophalen
            $resultaat = mysqli_query($config['con'], "SELECT titel FROM advertentie WHERE id=" . $id);
            $titel ="";
            if ($record = mysqli_fetch_assoc($resultaat)){
              $titel = $record['titel'];
            }
            mailVersturenOverbieden($email,$naam, $oudBedrag, $bedrag, $titel, $id);
          }
          // advertentie titel ophalen
          $resultaat = mysqli_query($config['con'], "SELECT titel FROM advertentie WHERE id=" . $id);
          $titel ="";
          if ($record = mysqli_fetch_assoc($resultaat)){
            $titel = $record['titel'];
          }
          // gebruikers gegevens ophalen
          $resultaat = mysqli_query($config['con'], "SELECT gebruikersnaam, email,Telefoonnummer FROM gebruikers WHERE id=" . $_SESSION['id']); 
          $naam = "";
          $email = "";
          $telefoon = "";
          if ($record = mysqli_fetch_assoc($resultaat)){
            $naam = $record['gebruikersnaam'];
            $email = $record['email'];
            $telefoon = $record['Telefoonnummer'];
          }
          mailVersturenAlsGeboden($titel, $id, $naam, $bedrag, $email,$telefoon);          
        }        
        else{
          setMessage("Er is geen geldig id ingevuld, niet met de pagina prutsen", "alert-danger");
          return;
        }
      }
      else{
        setMessage("$bedrag is geen geldig bedrag hoor", "alert-danger");
        return;
      }
    }
  }
  else{
    setMessage("Je bent niet ingelogd dus je mag niet bieden", "alert-warning");
  }
}

function laatsteAantalBieden(){
  global $config;
  if (isset($_GET['id']) && !empty($_GET['id'])){
    $id = $_GET['id'];
    $id = mysqli_real_escape_string($config['con'], $id);
    $resultaat = mysqli_query($config['con'], "SELECT bedrag, gebruikersid FROM biedtabel WHERE advertentieId=" . $id . " ORDER BY bedrag desc LIMIT 4");
    while ($record = mysqli_fetch_assoc($resultaat)){
      $bedrag = $record['bedrag'];
      $gebruiker = $record['gebruikersid'];
      // gebruikers gegevens ophalen 
      if ($gebruiker != "-1"){
        $resultaat2 = mysqli_query($config['con'], "SELECT gebruikersnaam FROM gebruikers WHERE id=" . $gebruiker);
        if ($record2 = mysqli_fetch_assoc($resultaat2)){
          echo $record2['gebruikersnaam']." &euro;". $bedrag. "</br>";
        }    
        else{
          setMessage("De gebruiker bestaat niet", "alert-danger");
        }
      }
      else{
        echo "Begin &euro;". $bedrag. "</br>";
      }
    }
  }
  else{
    setMessage("Er is geen geldig id ingevuld, niet met de pagina prutsen", "alert-danger");
    return;
  }
}

function getAdvertentieDetail($id){
  if (isset($_SESSION['login']) && $_SESSION['login']==true){
    handelNieuweBiedPost();
  }
  afbeeldingenGalerijHtml();
  global  $config;
  $id = mysqli_real_escape_string($config['con'], $id);
  if (!is_numeric($id)){
    echo"grapsjas geen letters doen he"; 
    return;}
  $resultaat = mysqli_query($config['con'], "SELECT titel,omschrijving,bieden, richtprijs FROM advertentie WHERE id = $id");
  echo "<div>";
  if ($record = mysqli_fetch_assoc($resultaat)){
    $bedrag="";
    $foto=array();
    // bedrag ophalen
    $resultaat2 = mysqli_query($config['con'], "SELECT bedrag FROM biedtabel WHERE advertentieId=" . $id . " ORDER BY bedrag desc LIMIT 1");
    if ($record2 = mysqli_fetch_assoc($resultaat2)){
      $bedrag = $record2['bedrag'];
    }
    // fotos ophalen
    $resultaat2 = mysqli_query($config['con'], "SELECT thumbPath, path,titel FROM fototabel WHERE id= 'A" . $id. "';");
    $i=0;
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
      echo "<div class='col-md-10 text'>"; 
        echo "<p class='lead'>".nl2br($record['omschrijving']) . "</p>";
      echo "</div>";
      echo "<div class='col-md-2'>"; 
      echo "<b>Richtprijs: &euro;" . $record['richtprijs'] . "</b><br/><br/>";
        echo "<b>Hoogste bedrag: &euro;" . $bedrag . "</b><br/><br/>";
        if($record['bieden']==true){
          if (isset($_SESSION['login']) && $_SESSION['login'] == true){
            ?>
            <form action="" method="post">
              <input type="text" class="form-control" name="biedenAdd">
              <input type ="submit" value="Bieden" class="btn btn-default" name="submitAddBieden">
            </form>
            <?php
          }
          else{
            echo "Je moet eerst inloggen om te bieden<br/>";
          }          
        }
        else{
          echo "Om het direct te kopen mail naar ". $config['mail']['kopen'];
        }
        laatsteAantalBieden();    
      echo "</div>";
    echo "</div>";
  }
  else{
    echo "Er is geen advertentie gevonden met dit id";
  }
  echo "</div>";
}

function editAdvertentie(){
  global $config; 
  if (!checkEditAddPost()){
    $resultaat = mysqli_query($config['con'], "SELECT id,titel FROM advertentie");
    echo "Hier kun je je advertenties wijzigen, selecteer hier onder een advertentie";
    echo "<form method='post'>";
      echo "<select name='idAdd' class='form-control'>";
      while ($record = mysqli_fetch_assoc($resultaat)){
        echo "<option value='" . $record['id'] . "'>" . $record['titel'] . "</option>";
      }
      echo "</select><br/>";
      echo "<input type ='submit' class='btn' name='editAdd'>";
    echo "</form>";
  }
}

function checkEditAddPost(){
  global $config;
  if (isset($_POST['editAdd']) && !empty($_POST['editAdd'])){
    $id = $_POST['idAdd'];
    $id = mysqli_real_escape_string($config['con'], $id);
    $resultaat = mysqli_query($config['con'], "SELECT titel, omschrijving FROM advertentie WHERE id = $id");
    if ($record = mysqli_fetch_assoc($resultaat)){
      formStart("");
      formAdvertentieTitel($record['titel']);
      formAdvertentieOmschrijving($record['omschrijving']);
      echo "<input type='hidden' name='id' value='$id'>";
      formEnd("editAddPost");
    }
    return true;
  }
  else{
    // kijken of het wijzigen is ingevuld
    if (isset($_POST['editAddPost']) && !empty($_POST['editAddPost'])){
      $titel = mysqli_real_escape_string($config['con'], $_POST['titel']);
      $omschrijving  = mysqli_real_escape_string($config['con'], $_POST['omschrijving']);
      $id= mysqli_real_escape_string($config['con'], $_POST['id']);
      $sql = "UPDATE advertentie SET titel = '" . $titel . "', omschrijving = '" . $omschrijving . "' WHERE id = " . $id;
      $resultaat = mysqli_query($config['con'], $sql);
      if (empty(mysqli_error($config['con']))){
        setMessage("Advertentie is Gewijzigd", "alert-success");
      }
      else{
        setMessage("Er is een fout op getreden","alert-danger");
      }
    }
    return false;
  }
}

function deleteImages($path){
  if (file_exists($path)) {
      unlink($path); // Delete now
  } 
  // See if it exists again to be sure it was removed
  if (file_exists($path)) {
    setMessage("Problem deleting " . $path, "alert-danger");
  } else {
    setMessage("Successfully deleted " . $path);
  }
}

function checkDeleteAddPost(){
  global $config;
  if (isset($_POST['deleteAdd']) && !empty($_POST['deleteAdd'])){
    $id = $_POST['idDell'];
    $id = mysqli_real_escape_string($config['con'], $id);
    // deleten van add en foto verwijzingen en biedingen
    $sql = "DELETE FROM advertentie WHERE id = $id";
    $resultaat = mysqli_query($config['con'], $sql);
    if (empty(mysqli_error($config['con']))){
      $sql = "DELETE FROM biedtabel WHERE advertentieid = $id";
      $resultaat = mysqli_query($config['con'], $sql);
      if (empty(mysqli_error($config['con']))){
        $sql = "SELECT path, thumbPath FROM fototabel WHERE id = 'A$id'";
        $resultaat = mysqli_query($config['con'], $sql);
        if (mysqli_num_rows($resultaat)>0){
          while ($record = mysqli_fetch_assoc($resultaat)){
            deleteImages($record['path']);
            deleteImages($record['thumbPath']);          
          } 
        }
        $sql = "DELETE FROM fototabel WHERE id = 'A$id'";
        $resultaat = mysqli_query($config['con'], $sql);
        if (empty(mysqli_error($config['con']))){
          setMessage("Advertentie is verwijderd", "alert-success");
        }
        else{
          setMessage("Er is een fout op getreden","alert-danger");
        }
      }
      else{
        setMessage("Er is een fout op getreden","alert-danger");
      }
    }
    else{
      setMessage("Er is een fout op getreden","alert-danger");
    }
  }
}

function deleteAdvertentieHtml(){
  global $config; 
  checkDeleteAddPost(); 
  $resultaat = mysqli_query($config['con'], "SELECT id,titel FROM advertentie");
    echo "Hier kun je je advertenties verwijderen, selecteer hier onder een advertentie";
    echo "<form method='post'>";
      echo "<select name='idDell' class='form-control'>";
      while ($record = mysqli_fetch_assoc($resultaat)){
        echo "<option value='" . $record['id'] . "'>" . $record['titel'] . "</option>";
      }
      echo "</select><br/>";
      echo "<input type ='submit' class='btn' name='deleteAdd' value='Verwijderen'>";
    echo "</form>";
}