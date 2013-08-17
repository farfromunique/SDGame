<?php
// Create MySQL Sessions
$database = 'sdgame.db';
$table = 'Characters';

if (! $con=mysqli_connect($database,"sdgame","Read_It",$table))
{
	die('Error connecting to $con in connections.php. Stopping!');
}
if (! $ud=mysqli_connect($database,"sdgame_add","WriteIt",$table))
{
	die('Error connecting to $ud in connections.php. Stopping!');
}
if (! $pw=mysqli_connect($database,"sdgame_pw","safetyFirst",$table))
{
	die('Error connecting to $pw in connections.php. Stopping!');
}
?>