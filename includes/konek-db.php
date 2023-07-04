<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'spk_pendampingdesa');

try {
	// set dbase untuk mysql
	$pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
	
	// Set Error Mode ke Exception
	# $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	
	// Set Error Mode ke mode Warning
	$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
	
} 
catch(PDOException $e) {
	die("Ups, tidak dapat terkoneksi ke database<br><br>".$e->getMessage());
}

$server = "localhost";
$username = "root";
$password = "";
$database = "spk_pendampingdesa";
mysql_connect($server,$username,$password) or die("Koneksi gagal");
mysql_select_db($database) or die("Database tidak bisa dibuka");
$profil3 = mysql_query("SELECT * FROM profil where aktif='Y'");
$r3      = mysql_fetch_array($profil3);