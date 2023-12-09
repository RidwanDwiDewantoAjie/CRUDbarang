<?php session_start() ?>
<!DOCTYPE html>
<html>

<head>
	<title>Login Sistem</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="bootstrap4/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="./css/style-resha.css">
	<script src="bootstrap4/js/bootstrap.js"></script>
	<script src="bootstrap4/jquery/3.3.1/jquery-3.3.1.js"></script>
	<script src="https://kit.fontawesome.com/deaec4b9bf.js" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</head>

<body>
	<div class="container">
		<div class="w-25 mx-auto text-center mt-5">
			<div class="card bg-dark text-light">
				<div class="card-body">
					<h2 class="card-title" id="cardTitle">LOGIN</h2>
					<form method="post" action="" class="mb-2" id="loginCard">
						<div class="form-group">
							<label for="username">Nama user</label>
							<input class="form-control" type="text" name="username" id="username" autofocus>
						</div>
						<div class="form-group">
							<label for="passw">Password</label>
							<input class="form-control" type="password" name="passw" id="passw">
							<div class="input-group-append position-relative">
								<i class="fa-regular fa-eye absolute bottom-0 end-50" style="color: #000000;" id="showPassword"></i>
							</div>
						</div>
						<div>
							<button class="btn btn-info" type="submit">Login</button>
						</div>
					</form>
					<form method="post" action="" class="mb-2" style="display: none;" id="registerCard">
						<div class="form-group">
							<label for="username">Nama user baru</label>
							<input class="form-control" type="text" name="usernameRegis" id="usernameRegis" autofocus>
						</div>
						<div class="form-group">
							<label for="passw">Password baru</label>
							<input class="form-control" type="password" name="passwRegis" id="passwRegis">
							<div class="input-group-append position-relative">
								<i class="fa-regular fa-eye absolute bottom-0 end-50" style="color: #000000;" id="showPasswordRegis"></i>
							</div>
						</div>
						<div>
							<button class="btn btn-info" type="submit">Register</button>
						</div>
					</form>
					<p class="mb-2" id="quest">Belum punya akun?</p>
					<button class="btn btn-outline-info" type="button" id="btnPage">Registrasi</button>
				</div>
			</div>
		</div>
	</div>
	<?php
	if (isset($_POST['username'])) {
		require "fungsi.php";
		$username = $_POST['username'];
		$passw = md5($_POST['passw']);
		$sql = "select * from user where username='$username' and password='$passw'";
		$hasil = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
		$row = mysqli_fetch_assoc($hasil);
		if (mysqli_affected_rows($koneksi) > 0) {
			$_SESSION['username'] = $username;
			if (strpos($username, "A12") !== false) {
				header("location: updateMhs.php");
			} elseif (strpos($username, "0686") !== false) {
				header("location: updateDosen.php");
			} else {
				header("location: homeAdmin.php");
			}
		} else {
			echo "<div class='alert alert-danger w-25 mx-auto text-center mt-1 alert-dismissible'>
			<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
			Maaf, login gagal. Ulangi login.
			</div>";
		}
	} else if (isset($_POST['usernameRegis'])) {
		require "fungsi.php";
		$username = $_POST['usernameRegis'];
		$password = md5($_POST['passwRegis']);
		$status = $_POST['passwRegis'];
		//$sql = "insert into user (username,password,status) values ('$username','$passw','$status')";

		$checkQuery = "SELECT username FROM user WHERE username = '$username'";
		$checkResult = mysqli_query($koneksi, $checkQuery);

		if (mysqli_num_rows($checkResult) > 0) {
			echo "<div class='alert alert-danger w-25 mx-auto text-center mt-1 alert-dismissible' role='alert'>
			<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
			Username sudah ada, coba ganti yang lain atau login.
			</div>";
		} else {
			$sql = "INSERT INTO user (username, password, status) VALUES ('$username', '$password', '$status')";
			$hasil = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));

			if ($hasil) {
				echo "<div class='alert alert-success w-25 mx-auto text-center mt-1 alert-dismissible'>
				<button type='button' class='close' id= data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				Register Berhasil
				</div>";
				header("Location: index.php");
			} else {
				echo "<div class='alert alert-danger w-25 mx-auto text-center mt-1 alert-dismissible'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				Maaf, registrasi gagal. Silakan coba lagi.
				</div>";
			}
		}
	}
	?>

	<script>
		var eye = document.getElementById("showPassword");
		var eyeReg = document.getElementById("showPasswordRegis");
		var btnPage = document.getElementById("btnPage");
		eye.addEventListener("click", function() {
			var passwordInput = document.getElementById("passw");
			var pssswordRegis = document.getElementById("passwRegis");

			if (passwordInput.type === "password") {
				eye.classList.remove("fa-eye");
				eye.classList.add("fa-eye-slash");
				passwordInput.type = "text";
			} else {
				eye.classList.remove("fa-eye-slash");
				eye.classList.add("fa-eye");
				passwordInput.type = "password";
			}
		});
		
		eyeReg.addEventListener("click", function() {
			var pssswordRegis = document.getElementById("passwRegis");

			if (pssswordRegis.type === "password") {
				eyeReg.classList.remove("fa-eye");
				eyeReg.classList.add("fa-eye-slash");
				pssswordRegis.type = "text";
			} else {
				eyeReg.classList.remove("fa-eye-slash");
				eyeReg.classList.add("fa-eye");
				pssswordRegis.type = "password";
			}
		});

		btnPage.addEventListener("click", function() {
			var btnPage = document.getElementById("btnPage");
			var loginCard = document.getElementById("loginCard");
			var registerCard = document.getElementById("registerCard");
			var cardTitle = document.getElementById("cardTitle");
			var quest = document.getElementById("quest");

			console.log("diklik pak");

			if (btnPage.textContent === "Registrasi") {
				loginCard.style.display = "none";
				registerCard.style.display = "block";
				btnPage.textContent = "Login";
				cardTitle.innerText = "REGISTER AKUN";
				quest.innerText = "Sudah punya akun?";
			} else if (btnPage.textContent === "Login") {
				loginCard.style.display = "block";
				registerCard.style.display = "none";
				btnPage.textContent = "Registrasi";
				cardTitle.innerText = "LOGIN";
				quest.innerText = "Belum punya akun?";
			}
		});
	</script>
</body>

</html>