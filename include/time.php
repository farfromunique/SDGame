<?php
session_start();
$t=time(); // Current Time
$u=$t;
$tf = date('Y-m-d g:i A',$t); // Time, Formatted (in server TZ) (To be dislayed)
$tu = date('Y-m-d G:i:s',$t); // Time, Formatted (in server TZ) (For the update process)
$tfOld = "'" . date('Y-m-d G:i:s',$t-86400) . "'"; // Time minus 1 day, formatted. For use in pulling conversations.
if (isset($_SESSION["TZ"])) // If the user has set a TimeZone
{
	$tz=date_create(date('Y-m-d g:i:s',$t),timezone_open($_SESSION["TZ"])); // Timezone
	$t=$t+date_offset_get($tz); // Time, modified to be accurate to Timezone
	$tf = date('Y-m-d g:i A',$t); // Time, Formatted (in User TZ) (to be displayed)	
}
$tzOffset=($u-$t); // Number of seconds difference from server (UTC) to user

$date = new DateTime();
$localTime = new DateTime('now',new DateTimeZone('America/Los_Angeles'));
/** @noinspection PhpVoidFunctionResultUsedInspection */
/** @noinspection PhpParamsInspection */
$yesterday = $date->sub(date_interval_create_from_date_string('1 day'));
?>