<?php if ( !isset($_SESSION["LoggedIn"]) or $_SESSION["LoggedIn"]=="No"): ?>
	<div class='register'><Center>Welcome!<center>
		<p>You don't seem to be logged in at the moment. Please take a moment to either Log In or Register.</p>
		<br /><br />
		<table width='400px' border='1'>
			<tr>
				<td>
					<b>Login:</b>
					<form action='login.php' method='POST'>
						Username: <input name='User' maxlength='32' type='text'><br />
						Password: <input name='Pword' maxlength='32' type='password'><br />
						<input name='Submit' type='submit' value='Log In!'>
					</form>
				</td>
			</tr>
			<tr>
				<td>
					<b>Register:</b>
					<form action='registered.php' method='post'>
						Username: <input name='Uname' maxlength='32'><br />
						Character Name: <input name='Cname' maxlength='32'>
						<input name='Submit' type='submit' value='Log In!'>
					</form>
				</td>
			</tr>
		</table>
		<br /><br />
		Please note that you must be 13 to register.<br />
		<?php echo date('Y-m-d h:i:s',time()); ?>
	</div>
<?php endif; ?>
