<?php
// Availiable $_SESSION variables:
//  CurrLoc: Integer tied to Locations Table UID
//  CharUID: Integer tied to Character_Details UID
//  CharName: String of the Characater Name
//  IsGM: Boolean of whether or not this is a GM account
//  LoggedIn: "Yes" or not "Yes" answer to the question "Is there a logged in person?"
//  TZ: String containng a timezone

require 'components/header.php';

//Body
echo "<div id='content'><h2>Timezone List</h2>";
$TZ_List=timezone_abbreviations_list();

echo "<form action='tz_update.php' method='POST'>
  <Table border='1'>
		<tr>
			<th width='45'>Select</th>
			<th width='155'>Current Time</th>
			<th>Timezone Name</th>
			<th>Go To Submit</th>
		</tr>";

foreach($TZ_List as $x=>$x_value)
  {  
  foreach($TZ_List[$x] as $y=>$y_value)
	{
		echo "<tr>
				<td align='center'><input type='radio' name='TZ' value='" . $y_value['timezone_id'] . "'></td>
				<td align='center'>" . date('Y-m-d h:i A',time() + $y_value['offset']);
				if ($y_value['dst']==1)
				{
					echo "<br />**DST Active**";
				}
				echo "</td>
				<td align='center'>" . $y_value['timezone_id'] . "</td>
				<td align-'center'><a href='#Foot'>Done?</a></td>
			</tr>";
	}
  	
  }

echo "<tr><td colspan='4' align='center'><a name='Foot'></a><input type='submit' value='Set Timezone'></td></tr></table></form>";

//Footer
require 'components/footer.php';

?>
