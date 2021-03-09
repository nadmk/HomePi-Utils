<?php

//Used for debugging.
/*
ini_set("display_errors",1);
error_reporting(E_ALL);
*/
define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');

$cpage;
$cpage_name;

if(!isset($_GET['page']) || $_GET['page'] == 'home'){
	$cpage = "home.phtml";
	$cpage_name = "Home";
}
else if ($_GET['page'] == 'network') {
	$cpage = "net.phtml";
        $cpage_name = "Network";
		
}else if ($_GET['page'] == 'profiles') {
		$cpage = "profiles.phtml";
        $cpage_name = "Profiles";
}		
else {
	$cpage = "404.htm";
	$cpage_name = "Not Found";
}
echo '<head>';
echo '<title> Home_LAB - '. $cpage_name .'</title>';
echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1"></head>';
echo '<script src="https://kit.fontawesome.com/0ed354e3ae.js" crossorigin="anonymous"></script>';

require DOC_ROOT_PATH . "includes/header.htm";

require DOC_ROOT_PATH . "includes/" . $cpage;


require DOC_ROOT_PATH . "includes/footer.htm";


?>
