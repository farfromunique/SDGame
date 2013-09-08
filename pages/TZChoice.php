<?php
    $site_root = $_SERVER["SERVER_NAME"];
    $serverRoot = $_SERVER["DOCUMENT_ROOT"];
    spl_autoload_register(function ($class) {
        global $serverRoot;
        require_once $serverRoot . 'classes/' . $class . '.class.php';
    });
    session_start();

//Body
?>
<h2>Timezone List</h2>
	<Table border='1'>
		<tr>
			<th width='45'>Select</th>
			<th width='155'>Current Time</th>
			<th>Timezone Name</th>
			<th>Go To Submit</th>
		</tr>
		<?php
			$TZ_List=timezone_abbreviations_list();
			foreach($TZ_List as $x=>$x_value)
			{  
				foreach($TZ_List[$x] as $y=>$y_value)
				{
					?>
					<tr>
						<td align='center'><input type='radio' name='TZ' value='<?php echo $y_value['timezone_id']?>'></td>
						<td align='center'><?php echo date('Y-m-d h:i A',time() + $y_value['offset']) ?>
						<?php if ($y_value['dst']==1): ?>
							<br />**DST Active**
						<?php endif; ?>
						</td>
						<td align='center'><?php echo $y_value['timezone_id'] ?></td>
						<td align='center'><a href='#Foot'>Done?</a></td>
                    </tr>
					<?php
				}
			  }
		?>
		<tr>
			<td colspan='4' align='center'>
				<a name='Foot'></a>
				<input type='submit' value='Set Timezone' id='tzset'>
			</td>
		</tr>
	</table>