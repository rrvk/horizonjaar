<?php
ini_set("log_errors", 1);
ini_set("error_log", "log/error.log");   
session_start();
set_error_handler(function ($errno, $errstr, $errfile, $errline){onError($errno, $errstr, $errfile, $errline);});
function onError($errno, $errstr, $errfile, $errline){
  error_log($errno." ".$errstr." ".$errfile." ".$errline);
  echo "";
}
//error_reporting(E_ALL);

// alle pagina's die nodig zijn includen
include 'includes/config.php';
include 'includes/otherFunctions.php';
include 'includes/nieuws.php';
include 'includes/sponsors.php';
include 'includes/gebruikerstuff.php';
include 'includes/standaartHtml.php';
include 'includes/advertentieStuff.php';

// start database connection
databaseConnect();
beginHtml();
// eerst kijken of er ook word gevraagd of je uitgelogd wilt worden
if (isset($_GET['action']) && $_GET['action'] == "loguit" && !isset($_POST['inloggen'])) {
  loguit();
  setMessage("Je bent nu uitgelogd", "alert-success");

}
else {
  // niet ingelogd
  if (isset($_POST['inloggen'])) {
    if (isset($_POST['gebruikersnaam']) && isset($_POST['wachtwoord'])) {
      if (!inloggen($_POST['gebruikersnaam'], $_POST['wachtwoord'])) {
        setMessage("Gebruikers naam of wachtwoord is verkeerd", "alert-danger");
      }
      else {
        setMessage("Succesvol ingelogd", "alert-success");
      }
    }
  }
}
// kijken wat we met de gets aanmoeten
$action = "";
if (isset($_GET['action'])) {
  $action = $_GET['action'];
}
// menu balk opvragen
menu($action);
htmlAfterMenu();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
  // ingelogd
  if (isset($_SESSION['rechten']) && $_SESSION['rechten'] == 1) {
    // nog een paar mooie admin dingen
    switch ($action) {
      case "addAdvertentie":
        handelAdvertentiePost();
        nieuweAverventieHtml();
        break;
      case "editAdvertentie":
        editAdvertentie();
        break;
      case "deleteAdvertentie":
        deleteAdvertentieHtml();
        break;
      case "addNieuws":
        nieuweNieuwsBericht();
        break;
      case "editNieuws":
        editNieuws();
        break;
      case "deleteNieuws":
        deleteNieuws();
        break;
      case "addSponsor":
        addSponsors();
        break;
      case "editSponsor":
        editSponsors();
        break;
      case "deleteSponsor":
        deleteSponsors();
        break;
    }
  }
  switch ($action) {
    case "editProfiel":
      handelEditProfielPost();
      gebruikerWijzigenHtml("Je mag invoervelden leeg laten, deze worden niet behandeld");
      break;
    default :
      // todo misschien iets anders hiervoor want dit is niet echt heel mooi
      if ($action!= "addSponsor" && $action!= "showStichting" &&$action!= "editSponsor" &&$action!= "deleteSponsor" && $action !="registreren" && $action != "sponsors" && $action != "addAdvertentie" && $action != "showAdvertentie" && $action != "showAdvertentieDetail" && $action !="nieuws" && $action !="editAdvertentie" && $action !="deleteAdvertentie"&& $action !="addNieuws"&& $action !="editNieuws"&& $action !="deleteNieuws" && $action!="showNieuwsDetail") {
        homePageHtml();
      }
      break;
  }
}
// hier onder alle spul waar je geen rechten of wat dan ook voor nodig hebt
switch ($action) {
  case "sponsors":
    sponsors();
    break;
  case "showStichting":
    showStichting();
    break;
  case "nieuws":
    showNieuws();
    break;
  case "registreren":
    handelRegistrerenPost();
    gebruikerRegistrerenHtml("Hier kun je je gebruikers gegevens invullen");
    break;
  case "showAdvertentie":
    getAdvertentieOverzicht(true);
    break;
  case "showAdvertentieDetail":
    if (isset($_GET['id']) && !empty($_GET['id'])) {
      $id = $_GET['id'];
      getAdvertentieDetail($id);
    }
    break;
  case "showNieuwsDetail":
    if (isset($_GET['id']) && !empty($_GET['id'])) {
      $id = $_GET['id'];
      getNieuwsDetail($id);
    }
    break;
  default :
    if (!isset($_SESSION['login']) || $_SESSION['login'] != true) {
      homePageHtml();
    }
    break;
}
htmlEndDiv();
footer();
eindeHtml();
// database connection sluiten
databaseDisconnect();
?>