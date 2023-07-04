<?php require_once('includes/init.php'); ?>

<?php
$errors = array();
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['username']) ? trim($_POST['password']) : '';

if(isset($_POST['submit'])):
	
	// Validasi
	if(!$username) {
		$errors[] = 'Username tidak boleh kosong';
	}
	if(!$password) {
		$errors[] = 'Password tidak boleh kosong';
	}
	
	if(empty($errors)):
		
		$query = $pdo->prepare('SELECT * FROM user WHERE username = :username');
		$query->execute( array(
			'username' => $username
		) );
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$user = $query->fetch();
		
		if($user) {
			$hashed_password = sha1($password);
			if($user['password'] === $hashed_password) {
				$_SESSION["user_id"] = $user["id_user"];
				$_SESSION["username"] = $user["username"];
				$_SESSION["role"] = $user["role"];
				redirect_to("dashboard.php?status=sukses-login");
			} else {
				$errors[] = 'Maaf, anda salah memasukkan username / password';
			}
		} else {
			$errors[] = 'Maaf, anda salah memasukkan username / password';
		}
		
	endif;

endif;	
?>

<?php
$judul_page = 'Log in';
?>
<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="tema1/assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="tema1/assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="tema1/assets/libs/css/style.css">
    <link rel="stylesheet" href="tema1/assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <style>
    html,
    body {
        height: 100%;
    }

    body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
    }
    </style>
</head>

<body>
    <!-- ============================================================== -->
    <!-- login page  -->
    <!-- ============================================================== -->
    <div class="splash-container">
        <div class="card ">
		  
            <div class="card-header text-center"><a class="navbar-brand" href="index.php">SPK SAW</a>
			<span class="splash-description">Silahkan Login</span></div>
            <?php if(!empty($errors)): ?>
			
				<div class="msg-box warning-box">
					<p><strong>Error:</strong></p>
					<ul>
						<?php foreach($errors as $error): ?>
							<li><?php echo $error; ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
				
			<?php endif; ?>	
			
			
			<div class="card-body">
               
	
					<form role="form" action="login.php" method="post" >
				
							<div class="form-group">
								<input class="form-control form-control-lg" placeholder="username" name="username" value="<?php echo htmlentities($username); ?>" autofocus="">
							</div>
							<div class="form-group">
								<input class="form-control form-control-lg" placeholder="Password" name="password" type="password" value="">
							</div>
					
							<button type="submit" name="submit" value="submit" class="btn btn-success">Log in</button>
							<a href="index.php" class="btn btn-primary">Kembali</a>
					</form>

            </div>

        </div>
    </div>
  
    <!-- ============================================================== -->
    <!-- end login page  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="tema1/assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="tema1/assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
</body>
 
</html>
<?php
