<?php
// Availiable $_SESSION variables:
//  CurrLoc: Integer tied to Locations Table UID
//  CharUID: Integer tied to Character_Details UID
//  CharName: String of the Characater Name
//  IsGM: Boolean of whether or not this is a GM account
//  LoggedIn: "Yes" or not "Yes" answer to the question "Is there a logged in person?"
//  TZ: String containng a timezone
session_start();

#remove the directory path we don't want 
$request  = str_replace("", "", $_SERVER['REQUEST_URI']); 
#split the path by '/'  
$site_array  = mb_split("/", $request);  

foreach($site_array as $key => $value)
{ 
	if($value == "") { 
		unset($site_array[$key]); 
	} 
} 

$params = array_values($site_array);  

switch ($params['0'])
	{
		case "kronjob":
			$header = '';
			$main = require_once ('kronjob.php');
			$footer = '';
			return;
			
		case "chat":
			$header = require_once ('header.php');
			$main = require_once ('converse.php');
			$footer = require_once ('footer.php');
			return;
		
		case "powers":
			$header = require_once ('header.php');
			$main = require_once ('buyPowers.php');
			$footer = require_once ('footer.php');
			return;
			
		case "character":
			$header = require_once ('header.php');
			$main = require_once ('newchar.php');
			$footer = require_once ('footer.php');
			return;
			
		case "goto":
			$header = require_once ('header.php');
			$main = require ('goto.php');
			$footer = require_once ('footer.php');
			return;
			
		case "timezone":
			$header = require_once ('header.php');
			$main = require_once ('TZChoice.php');
			$footer = require_once ('footer.php');
			return;
			
		case "insert":
			$header = require_once ('header.php');
			if ($_SESSION["IsGM"])
			{ $main = require_once ('insert.php'); }
			else
			{ $main = require_once ('converse.php'); }
			$footer = require_once ('footer.php');
			return;
			
		default:
			$header = require_once ('header.php');
			$main = require_once ('converse.php');
			$footer = require_once ('footer.php');
			return;
			
	}
echo $header;
?>

<div class='headBar'>
	<h2>You are currently at <span id='CurrLoc'><?php echo $_SESSION["CurrLocName"]; ?></span></h2>
	<h3>It is now <?php echo $tf; ?></h3>
</div>
<div class='content' id='main'>
<?php echo $main ?>
</div>
<!-- Footer Done -->
<?php echo $footer ?>
<!-- Footer Done -->
