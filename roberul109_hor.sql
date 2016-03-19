-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Host: 10.3.0.196
-- Generation Time: Mar 19, 2016 at 08:59 PM
-- Server version: 5.5.41-log
-- PHP Version: 5.5.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `roberul109_hor`
--

-- --------------------------------------------------------

--
-- Table structure for table `advertentie`
--

CREATE TABLE IF NOT EXISTS `advertentie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titel` varchar(100) NOT NULL,
  `omschrijving` text NOT NULL,
  `bieden` tinyint(1) NOT NULL DEFAULT '0',
  `richtprijs` double(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=69 ;

--
-- Dumping data for table `advertentie`
--

INSERT INTO `advertentie` (`id`, `titel`, `omschrijving`, `bieden`, `richtprijs`) VALUES
(23, 'Jyden fotolijsten Gold plated 24 krt ZGAN', 'Super mooie fotolijstjes\r\n24 krt goud!!\r\n\r\nKan ook verzonden worden!\r\nAfhalen in Groningen of Assen\r\nvoor vragen bel of mail me gerust ', 1, 20.00),
(24, '5 Schaaltjes ', '5 mooie schaaltjes met afbeeldingen van oude auto''s.\r\nVerzenden is mogelijk of afhalen in Groningen of Assen.\r\nVoor vragen bel of mail me gerust.', 1, 10.00),
(27, 'Wandbord Araceba ceramica', 'Heel mooi wandbord.\r\nGemaakt in ItaliÃ«.\r\nVerzending is mogelijk of af te halen in\r\nGroningen of Assen\r\nVoor vragen bel of mail me gerust.\r\n\r\n', 1, 30.00),
(28, 'Antiek dienblad', 'Mooi antiek dienblad gemaakt van metaal.\r\nVoorkant ziet er goed uit, alleen de achterkant is beschadigt.\r\nVerzending is mogelijk.\r\nOf af te halen in Groningen of Assen\r\nVoor vragen bel of mail me gerust ', 1, 10.00),
(29, 'Nieuw Horloge ', 'Mooi horloge van Basefield.\r\nGoede kwaliteit.\r\nVerzending mogelijk\r\nOf af te halen in Groningen of Assen.\r\nVoor vragen bel of mail me gerust.', 1, 15.00),
(30, '2 document mappen', '2 mooie document mappen.\r\nzo goed als nieuw.\r\n\r\nVerzending mogelijk\r\nOf op te halen in Groningen of Assen\r\nvoor vragen bel of mail me gerust ', 1, 5.00),
(31, '12 likeur / advocaat glazen', '12 likeur / advocaat glazen voor 10 euro\r\nde glazen zijn in goede staat\r\nkan verzonden worden \r\nOf op te halen in Assen of Groningen\r\nvoor vragen bel of mail me gerust ', 1, 10.00),
(34, 'Looplamp ', 'Een goed werkende looplamp met 10 Meter snoer \r\n\r\nkan verzonden worden \r\nOf op te halen in Assen of Groningen.\r\nVoor vragen bel of mail me gerust.', 1, 10.00),
(36, 'Van Gogh boek', 'Boek van ''Van Gogh''\r\nOp halen in Niekerk Groningen \r\nKan ook verzonden worden \r\n\r\nVoor vragen bel of mail me gerust ', 1, 5.00),
(37, '2 mooie jeugdboeken', 'Jeugdboeken:\r\n''Alleen op de wereld''\r\nen\r\n''De negerhut van oom Tom''\r\n\r\nophalen in Niekerk Groningen\r\nkan ook verzonden worden\r\nvoor vragen bel of mail me gerust ', 1, 10.00),
(39, 'antieke weegschaal V.I.W 300KG', 'Bascule (oude weegschaal) uit 1949\r\nInclusief 3 gewichten\r\nMAX gewicht 300 KG  \r\n\r\nophalen in Niekerk Groningen\r\nvoor vragen bel of mail me gerust ', 1, 40.00),
(45, 'Zgan dvd speler', 'Een zeer nette dvd speler.\r\n\r\nAf te halen in Niekerk Groningen of Assen\r\nVoor vragen bel of mail me gerust.', 1, 15.00),
(46, 'grote voetbaltafel ', 'Voetbaltafel is in goede staat:\r\nstevig model, de stangen zijn allemaal nog recht.\r\nlichte gebruiks sporen.\r\nOp te halen in Marum (Groningen)\r\nvoor vragen bel of mail me gerust ', 1, 40.00),
(50, 'laptoptas Nieuw ', 'Laptop tas\r\nNieuw.\r\n\r\nAf te halen in Niekerk, Groningen stad of Assen\r\nvoor vragen bel of mail me gerust.', 1, 10.00),
(51, 'boek + dvd 2de wereldoorlog ', 'Mooi boek over de oorlog dat zich in Europa heeft afgespeeld.\r\nAf te halen in Niekerk, Groningen stad of Assen\r\nvoor vragen bel of mail me gerust \r\n', 1, 5.00),
(52, 'verrekijker Vizzion Nieuw ', 'Een Nieuwe Vizzion verrekijker.\r\n8X21 DCF\r\n128M-1000M \r\n\r\nOphalen in Groningen of Assen.\r\nvoor vragen bel of mail me gerust ', 1, 15.00),
(55, 'Antieke Riemersma Kinderwagen ', 'Een mooie Riemersma kinderwagen.\r\nIs in goede staat met  kleine gebruikssporen.\r\nLengte: 95cm\r\nHoogte: 115 cm\r\nBreedte: 43cm\r\nAf te halen in Doezum', 1, 100.00),
(56, 'Mooie fotolijstjes ', 'mooie fotolijst\r\n\r\naf te halen in Doezum, Groningen of assen ', 1, 5.00),
(57, 'Antieke Reiswieg', 'Leuke antieke Reiswieg.\r\nVan ''De volharding''\r\n\r\nHoogte: 45 cm\r\nLengte: 75 cm\r\nBreedte: 35 cm\r\n\r\nAf te halen in Doezum', 1, 20.00),
(58, 'Oude eppos uit 1970', 'Groot aantal Eppo stripboeken.\r\nIn redelijke staat.\r\n\r\nAf te halen in Doezum of Groningen en Assen \r\nverzending mogelijk\r\n', 1, 10.00),
(59, 'Sierkussens', '2 leuke gestippelde sierkussens.\r\nMet de 3 kleuren bruin, wit en beige.\r\nZe zijn zo goed als nieuw maar hebben lichte gebruikssporen.\r\nDe hoes is afneembaar .\r\nDe maten: 55 x 55 cm\r\naf te halen in Assen Groningen \r\nverzending mogelijk', 1, 10.00),
(66, 'Document Koffer', 'Deze blauwe opbergkoffer voor documenten is lichtelijk beschadigd,\r\nMaar werkt nog uitstekend.\r\nAan de binnenkant is hij voorzien van een elastiek die je aan beide zijden kan verschuiven.\r\nDe koffer is eens gekocht om een laptop veilig  te kunnen verplaatsen.\r\nDe afmetingen\r\nLengte: 30 cm\r\nBreedte: 40 cm \r\nDiepte: 4cm\r\nAf te halen in Gasteren of Assen \r\nverzending mogelijk\r\nVoor vragen bel of mail gerust.', 1, 5.00);

-- --------------------------------------------------------

--
-- Table structure for table `biedtabel`
--

CREATE TABLE IF NOT EXISTS `biedtabel` (
  `advertentieId` int(11) NOT NULL,
  `gebruikersId` int(11) NOT NULL,
  `bedrag` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `biedtabel`
--

INSERT INTO `biedtabel` (`advertentieId`, `gebruikersId`, `bedrag`) VALUES
(23, -1, '15.00'),
(24, -1, '5.00'),
(27, -1, '10.00'),
(28, -1, '5.00'),
(29, -1, '10.00'),
(30, -1, '1.00'),
(31, -1, '5.00'),
(34, -1, '5.00'),
(36, -1, '2.00'),
(37, -1, '5.00'),
(39, -1, '20.00'),
(45, -1, '5.00'),
(46, -1, '30.00'),
(50, -1, '5.00'),
(51, -1, '2.00'),
(52, -1, '5.00'),
(55, -1, '70.00'),
(56, -1, '2.00'),
(57, -1, '10.00'),
(58, -1, '5.00'),
(59, -1, '6.00'),
(66, -1, '3.00');

-- --------------------------------------------------------

--
-- Table structure for table `fototabel`
--

CREATE TABLE IF NOT EXISTS `fototabel` (
  `id` varchar(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `thumbPath` varchar(255) NOT NULL,
  `titel` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fototabel`
--

INSERT INTO `fototabel` (`id`, `path`, `thumbPath`, `titel`) VALUES
('S1', 'images/fullsized/10S.png', 'images/thumbs/10S.png', 'logo.png'),
('S2', 'images/fullsized/20S.jpg', 'images/thumbs/20S.jpg', '10S.jpg'),
('A0', 'images/fullsized/00a.jpg', 'images/thumbs/00a.jpg', 'DSC_1180.JPG'),
('A0', 'images/fullsized/00a.jpg', 'images/thumbs/00a.jpg', 'DSC_1180.JPG'),
('A0', 'images/fullsized/00a.jpg', 'images/thumbs/00a.jpg', 'DSC_1180.JPG'),
('A0', 'images/fullsized/00a.jpg', 'images/thumbs/00a.jpg', '00a.jpg'),
('A23', 'images/fullsized/230a.jpg', 'images/thumbs/230a.jpg', 'DSC_1170.JPG'),
('A23', 'images/fullsized/231a.jpg', 'images/thumbs/231a.jpg', 'DSC_1172.JPG'),
('A24', 'images/fullsized/240a.jpg', 'images/thumbs/240a.jpg', 'DSC_1180.JPG'),
('A27', 'images/fullsized/270a.jpg', 'images/thumbs/270a.jpg', 'DSC_1185.JPG'),
('A27', 'images/fullsized/271a.jpg', 'images/thumbs/271a.jpg', 'DSC_1186.JPG'),
('A27', 'images/fullsized/272a.jpg', 'images/thumbs/272a.jpg', 'DSC_1187.JPG'),
('A28', 'images/fullsized/280a.jpg', 'images/thumbs/280a.jpg', 'DSC_1182.JPG'),
('A29', 'images/fullsized/290a.jpg', 'images/thumbs/290a.jpg', 'DSC_1188.JPG'),
('A29', 'images/fullsized/291a.jpg', 'images/thumbs/291a.jpg', 'DSC_1191 - kopie.JPG'),
('A30', 'images/fullsized/300a.jpg', 'images/thumbs/300a.jpg', 'DSC_1196.JPG'),
('A30', 'images/fullsized/301a.jpg', 'images/thumbs/301a.jpg', 'DSC_1197.JPG'),
('A31', 'images/fullsized/310a.jpg', 'images/thumbs/310a.jpg', 'DSC_1203.JPG'),
('A31', 'images/fullsized/311a.jpg', 'images/thumbs/311a.jpg', 'DSC_1204.JPG'),
('A31', 'images/fullsized/312a.jpg', 'images/thumbs/312a.jpg', 'DSC_1206.JPG'),
('A34', 'images/fullsized/340a.jpg', 'images/thumbs/340a.jpg', 'DSC_1223.JPG'),
('N3', 'images/fullsized/30n.png', 'images/thumbs/30n.png', 'Naamloos.png'),
('N4', 'images/fullsized/40n.png', 'images/thumbs/40n.png', 'hori logo.png'),
('A36', 'images/fullsized/360a.jpg', 'images/thumbs/360a.jpg', 'vangohg bkeo.jpg'),
('A36', 'images/fullsized/361a.jpg', 'images/thumbs/361a.jpg', 'xan xogh boek.jpg'),
('A37', 'images/fullsized/370a.jpg', 'images/thumbs/370a.jpg', 'jeugtboek1.jpg'),
('A37', 'images/fullsized/371a.jpg', 'images/thumbs/371a.jpg', 'jeugtboek2.jpg'),
('A37', 'images/fullsized/372a.jpg', 'images/thumbs/372a.jpg', 'k_85.JPG'),
('A39', 'images/fullsized/390a.jpg', 'images/thumbs/390a.jpg', 'waegschaal1.jpg'),
('A39', 'images/fullsized/391a.jpg', 'images/thumbs/391a.jpg', 'weegschaal 2.jpg'),
('A39', 'images/fullsized/392a.jpg', 'images/thumbs/392a.jpg', 'weegschaal.jpg'),
('A45', 'images/fullsized/450a.jpg', 'images/thumbs/450a.jpg', 'mp6.jpg'),
('A46', 'images/fullsized/460a.jpg', 'images/thumbs/460a.jpg', 'IMG-20151103-WA0004.jpg'),
('A46', 'images/fullsized/461a.jpg', 'images/thumbs/461a.jpg', 'IMG-20151103-WA0005.jpg'),
('A46', 'images/fullsized/462a.jpg', 'images/thumbs/462a.jpg', 'IMG-20151103-WA0006.jpg'),
('A46', 'images/fullsized/463a.jpg', 'images/thumbs/463a.jpg', 'IMG-20151103-WA0007.jpg'),
('A46', 'images/fullsized/464a.jpg', 'images/thumbs/464a.jpg', 'IMG-20151103-WA0008.jpg'),
('A50', 'images/fullsized/500a.jpg', 'images/thumbs/500a.jpg', 'mp.jpg'),
('A50', 'images/fullsized/501a.jpg', 'images/thumbs/501a.jpg', 'mp1.jpg'),
('A51', 'images/fullsized/510a.jpg', 'images/thumbs/510a.jpg', 'mp2.jpg'),
('A51', 'images/fullsized/511a.jpg', 'images/thumbs/511a.jpg', 'mp3.jpg'),
('A52', 'images/fullsized/520a.jpg', 'images/thumbs/520a.jpg', 'WP_20151110_004.jpg'),
('A52', 'images/fullsized/521a.jpg', 'images/thumbs/521a.jpg', 'WP_20151110_005.jpg'),
('A52', 'images/fullsized/522a.jpg', 'images/thumbs/522a.jpg', 'WP_20151110_006.jpg'),
('A52', 'images/fullsized/523a.jpg', 'images/thumbs/523a.jpg', 'WP_20151110_007.jpg'),
('A55', 'images/fullsized/550a.jpg', 'images/thumbs/550a.jpg', 'WP_20151113_11_27_09_Pro.jpg'),
('A55', 'images/fullsized/551a.jpg', 'images/thumbs/551a.jpg', 'WP_20151113_11_27_19_Pro.jpg'),
('A56', 'images/fullsized/560a.jpg', 'images/thumbs/560a.jpg', 'WP_20151113_11_34_21_Pro.jpg'),
('A57', 'images/fullsized/570a.jpg', 'images/thumbs/570a.jpg', 'WP_20151113_11_04_16_Pro.jpg'),
('A57', 'images/fullsized/571a.jpg', 'images/thumbs/571a.jpg', 'WP_20151113_11_04_34_Pro (1).jpg'),
('A58', 'images/fullsized/580a.jpg', 'images/thumbs/580a.jpg', 'WP_20151113_11_28_55_Pro.jpg'),
('A58', 'images/fullsized/581a.jpg', 'images/thumbs/581a.jpg', 'x.jpg'),
('A59', 'images/fullsized/590a.jpg', 'images/thumbs/590a.jpg', 'DSC_1245.JPG'),
('A59', 'images/fullsized/591a.jpg', 'images/thumbs/591a.jpg', 'DSC_1247.JPG'),
('A66', 'images/fullsized/660a.jpg', 'images/thumbs/660a.jpg', 'DSC_1290.JPG'),
('A66', 'images/fullsized/661a.jpg', 'images/thumbs/661a.jpg', 'DSC_1291.JPG'),
('A66', 'images/fullsized/662a.jpg', 'images/thumbs/662a.jpg', 'DSC_1292.JPG'),
('A66', 'images/fullsized/663a.jpg', 'images/thumbs/663a.jpg', 'DSC_1293.JPG'),
('A66', 'images/fullsized/664a.jpg', 'images/thumbs/664a.jpg', 'DSC_1294.JPG'),
('N5', 'images/fullsized/50n.jpg', 'images/thumbs/50n.jpg', 'broodje-gezond-foto1.jpg'),
('N6', 'images/fullsized/60n.jpg', 'images/thumbs/60n.jpg', '1901347_140647676281243_3127013049640736546_n.jpg'),
('N6', 'images/fullsized/61n.jpg', 'images/thumbs/61n.jpg', '12002283_139625106383500_3024582711398350151_n.jpg'),
('N6', 'images/fullsized/62n.jpg', 'images/thumbs/62n.jpg', '12027754_140647779614566_1357274942401768812_n.jpg'),
('N7', 'images/fullsized/70n.jpg', 'images/thumbs/70n.jpg', 'Afbeelding1.jpg'),
('N8', 'images/fullsized/80n.jpg', 'images/thumbs/80n.jpg', 'DSC_1351.JPG'),
('N8', 'images/fullsized/81n.jpg', 'images/thumbs/81n.jpg', 'DSC_1436.JPG'),
('N8', 'images/fullsized/82n.jpg', 'images/thumbs/82n.jpg', 'DSC_1551.JPG'),
('N9', 'images/fullsized/90n.jpg', 'images/thumbs/90n.jpg', '12301755_176944212651589_6452656093464390516_n.jpg'),
('N10', 'images/fullsized/100n.jpg', 'images/thumbs/100n.jpg', 'Trinity 4-3.jpg'),
('N11', 'images/fullsized/110n.jpg', 'images/thumbs/110n.jpg', 'download.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `gebruikers`
--

CREATE TABLE IF NOT EXISTS `gebruikers` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Gebruikersnaam` varchar(50) NOT NULL,
  `Wachtwoord` varchar(100) NOT NULL,
  `Telefoonnummer` varchar(12) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Rechten` int(2) NOT NULL DEFAULT '2',
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Gebuikersnaam` (`Gebruikersnaam`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `gebruikers`
--

INSERT INTO `gebruikers` (`Id`, `Gebruikersnaam`, `Wachtwoord`, `Telefoonnummer`, `Email`, `Rechten`) VALUES
(1, 'Robert', '$2y$12$6ILKgSiQaWiSgasPeb8M8OOAq0imLAYojFDtAGm6cGfUsnESiCKXi', '1234', 'rvankammen@live.nl', 1),
(3, 'William', '$2y$12$ySAGXIqbyIfv5ucovhm...xKK1XYebIyFwsUf5wbfrVqekXi.R382', '', 'williamvk@live.nl', 1),
(4, 'eline', '$2y$12$6u7pNVjSzWzH1DtqNXvyZeiMlqa6.TjNEXH918j.GXKtYCzaQimvi', '', 'eline-van-dijk@hotmail.com', 1),
(5, 'Irma Cnossen', '$2y$12$S.gkaZL8roTlwmpAt4eefe3bvG2ol49e5qEAu7Evcq2YQDPRdQk7.', '', 'wimcnossen@home.nl', 2),
(6, 'jeroenassen ', '$2y$12$z6tXLs9CZkMBv79zVDl5VOedzX3ENdz/LyY/.DTfA2ej14MBcJDLe', '', 'jeroenkoops@live.nl', 2),
(7, 'g.pool', '$2y$12$ukFeJMfyksaqiLPERaqJRewnO9/el8pz1i1nwMI8hDhftWW9wpRe2', '0592-340645', 'g.pool@rocmensoalting.nl', 2),
(8, 'wsiep', '$2y$12$JTieFwRfo0rC9BaKfeI6qONMubZo2nJLU4pTacRnQcR6.i/JAHN9C', '', 'wouter-siepelinga@hotmail.com', 2),
(9, 'leemhuis', '$2y$12$F.AkmZAcov5lu1ic9URGi.kUlWszlqY.jzY/OXRFActGqSiE6KEUS', '', 'bjleemhuis@kpnplanet.nl', 2),
(10, 'dhaaksema', '$2y$12$YTezfE2Dr6mYeT4UYf86Q.RnpEgrLv7nMdrTLWnEg7g3fCXzm8vya', '0649649146', 'dhaaksema@gmail.com', 2),
(11, 'Petra Zwarts', '$2y$12$.R/hiULRspUNYRCxyRBpTeCsw5KQ.7YU6WbifvvYOdHATvjTpinIy', '0649852849', 'ppbj@hetnet.nl', 2),
(12, 'i44460@trbvm.com', '$2y$12$oqyl1/Zl5wGVXiej/bYQTuz1MEpjurPjXlxawiaEbl85txnO3oL8C', '', 'i44460@trbvm.com', 2),
(14, 'Kirsten', '$2y$12$oUEQK3VW7fek7NzBCJstzeudAdlR3BgJAuf1ueI.Sjlc5GFHS/TNy', '', 'k.l.kramer@hotmail.com', 2),
(15, 'Wia van Duinen', '$2y$12$zj8FouZUvLSJatdk5RBfOu3x0pNXEdyI6ETzdS.hLQhk6m92RNAdi', '', 'wiais@online.nl', 2),
(16, 'EstherBuisman', '$2y$12$k5OdMm81yha7bzZEkv4mSOo9LqQD32T0TSNqjUD7Ng9PXbZrBAOG.', '-', 'estherbuisman@hotmail.com', 2),
(17, 'Adri van der Veen', '$2y$12$k7KdDo5AUrDsWCbMcBEWPuK2lB4dyIQr560n7/eicFOX85OEpRICi', '+31594643828', 'adrivanderveen@gmail.com', 2);

-- --------------------------------------------------------

--
-- Table structure for table `nieuws`
--

CREATE TABLE IF NOT EXISTS `nieuws` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `titel` varchar(100) NOT NULL,
  `nieuwsBericht` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `nieuws`
--

INSERT INTO `nieuws` (`id`, `titel`, `nieuwsBericht`) VALUES
(3, 'sponsorloop', 'Met de hele groep gaan we op 17 december een sponsorloop houden.\r\nDe loop gaat van assen naar Groningen, dit is minimaal 5 uur lopen!\r\nWe hopen veel sponsors te kunnen krijgen, en veel geld op te kunnen halen voor Zuid-Afrika.\r\n\r\nwilt u ons ook sponsoren??\r\nneem contact met mij op of stort direct op:\r\n\r\nNL68INGB0668412216\r\nT.N.V. Stichting GSG-RC MENSO ALTING\r\nOVV. Horizonjaar/6502\r\n\r\nheel erg bedankt voor de sponsoring\r\n'),
(4, 'Facebook pagina', 'Wij hebben als groep ook een Facebook.\r\nHier kunt u ons heel makkelijk volgen.\r\nDe pagina heer horizonjaar 2015.\r\n'),
(5, 'docenten lunch', 'Catering docenten \r\nWij organiseren op 10 december in de grote pauze een nieuwe lerarenlunch. De leraren kunnen zich hiervoor inschrijven via een formulier die wij in de lerarenkamer neerleggen. Hiervoor betalen ze 5 euro. De lunch wordt gehouden in de lerarenkamer. Het budget: tot 50 euro wordt door school gesponsord. Het eten moeten we zelf klaar maken, Gert helpt ons hierbij.'),
(6, 'Catering studenten ', 'Wij zorgen voor de catering in de pauze. \r\nElke maandag staan wij in de middagpauze iets te verkopen. \r\nWe verkopen drie verschillende dingen om de beurt: kipsatÃ© met stokbrood, pizza en broodjes knakworst. \r\nElke week staan er andere studenten in de pauze bij de verkoop.'),
(7, '12 uursactie', 'A.s. donderdag 19 op 20 november hebben wij, het horizonjaar, de 12 uursactie. Dit houdt in dat wij samen met de klas 22 personen een nacht organiseren op school. Elke student is van harte welkom op deze leuke en gezellige avond/nacht. De kosten hiervan is â‚¬12,50 per student.\r\nTijdens deze avond hebben wij natuurlijk leuke en gezellige activiteiten georganiseerd. Waaronder: Een DJ, FIFA competitie, Just dance, film kijken, eten en drinken, verstoppertje in school en natuurlijk veel gezelligheid. Tijdens dit evenement zullen er ook fotoâ€™s worden gemaakt, deze zullen op de facebook komen. Tijdens de nacht zijn er verschillende docenten aanwezig om orde te houden.'),
(8, 'geslaagde 12 uurs actie ', 'De nacht van 19 op 20 november hebben wij onze eerste grote actie gehouden, de â€˜12 uur actieâ€™ (wat eigenlijk 15 uur was). Vanaf 4 uur â€™s middags tot 7 uur sâ€™ ochtends ging het feest door in school, het ROC Menso Alting. Met verschillende activiteiten door de nacht heen zoals: Just dance, Fifa, speeddaten, sardientje, film kijken etc. Er was een DJ geregeld die van 11 uur tot 5 uur muziek draaide door de school. Om 6 uur stond het avondeten klaar en de ochtend erna om kwart over 5 konden ze aan het ontbijt schuiven. Met deze actie hebben we â‚¬580,- opgehaald! De foto''s spreken voor zich, het was al met al een geslaagde avond!\r\nvoor meer foto''s ga naar onze Facebook pagina (links onderin)'),
(9, 'banket actie ', 'Wij hebben banketstaven te koop! \r\n250 gram voor maar 3 euro! Heeft u interesse laat dan een berichtje achter!\r\nU kunt uw bestelling doorgeven tot maandag 30 november aanstaande.\r\nTIP: Heeft u een bedrijf? Trakteer uw personeel allemaal op een banketstaaf voor Sinterklaas, als blijk van waardering!\r\nOP=OP!'),
(10, 'Concert Trinity 23 jan', 'Op 23 januari hebben we een concert georganiseerd samen met Trinity! De tickets zijn â‚¬17.50 per stuk! \r\nU kunt uw kaarten bestellen op deze site: <a href="http://www.truetickets.nl/e/9721/">http://www.truetickets.nl/e/9721/</a>\r\nOok de opbrengsten van dit concert gaat naar het goede doel.\r\nBekijk dit filmpje om alvast een indruk te krijgen\r\n<iframe width="560" height="315" src="https://www.youtube.com/embed/_16b3tYd8pE" frameborder="0" allowfullscreen></iframe>'),
(11, 'donatie? ', 'wilt u ons sponsoren?\r\ndat kan!\r\nu kunt geld storten op \r\n\r\nNL68INGB0668412216\r\nT.N.V. Stichting GSG-RC MENSO ALTING\r\nOVV. Horizonjaar/6502\r\n\r\nHartelijk dank voor de sponsoring ');

-- --------------------------------------------------------

--
-- Table structure for table `rechten`
--

CREATE TABLE IF NOT EXISTS `rechten` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Omschrijving` varchar(100) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `rechten`
--

INSERT INTO `rechten` (`Id`, `Omschrijving`) VALUES
(1, 'Admin'),
(2, 'Gebruiker');

-- --------------------------------------------------------

--
-- Table structure for table `sponsors`
--

CREATE TABLE IF NOT EXISTS `sponsors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(255) NOT NULL,
  `omschrijving` longtext NOT NULL,
  `Link` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `sponsors`
--

INSERT INTO `sponsors` (`id`, `naam`, `omschrijving`, `Link`) VALUES
(2, 'Menso Alting Groningen ', '<h1>ROC Menso Alting</h1>\n\nROC Menso Alting is een gereformeerd mbo voor christenen. De school heeft een vestiging in Groningen en in Zwolle. Met zo''n 675 deelnemers in Groningen en 750 in Zwolle is het Menso Alting het kleinste en natuurlijk ook het gezelligste roc van Nederland.\n\n<h2>Tweede plaats beste roc''s</h2>\n\nWe werken hard aan de kwaliteit van ons onderwijs. En dat blijft niet onopgemerkt. In de Keuzegids Mbo 2014 staat het Menso Alting voor het tweede jaar op de tweede plaats in de categorie beste rocâ€™s. De Keuzegids biedt op verschillende gebieden een gedetailleerde kwaliteitsvergelijking van scholen. Er wordt onder meer gekeken naar de scores op het gebied van onderwijs, rendement, studiebegeleiding, faciliteiten en docenten.\n\nOns geheim? Kleinschalig onderwijs en hart voor de student!\n\nMeer informatie over onze school en de opleidingen die we aanbieden vind je op: <a href="www.mensoaltinggroningen.nl"> www.mensoaltinggroningen.nl</a>', ' http://www.mensoaltinggroningen.nl');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
