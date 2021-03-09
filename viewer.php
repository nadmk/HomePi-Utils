<?php
$debug = true; /* Turn Debugging info on or off*/

$file = "";

if($debug) {
	ini_set("display_errors",1);
	error_reporting(E_ALL);
}

Sanitize(isset($_GET['file']));

define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/'); //Make Document root for locations.

/* Include Bulma and some html shit*/
echo '<head>';
echo '<title> Home_LAB - File Viewer </title>';
echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1"></head>';

/* Get Header */
require DOC_ROOT_PATH . "includes/header.htm";

/* Construct Log Viewer Body */
echo '<h1 align="center" class="title"> Log Viewer: </h1><p align="center"> Here you can see files inside the /var/log/ directory.';
echo '<hr>';
echo '<div class="container">
<form id="subscription_order_form" class=""  method="get" action="viewer.php"> 
<div class="field is-grouped">

<p class="control is-expanded">   
   <input class="input" name="file" type="text"placeholder="'.$file.'">
	</input>
  </p>
  <p class="control">
    <button type="submit" class="button is-info">
      View
    </button>		
	</form>
  </p>
</div>';
/* Log viewer text area */
echo '<div class="control">
  <textarea class="textarea" readonly>';
 

  
/* Begin File Parsing */
if(Sanitize(isset($_GET['file']))) { // Before trying to parse the file check if sanitization has passed and that it is not empty.
	if(file_exists("/var/log/".$file)) { // Check that file exists.
		
		$files = new SplFileObject("/var/log/".$file);
		$files->seek(PHP_INT_MAX); // cheap trick to seek to EoF
		$total_lines = $files->key(); // last line number 
		$reader = new LimitIterator($files, $total_lines - 20); // output the last twenty lines
		
		/*Echo each line*/
		foreach ($reader as $line) {
			echo $line; // includes newlines
		}
	} 
	
	else { //Error handling if File does not exist.
		echo "File not supplied or invalid target.\n";
		echo "Why not try those:\n";
		echo shell_exec("ls /var/log/ | grep .log ");
	}
}
else { // Error Handling if Sanitzation failed.
	echo "File not supplied or invalid target.\n";
	echo "Why not try those:\n";
	echo shell_exec("ls  /var/log/ | grep .log");
}

echo '</textarea></div><hr></div>'; //Closing HTML Tags.

require DOC_ROOT_PATH . "includes/footer.htm"; //Get footer.

function Sanitize($input) {
	if(isset($_GET['file'])){
		if(!preg_match("/(\.\.)/", $_GET['file'])) {
			$GLOBALS['file'] = $_GET['file'];
			return true;
	} else {
		$GLOBALS['file'] = "";
		return false;
	}
	}else {
		$GLOBALS['file'] = "";
		return false;
	}
}

?>
