<?php

// rzc=large  (8 resultats par bucket)
// start=NUM  (pour la pagination)
//URL for web
//$url = "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=";
//images
//http://ajax.googleapis.com/ajax/services/search/images?v=1.0&q=artiom%20fedorov&start=

//error_reporting(15);

define('CACHE', './cache/');
define('TEMPLATES', './templates/');

include("libs/google.images.class.php");

$nom = $_GET['nom'];
$prenom = $_GET['prenom'];
$societe = $_GET['entreprise'];
$fonction = $_GET['fonction'];

$enoughparams = true;

$qarray = array();

if (isset($nom) && isset($prenom)) {
	$qarray[] = array('query' => $nom . " " . $prenom, 'ponderation' => 10);
} else {
	$enoughparams = false;
}

if (isset($nom) && isset($prenom) && isset($societe) && $enoughparams) {
	$qarray[] = array('query' => $nom . " " . $prenom . " " . $societe, 'ponderation' => 10);
}


if (isset($nom) && isset($prenom) && isset($societe) && isset($fonction) && $enoughparams) {
	$qarray[] = array('query' => $nom . " " . $prenom . " " . $societe . " " . $fonction, 'ponderation' => 10);
}


if (isset($nom) && isset($prenom) && isset($fonction) && $enoughparams) {
	$qarray[] = array('query' => $nom . " " . $prenom . " " . $fonction, 'ponderation' => 10);
}

$nrb_results_max = 20;

if ($enoughparams) {
	$data2 = GoogleImages::queryArrayToResultArrayWithCache($qarray, $nrb_results_max);
} else {
	$data2 = array();
}

include(TEMPLATES . "findermain.php");

?>

