<?php
function inloggen($gebruikersnaam, $wachtwoord){
    global $config;
    if (!empty($gebruikersnaam) && !empty($wachtwoord)){
      $gebruikersnaam = mysqli_real_escape_string($config['con'], $gebruikersnaam);
        $sql = "SELECT id, rechten, wachtwoord FROM gebruikers WHERE gebruikersnaam = '$gebruikersnaam';";
        $resultaat = mysqli_query($config['con'],$sql);
        if ($record = mysqli_fetch_assoc($resultaat))
        {
            if (password_verify($wachtwoord, $record['wachtwoord'])) {
                $_SESSION['gebruikersNaam']=$gebruikersnaam;
                $_SESSION['id']=$record['id'];
                $_SESSION['login']=true;
                $_SESSION['rechten']=$record['rechten'];
                return true;
            } else {
                return false;
            }
        }
        else{
            return false;
        }
    }
    return false;
}

function loginForm(){
    echo  "<form id='loginForm' role='form' class='navbar-form navbar-right' method='post' action=''>"
          . "<div class='input-group'>"
            . "<span class='input-group-addon'><i class='glyphicon glyphicon-user'></i></span>"
            . "<input class='form-control' type='text' name='gebruikersnaam' id='gebruikersnaam' placeholder='Gebruikersnaam'>"
          . "</div>"
          . "<div class='input-group'>"
            . "<span class='input-group-addon'><i class='glyphicon glyphicon-lock'></i></span>"
            . "<input class='form-control' type='password' name='wachtwoord' id='wachtwoord' placeholder='Wachtwoord'>"
          . "</div>"
          . "<button type='submit' id='inloggen' name='inloggen' class='btn btn-primary'>Login</button>"
        . "</form>";
}

function loguit(){
    $_SESSION['gebruikersNaam']="";
    $_SESSION['login']="";
    $_SESSION['id']="";
    $_SESSION['rechten']="";
    session_destroy();
}

function gebruikerAanmaken($gebruiker, $wachtwoord, $telefoonnummer, $email){
    global $config;
    // kijken of gebruikers naam al bestaat
    $sql = "SELECT gebruikersnaam FROM gebruikers WHERE gebruikersnaam = '$gebruiker';";
    $gebruiker = mysqli_real_escape_string($config['con'], $gebruiker);
    $wachtwoord = mysqli_real_escape_string($config['con'], $wachtwoord);
    $telefoonnummer = mysqli_real_escape_string($config['con'], $telefoonnummer);
    $email = mysqli_real_escape_string($config['con'], $email);
    $resultaat = mysqli_query($config['con'],$sql);
    if (mysqli_num_rows($resultaat)>0){
      setMessage("Gebruikers naam bestaat al", "alert-danger");
    }
    else{
        $wachtwoord = password_hash($wachtwoord, PASSWORD_BCRYPT, $config['encr']);
        $sql = "INSERT INTO gebruikers (gebruikersnaam, wachtwoord, telefoonnummer, email, rechten) VALUES ('$gebruiker', '$wachtwoord', '$telefoonnummer', '$email', 2);";
        mysqli_query($config['con'], $sql);
        if (empty(mysqli_error($config['con']))){
            setMessage("Gebruiker is toegevoegd", "alert-success");
        }
        else{
            setMessage("Er is een fout op getreden", "alert-danger");
        }
    }
}

/**
 * als een parameter leeg is word er niks mee gedaan. 
 * @global type $config
 * @param type $wachtwoord wachtwoord word in deze functie gehased
 * @param type $telefoonnummer
 * @param type $email
 * @param type $gebruiker
 * @return string
 */
function gebruikerWijzigen($wachtwoord, $telefoonnummer, $email, $gebruiker){
    global $config;
    $wachtwoord = mysqli_real_escape_string($config['con'], $wachtwoord);
    $telefoonnummer = mysqli_real_escape_string($config['con'], $telefoonnummer);
    $email = mysqli_real_escape_string($config['con'], $email);
    $gebruiker = mysqli_real_escape_string($config['con'], $gebruiker);
    if ($_SESSION['login'] === true){
        if (empty($gebruiker)){
            $changeSql="";
            // nu gaat het om een normale gebruiker die zijn gegevens wilt aanpassen
            if (!empty($wachtwoord)){
                // wachtwoord veranderen
                $wachtwoord = password_hash($wachtwoord, PASSWORD_BCRYPT, $config['encr']);
                $changeSql .= "wachtwoord = '$wachtwoord',";
            }
            if (!empty($telefoonnummer)){
                // telefoonnummer
                $changeSql .= "telefoonnummer = '$telefoonnummer',";
            }
            if (!empty($email)){
                // email veranderen
                $changeSql .= "email = '$email',";
            }
            if (!empty($changeSql)){
                $changeSql = substr($changeSql, 0, strlen($changeSql)-1);
                $sql = "UPDATE gebruikers SET $changeSql WHERE Gebruikersnaam = '" . $_SESSION['gebruikersNaam'] . "';";
                mysqli_query($config['con'], $sql);
                if (empty(mysqli_error($config['con']))){
                  setMessage("Gebruiker is gewijzigd", "alert-success");
                }
                else{
                  setMessage("Er is een fout op getreden", "alert-success");
                }
            }
        }
        else{
            // nu gaat het om een ander gebruikers account aan te passen, dus checken op admin
            if ($_SESSION['rechten'] ==  1){
                // TODO
            }
        }
    }
}

function handelEditProfielPost(){
    if (isset($_POST['submitProfiel']) && !empty($_POST['submitProfiel'])){
        $wachtwoord = checkFormOnderdeelWachtwoord(false);
        $telefoonnummer = checkFormOnderdeelTelefoon(false);
        $email = checkFormOnderdeelEmail(false);
        if ($wachtwoord!==false && $telefoonnummer!==false && $email!==false){
            gebruikerWijzigen($wachtwoord, $telefoonnummer, $email, null);
        }
    }
}

function handelRegistrerenPost(){
    if (isset($_POST['submitProfiel']) && !empty($_POST['submitProfiel'])){
        $gebruiker = checkFormOnderdeelGebruikersNaam();
        $wachtwoord = checkFormOnderdeelWachtwoord(true);
        $telefoonnummer = checkFormOnderdeelTelefoon(false);
        $email = checkFormOnderdeelEmail(true);
        if ($wachtwoord!==false && $telefoonnummer!==false && $email!==false&& $gebruiker!==false){
            gebruikerAanmaken($gebruiker, $wachtwoord, $telefoonnummer, $email);
        }
    }
}

function checkFormOnderdeelWachtwoord($verplicht){
    if (isset($_POST['wachtwoord']) && !empty($_POST['wachtwoord'])){
        if (isset($_POST['wachtwoordHer']) && !empty($_POST['wachtwoordHer'])){
            if ($_POST['wachtwoord'] == $_POST['wachtwoordHer']){
                return $_POST['wachtwoord'];
            }
            else{
                setMessage("Wachtwoorden moeten gelijk zijn!", "alert-danger");
                return false;
            }
        }
        else{
            setMessage("2e wachtwoord mag niet leeg zijn", "alert-danger");
            return false; 
        }
    }
    elseif ($verplicht==true){
        setMessage("Het wachtoord is leeg dit mag niet", "alert-danger");
        return false;
    }
    else{
        return "";
    }
}
function checkFormOnderdeelGebruikersNaam(){
    if (isset($_POST['gebruikersNaam']) && !empty($_POST['gebruikersNaam'])){
        if (strlen($_POST['gebruikersNaam']) <=50){
            return $_POST['gebruikersNaam'];
        }
        else{
            setMessage("Gebruikers naam is te lang", "alert-danger");
            return false; 
        }
    }else{
        setMessage("Gebruikers naam mag niet leeg zijn", "alert-danger");
        return false;
    }
}
function checkFormOnderdeelEmail($verplicht){
    if (isset($_POST['email']) && !empty($_POST['email'])){
        if (strlen($_POST['email']) <=50){
            if (strpos($_POST['email'],'@') !== false && strpos($_POST['email'],'.') !== false){
                return $_POST['email'];
            }
            else{
                setMessage("Dit is geen geldig email adres", "alert-danger");
                return false;
            }
        }
        else{
            setMessage("Email adres is te lang", "alert-danger");
            return false; 
        }
    }
    elseif($verplicht){
        setMessage("Email mag niet leeg zijn", "alert-danger");
        return false;
    }
    else{
        return "";
    }
}
function checkFormOnderdeelTelefoon($verplicht){
    if (isset($_POST['telefoonnummer']) && !empty($_POST['telefoonnummer'])){
        if (strlen($_POST['telefoonnummer']) <=12){
            return $_POST['telefoonnummer'];
        }
        else{
            setMessage("Telefoonnummer is te lang", "alert-danger");
            return false; 
        }
    }
    elseif($verplicht){
        setMessage("Telfoonnummer mag niet leeg zijn", "alert-danger");
        return false;
    }
    else{
        return "";
    }
}

/**
 * Met deze functie kun je de html voor het toevoegen/wijzigen 
 * @param type $message Dit is dan de tekst die voor de tabel nog word getoond
 */
function gebruikerWijzigenHtml($message){
    echo $message;
    formStart("");
    formGebruikerWachtwoord();
    formGebruikerEmail();
    formGebruikerTelefoonNummer();
    formEnd("submitProfiel");
    
}

function gebruikerRegistrerenHtml($message){
    echo $message;
    formStart("");
    formGebruikerGebruikersNaam();
    formGebruikerWachtwoord();
    formGebruikerEmail();
    formGebruikerTelefoonNummer();
    formEnd("submitProfiel");
    
}

function formStart($id, $other =""){
  echo "<form method='post' role='form' id='$id' $other>";
}

function formEnd($nameSubmit){
  echo "<button type='submit' class='btn btn-default' value='Opslaan' name='$nameSubmit'>Submit</button></form>";
}

function formGebruikerWachtwoord(){
    $wachtwoord1="";
    $wachtwoord2="";
    if (isset($_POST['wachtwoord']) && !empty($_POST['wachtwoord'])){
        $wachtwoord1= $_POST['wachtwoord'];
    }
    if (isset($_POST['wachtwoordHer']) && !empty($_POST['wachtwoordHer'])){
        $wachtwoord2= $_POST['wachtwoordHer'];
    }
    echo "<div class='form-group'>"
          . "<label for='password'>Wachtwoord:</label>"
          . "<input type='password' class='form-control' name='wachtwoord' id='password' value='$wachtwoord1'>"
        . "</div>";
    echo "<div class='form-group'>"
          . "<label for='password2'>Wachtwoord herhaling:</label>"
          . "<input type='password' class='form-control' name='wachtwoordHer' id='password2' value='$wachtwoord2'>"
        . "</div>";
}

function formGebruikerGebruikersNaam(){
    $gebruiker="";
    if (isset($_POST['gebruikersNaam']) && !empty($_POST['gebruikersNaam'])){
        $gebruiker= $_POST['gebruikersNaam'];
    }
    echo "<div class='form-group'>"
        . "<label for='gebruikersNaam'>Gebruikersnaam:</label>"
        . "<input type='text' class='form-control' name='gebruikersNaam' id='gebruikersNaam' value='$gebruiker'>"
      . "</div>";
}

function formGebruikerEmail(){
    $email="";
    if (isset($_POST['email']) && !empty($_POST['email'])){
        $email= $_POST['email'];
    }
    echo "<div class='form-group'>"
          . "<label for='email'>Email:</label>"
          . "<input type='email' class='form-control' name='email' id='email' value='$email'>"
        . "</div>";        
}

function formGebruikerTelefoonNummer(){
    $telefoon="";
    if (isset($_POST['telefoonnummer']) && !empty($_POST['telefoonnummer'])){
        $telefoon= $_POST['telefoonnummer'];
    }
    echo "<div class='form-group'>"
          . "<label for='email'>Telefoonnummer:</label>(eventueel)"
          . "<input type='text' class='form-control' name='telefoonnummer' id='telefoonnummer' value='$telefoon'>"
        . "</div>";  
}
?>