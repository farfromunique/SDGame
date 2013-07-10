<?php
// Availiable $_SESSION variables:
//  CurrLoc: Integer tied to Locations Table UID
//  CharUID: Integer tied to Character_Details UID
//  CharName: String of the Characater Name
//  IsGM: Boolean of whether or not this is a GM account
//  LoggedIn: "Yes" or not "Yes" answer to the question "Is there a logged in person?"
//  TZ: String containng a timezone

session_start();
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="basic.css">
</head>
<body>
<?php
$currentLoc = $_SESSION["CurrLoc"];

// Create SQL connection
$con=mysqli_connect("database.db","username","password","Characters");

// Check connection
if (mysqli_connect_errno($con))
  {
		echo "Failed to connect to MySQL (read): " . mysqli_connect_error();
	} 

$currentChar = $_SESSION["CharUID"];
$LookAt = $_REQUEST["id"];

//Define Queries
$charshere = mysqli_query($con,"SELECT UID, Name, Rank FROM Character_Details WHERE Current_Location_W = " . $currentLoc);
$location = mysqli_query($con,"SELECT * FROM Locations WHERE UID = " . $currentLoc);
$WhoToLookAt = mysqli_query($con,"SELECT * FROM  Character_Details WHERE UID = " . $LookAt);

//Navbar
echo "<div id='navbar'>";
require 'components/navbar.php';
echo "</div>";

//WhoIsHere bar
echo "<div id='whoshere'>";
require 'components/whoishere.php';
echo "</table></div>";

//Body
echo "<div id='content'><h2>";


//Footer
require 'content/footer.php';

?>
