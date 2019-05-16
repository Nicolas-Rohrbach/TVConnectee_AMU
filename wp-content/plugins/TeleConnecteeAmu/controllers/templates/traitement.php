<?php

ob_start();

$top = $_POST["contenu_top"];
$bottom = $_POST["contenu_bottom"];
$right = $_POST["contenu_right"];
$center = $_POST["contenu_center"];
$left = $_POST["contenu_left"];



$top = "http://dircom.univ-amu.fr/sites/dircom.univ-amu.fr/files/logo_amu_rvb.jpg";
$bottom="https://previews.123rf.com/images/boarding1now/boarding1now1606/boarding1now160600071/60631690-infos-message-d-information-annonce-de-nouvelles-annoncent-la-main-avec-un-m%C3%A9gaphone.jpg";
$right="https://previews.123rf.com/images/jayzynism/jayzynism1609/jayzynism160900074/64050817-temp%C3%A9rature-m%C3%A9t%C3%A9o-ic%C3%B4nes-symbole-vecteur-illustrateur.jpg";
$center="https://www.lefigaro.fr/assets/infographie/print/1fixe/WEB_201427_horaire_resultat_bac.png";
$left="https://st3.depositphotos.com/4060975/18449/v/1600/depositphotos_184492394-stock-illustration-weather-temperature-scale-thermometer.jpg";



?>
    <!--
<html>
<head>
	<link rel="stylesheet" type="text/css" href="traitement.css" >
	<meta charset="UTF-8">
</head>
<body class="body_menu">


<div id="dropzone">

	<div class="dropbox" id="top">
		<img style='height: 100%; width: 100%; object-fit: contain' src='<?php echo $top?>'/>
	</div>

	<div id="genial">

		<div class="dropbox" id="left">
			<img style='height: 100%; width: 100%; object-fit: contain' src='<?php echo $left?>'/></div>
		<div class="dropbox" id="center">
			<img style='height: 100%; width: 100%; object-fit: contain' src='<?php echo $center?>'/></div>
		<div class="dropbox" id="right" >
			<img style='height: 100%; width: 100%; object-fit: contain' src='<?php echo $right?>'/></div>

	</div>

	<div class="dropbox" id="bottom" >
		<img style='height: 100%; width: 100%; object-fit: contain' src='<?php echo $bottom?>'/>
	</div>
</div>


</body>
</html>
-->
<?php
$monfichier = fopen("fichier.html", "a+");
fwrite($monfichier,ob_get_contents());
// j'écris dans mon fichier tout le flux affiché après la commande ob_start()
fclose($monfichier);
ob_end_flush(); //je termine le contrôle du flux
?><?php
