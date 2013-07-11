<?php
// Availiable $_SESSION variables:
//  CurrLoc: Integer tied to Locations Table UID
//  CharUID: Integer tied to Character_Details UID
//  CharName: String of the Characater Name
//  IsGM: Boolean of whether or not this is a GM account
//  LoggedIn: "Yes" or not "Yes" answer to the question "Is there a logged in person?"
//  TZ: String containng a timezone

session_start();

$UName = "'" . $_POST['User'] . "'";
$PWord = md5($_POST['Pword']);


$loginStr="SELECT CharUID, Password, TimeZone FROM Logins WHERE LoginName = " . $UName;
$logins = mysqli_query($pw,$loginStr);

$t=time();
?>

<?php if (mysqli_affected_rows($pw) == 1): ?>
	<?php while ($row = mysqli_fetch_array($logins)): ?>
		<?php if ($row['Password']==$PWord): ?>
			<?php
				$_SESSION["LoggedIn"] = "Yes";
				$_SESSION["CharUID"] = $row['CharUID'];
				$_SESSION["TZ"]=$row['TimeZone'];
				$LoggedInAt = mysqli_query($pw, "UPDATE Logins SET LastLogin " . $t . " WHERE UID = " . $_SESSION["CharUID"]);
				$GetLoc = mysqli_query($pw,"SELECT Current_Location_W, Name FROM Character_Details WHERE UID = " . $_SESSION["CharUID"]);
			?>	
			<?php while ($row = mysqli_fetch_array($GetLoc)): ?>
				<?php
					$_SESSION["CurrLoc"] = $row['Current_Location_W'];
					$_SESSION["CharName"] = $row['Name'];
				?>
			<?php endwhile; ?>
			<?php $GM_Indicator = explode("-",$_SESSION["CharName"]); ?>
			<?php if ($GM_Indicator[0] == "GM"): ?>
				<?php $_SESSION["IsGM"] = True; ?>
			<?php else: ?>
				<?php $_SESSION["IsGM"] = False; ?>
			<?php endif; ?>
			<?php header('Location: http://game.acwpd.com/'); ?>
			
			
		<?php else: ?>
			Invalid Password. Try Again
			<?php
				$_SESSION["LoggedIn"] = "No";
				$_SESSION["CharUID"] = 0;
			?>
			<html>
			<head>
			<link rel='stylesheet' type='text/css' href='basic.css'>
			</head>
			<?php require 'components/register.php'; ?>
			</div>
		<?php endif; ?>	
	<?php endwhile; ?>
<?php elseif (mysqli_affected_rows($pw) == 0): ?>
	<?php
		$_SESSION["LoggedIn"] = "No";
		$_SESSION["CharUID"] = 0;
	?>
	<html>
		<head>
			<link rel='stylesheet' type='text/css' href='basic.css'>
		</head>
		<body>
		<span>Invalid Login Name. Try Again.</span>  
		<?php require 'components/register.php'; ?>
<?php else: ?>
	<?php
		$message="Hey! Someone just managed to get more than 1 result on the query<br />" . $loginStr . "<br />Better check the DB!";
		$headers = "From:TheGame@acwpd.com";
		mail('game@acwpd.com','Duplicate Username',$message,$headers);
	?>
	Something very odd happened. The site admin has been contacted. Our apologies.
<?php endif; ?>
<?php require 'components/footer.php'; ?>
