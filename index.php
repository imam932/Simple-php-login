<?php
session_start();
$conn = mysqli_connect("localhost","root","","login");

$message="";

if(!empty($_POST["login"])) {
	$result = mysqli_query($conn,"SELECT * FROM users WHERE username='" . $_POST["user_name"] . "' and password = '". $_POST["password"]."'");
	$row  = mysqli_fetch_array($result);

	if(is_array($row) && $_POST['nilaiCaptcha'] == $_SESSION['captcha']) {
		$_SESSION["id"] = $row['id'];
	}else {
		if (isset($_SESSION['auth'])) {
			if ($_SESSION['auth'] > 3 || $_SESSION['auth'] == 3) {
				$_SESSION['auth'] = 4;
				blokir_user();
			}else {
				// auth +1
				$_SESSION['auth'] = $_SESSION['auth']+1;
				$message = "Invalid Username or Password! anda telah melakukan login gagal ". $_SESSION['auth']. " kali";
			}
		}else {
			$_SESSION['auth'] =1;
			$message = "Invalid Username or Password! anda telah melakukan login gagal ". $_SESSION['auth']. " kali";
		}
	}
}

if(!empty($_POST["logout"])) {
	$_SESSION["id"] = "";
	session_destroy();
}

function blokir_user(){
	header("Location: blokir.php");
exit();
}

if(isset($_SESSION['auth'])){
	echo $_SESSION['auth'];
}
?>
<html>
<head>
	<title>User Login</title>

	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div>
		<div style="display:block;margin:0px auto;">
			<?php if(empty($_SESSION["id"])) { ?>
				<form action="" method="post" id="frmLogin">
					<div class="error-message"><?php if(isset($message)) { echo $message; } ?></div>
					<div class="field-group">
						<div><label for="login">Username</label></div>
						<div><input name="user_name" type="text" class="input-field"></div>
					</div>
					<div class="field-group">
						<div><label for="password">Password</label></div>
						<div><input name="password" type="password" class="input-field"> </div>
					</div>
					
					<div class="field-group">
						<div><label for="password">Captcha</label></div>
						<div><img src="captcha.php" alt="gambar" /> </div>
					</div>

					<div class="field-group">
						<div><label for="password">Isikan captcha</label></div>
						<div><input name="nilaiCaptcha" value=""/> </div>
					</div>

					<div class="field-group">
						<div><input type="submit" name="login" value="Login" class="form-submit-button"></span></div>
					</div>
				</form>
				<?php
			} else {
				$result = mysqlI_query($conn,"SELECT * FROM users WHERE id='" . $_SESSION["id"] . "'");
				$row  = mysqli_fetch_array($result);
				?>
				<form action="" method="post" id="frmLogout">
					<div class="member-dashboard">Welcome <?php if ($row['level'] == 1) {
						echo "Super Admin ";
					}elseif ($row['level'] == 2) {
						echo "Admin ";
					} else {
						echo "Admin ";
					}
					echo ucwords($row['username']); ?>, You have successfully logged in!<br>
					Click to <input type="submit" name="logout" value="Logout" class="logout-button">.</div>
				</form>
			</div>
		</div>
	<?php } ?>
</body></html>
