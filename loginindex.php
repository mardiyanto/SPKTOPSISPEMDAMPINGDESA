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

    <!-- ============================================================== -->

        
            
			
			<div class="card-body">
               
	
					<form role="form" action="login.php" method="post" >
				
							<div class="form-group">
								<input class="form-control form-control-lg" placeholder="username" name="username" value="<?php echo htmlentities($username); ?>" autofocus="">
							</div>
							<div class="form-group">
								<input class="form-control form-control-lg" placeholder="Password" name="password" type="password" value="">
							</div>
					
							<button type="submit" name="submit" value="submit" class="btn btn-success">Log in</button>
						
					</form>

            </div>

<?php
