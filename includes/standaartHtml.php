<?php

function beginHtml() {
  global $config;
  echo "<!DOCTYPE html>"
      . "<html>"
        . "<head>"
          . "<meta charset='utf-8'>"
          . "<meta name='viewport' content='width=device-width, initial-scale=1'>"
          . "<title>" . $config['pagetitle'] . "</title>";
          if ($config['build'] == "site"){
            googleAnalytics();
            echo "<link rel='stylesheet' href='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>"
            . "<!-- jQuery library -->"
            . "<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js'></script>"
            . "<!-- Latest compiled JavaScript -->"
            . "<script src='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js'></script>"
            . "<script src='//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js'></script>"
            . "<link rel='stylesheet' href='//blueimp.github.io/Gallery/css/blueimp-gallery.min.css'>";
          }
          elseif($config['build'] == "localhost"){
            echo "<link rel='stylesheet' href='css/bootstrap.min.css'>"
            . "<!-- jQuery library -->"
            . "<script src='js/jquery.min.js'></script>"
            . "<!-- Latest compiled JavaScript -->"
            . "<script src='js/bootstrap.min.js'></script>"
            . "<script src='js/jquery.blueimp-gallery.min.js'></script>"
            . "<link rel='stylesheet' href='css/blueimp-gallery.min.css'>";
          }
       echo "<script src='imageGalery/js/bootstrap-image-gallery.min.js'></script>"
          . "<link rel='stylesheet' href='imageGalery/css/bootstrap-image-gallery.min.css'>"
          . "<link rel='stylesheet' type='text/css' href='css/style.css'>"
        . "</head>"
        . "<body>"
          . "<div class='container-fluid'>";
}

function menu($actief) {
  echo "<nav class='navbar navbar-default'>"
      . "<div class='navbar-header'>"
        . "<ul class='nav nav-pills'>";
      // standaard 
      standaardMenu($actief);
      // kijken of iemand is ingelogd
      if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
        // ook nog kijken of het een admin is
        if (isset($_SESSION['rechten']) && $_SESSION['rechten'] == 1) {
          adminMenu($actief);
        }
        logedInMenu($actief);
      }else{
        offlineUser($actief);
      }
      echo "</ul>";
      echo "</div>";
      if (!isset($_SESSION['login']) || $_SESSION['login'] == false) {
        loginForm();
      }
  echo "</nav>";
}
function standaardMenu($actief){
  $class = "";
  if ($actief=="home"){
    $class="active";
  }
  echo "<li class='$class'>"
        . "<a href ='?action=home'>Home</a>"
    . "</li>";
  $class = "";
  if ($actief=="nieuws" && $actief=="showNieuwsDetail"){
    $class="active";
  }
  echo "<li class='$class'>"
        . "<a href ='?action=nieuws'>Nieuws</a>"
    . "</li>";
  $class = "";
  if ($actief=="showAdvertentie" && $actief=="showAdvertentieDetail"){
    $class="active";
  }
  echo "<li class='$class'>"
        . "<a href ='?action=showAdvertentie'>Advertenties tonen</a>"
    . "</li>";
  $class = "";
  if ($actief=="showStichting"){
    $class="active";
  }
  echo "<li class='$class'>"
        . "<a href ='?action=showStichting'>Goeden doelen</a>"
    . "</li>";
  $class = "";
}
/**
 * specifiek menu voor de admin wat hij wel mag zien
 */
function adminMenu($actief){
  $class = "";
  $class1 = "";
  $class2 = "";
  $class3 = "";
  if ($actief=="addAdvertentie"){
    $class1="active";
    $class="active";
  }
  if ($actief=="editAdvertentie"){
    $class2="active";
    $class="active";
  }
  if ($actief=="deleteAdvertentie"){
    $class3="active";
    $class="active";
  }
  echo "<li class='dropdown $class'>"
      . "<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>Advertentie Admin <span class='caret'></span></a>"
        . "<ul class='dropdown-menu'>"
          . "<li class='$class1'><a href ='?action=addAdvertentie'>Nieuwe Advertentie</a></li>"
          . "<li class='$class2'><a href ='?action=editAdvertentie'>Advertentie Aanpassen</a></li>"
          . "<li class='$class3'><a href ='?action=deleteAdvertentie'>Advertentie Verwijderen</a></li>"
        . "</ul>"
      . "</li>";
  $class = "";
  $class1 = "";
  $class2 = "";
  $class3 = "";
  if ($actief=="addNieuws"){
    $class1="active";
    $class="active";
  }
  if ($actief=="editNieuws"){
    $class2="active";
    $class="active";
  }
  if ($actief=="deleteNieuws"){
    $class3="active";
    $class="active";
  }
  echo "<li class='dropdown $class'>"
      . "<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>Nieuws Admin <span class='caret'></span></a>"
        . "<ul class='dropdown-menu'>"
          . "<li class='$class1'><a href ='?action=addNieuws'>Nieuwe Nieuwsbericht</a></li>"
          . "<li class='$class2'><a href ='?action=editNieuws'>Nieuws Aanpassen</a></li>"
          . "<li class='$class3'><a href ='?action=deleteNieuws'>Nieuws Verwijderen</a></li>"
        . "</ul>"
      . "</li>";
  $class = "";
  $class1 = "";
  $class2 = "";
  $class3 = "";
  if ($actief=="addSponsor"){
    $class1="active";
    $class="active";
  }
  if ($actief=="editSponsor"){
    $class2="active";
    $class="active";
  }
  if ($actief=="deleteSponsor"){
    $class3="active";
    $class="active";
  }
  echo "<li class='dropdown $class'>"
      . "<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>Sponsor Admin <span class='caret'></span></a>"
        . "<ul class='dropdown-menu'>"
          . "<li class='$class1'><a href ='?action=addSponsor'>Nieuwe Sponsor</a></li>"
          . "<li class='$class2'><a href ='?action=editSponsor'>Sponsor Aanpassen</a></li>"
          . "<li class='$class3'><a href ='?action=deleteSponsor'>Sponsor Verwijderen</a></li>"
        . "</ul>"
      . "</li>";
}
/**
 * specifiek menu voor alle ingelogde gebruikers
 */
function logedInMenu($actief){
  $class = "";
  if ($actief=="editProfiel"){
    $class="active";
  }
  echo "<li class='$class'>"
        . "<a href ='?action=editProfiel'>Profiel aanpassen</a>"
    . "</li>";
  $class="";
  if ($actief=="loguit"){
    $class="active";
  }
  echo "<li class='$class'>"
        . "<a href ='?action=loguit'>Uitloggen</a>"
    . "</li>";
}
/**
 * specifiek menu voor alle niet ingelogde gebruikers
 */
function offlineUser($actief){
  $class = "";
  if ($actief=="registreren"){
    $class="active";
  }
  echo "<li class='$class'>"
        . "<a href ='?action=registreren'>Aanmelden</a>"
    . "</li>";
}
function htmlAfterMenu(){
    echo "<div class='container'>";
}

function htmlEndDiv(){
    echo "</div>";
}

function homePageHtml() {
  echo "
        <img class='img-thumbnail center-block' src='images/groepsfoto.jpg'>
        <div class='text'>
          <p>Hallo allemaal, </p>
          <p>Wij zijn 22 studenten van het ROC Menso Alting. Wij doen dit jaar mee aan het horizonjaar. Dit is een jaar waarin je jezelf meer leert te ontwikkelen en je voorbereidt op het uiteindelijke doel: 3 maanden naar Zuid-Afrika! Er is veel geld nodig om deze reis te realiseren dus zullen wij veel acties houden. Hiervoor hebben we deze website in elkaar gezet, hier kunt u bieden op allerlei leuke producten. Ook kunnen jullie hier nieuws volgen over het horizonjaar</p>
          <p>Wij werken samen met de stichting C-A-N. CAN staat voor: Corelse Aid-s Network. Dit is een stichting die zich bezig houdt met ontwikkelingswerk en bouwt bruggen tussen Afrika en Europa dmv visie en bemoedinginsreizen; hoop en visie met elkaar te delen.</p>
          <p>Ook werken wij elke woensdag middag voor stichting present. Wij helpen deze dagen hulpbehoevende mensen in de buurt.</p>
          <p>Een groot deel van het geld gaat direct richting deze goede doelen.</p>
          <p>Tijdens de drie maanden in Zuid-Afrika leren wij ontzettend veel, zoals:</p>
          <p>- We maken kennis met de Afrikaanse cultuur;<br />
          - Je Engels gaat met sprongen vooruit;<br />
          - We leren om ons zelf te redden;<br />
          - Je wordt als persoon gevormd;<br />
          - We leren samenwerken met de groep en met de mensen van stichting C-A-N.</p>
          <p>Groeten van de Horizonners</p>
        </div>";
}

function googleAnalytics(){
  echo "<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-66639494-2', 'auto');
  ga('send', 'pageview');

</script>";
}

function eindeHtml() {
  echo    "</div>"
      . "</body>"
    . "</html>";
}

// TODO plaatje nog goed doen
// TODO miss nog toevoegen
function custHeader() {
  echo "<div class='navbar-header'>"
      . "<a class='navbar-brand' href='#'>"
      . "<img style='max-height: 20px'src='images/horizonjaar.jpg' alt=''>"
      . "</a>"
      . "</div>";
}

/**
 * class kan het volgende zijn: 
 * alert-success
 * alert-info
 * alert-warning
 * alert-danger
 * @param type $message
 * @param type $class
 */
function setMessage($message, $class = "alert-info") {
  echo "<div class='alert $class alert-dismissible' role='alert' >"
        . "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"
        . "$message"
      . "</div>";
}

function footer(){
  echo "<footer class='footer'>
          <a style='float:left' href='https://www.facebook.com/horizonjaar2015'><img src='https://cdn0.iconfinder.com/data/icons/social-flat-rounded-rects/512/facebook-64.png' /></a>
          <div class='container footerText'>
            <p>Contact: <img src='images/contact.PNG' /><p>
            <a href='?action=sponsors'><b>sponsors</b></a>
          </div>
        </footer>";
}

function showStichting(){
  echo "<div class='text row'>
          <div class='col-md-9'>
            <h3><a href ='http://stichtingpresent.nl/'>Stichting Pressent</a></h3>
            Present slaat een brug tussen mensen die iets te bieden en mensen die daarmee geholpen kunnen worden. Als makelaar in vrijwilligerswerk bieden wij de mogelijkheid voor vrijwilligers om zich in de eigen woonplaats in te zetten voor mensen die te maken hebben met armoede, een slechte gezondheid of een sociaal isolement. Voor 1 dagdeel af voor een langere tijd. Onze studenten zetten zich in als vrijwilliger, maar ook een deel van de opbrengst van de acties (waaronder deze actie) gaat naar stichting present.
          </div>
          <div class='col-md-3'>
            <br/>
            <img src='images/present.gif' width ='200' />
          </div>
          <div class='col-md-9'>
            <h3>Stichting C-A-N:</h3>
            De doelstelling van stichting C-A-N: een wederkerig opbouw en bemoediging van individuen en gemeenschappen in hun gehele door het faciliteren van ontwikkelingsprocessen zowel in plattelands als verstedelijkte gebieden door middel van een holistische benadering: mentaal, sociaal, fysiek en geestelijk. In plattelands gebieden met name in Sub Sahara Afrika en Oost Europa. In verstedelijkte gebieden met name in Afrika en Europa. Ook stichting C-A-N krijgt een deel van de opbrengst van de acties. Daarnaast gaan onze studenten volgend jaar gedurende 3 maanden zelf de handen uit de mouwen steken om op diverse locaties in Afrika deze stichting te helpen bij verschillende projecten.
          </div>
          <div class='col-md-3'>
            <br/><br/>
            <img src='images/can.jpg' />        
          </div>
        </div>";
  
}