<?php
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


require_once ('connections.php');
require_once ('classes/CronJob.class..php');

$cron = new CronJob();

switch ($params[2]) // should be 1 once deployed
{
	case "Daily":
        echo $cron->runDaily($optimize);

		break;
	case "Weekly":
		echo $cron->runWeekly($optimize);
		break;
}
unset($ud);
?>
