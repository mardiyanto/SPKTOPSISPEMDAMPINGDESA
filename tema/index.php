<?php 
  session_start();	
  include "config/koneksi.php";
	include "config/fungsi_indotgl.php";
	include "config/class_paging.php";
	include "config/fungsi_combobox.php";
	include "config/library.php";
  include "config/fungsi_autolink.php";
  include "config/fungsi_rupiah.php";
   $aksi=$_GET[aksi];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><? if(empty($_GET[nama])){echo"Selamat Datang Ditoko $k_k[nama_perusahaan]";}else{echo"$_GET[nama]";}?></title>
<link rel="stylesheet" href="lib/css/reset.css" type="text/css" media="screen, projection" />
<link rel="stylesheet" href="lib/css/defaults.css" type="text/css" media="screen, projection" />
<link rel="stylesheet" href="style.css" type="text/css" media="screen, projection" />
</head>
<body class="home blog page-builder">

            			<div class="menu-secondary-container">
						<ul id="menu-bawah" class="menus menu-secondary">
												  <li><a href="index.php">Beranda </a></li>
						  
<li ><a href="?l=lihat&aksi=profil&id_p=4" >Profil Kami</a>
	<ul>
<li><a href="?l=lihat&aksi=profil&id_p=4">Profil</a></li>
 <li> <a href="index.php?l=lihat&aksi=kontak">Kontak Kami</a></li>
 <li  ><a href="?l=lihat&aksi=carabayar">Cara Bayar</a></li>
 <li><a href="?l=lihat&aksi=profil&id_p=2">Cara Belanja</a></li>
	</ul>
</li>
<li><a href="?l=lihat&aksi=allproduk">Semua Produk</a></li>
<li><a href="index.php?l=lihat&aksi=login&cek=cek">Member</a><ul>
<? if( $_SESSION[kustomer]==''){?>
 <li><a href='index.php?l=lihat&aksi=login' class="off">Daftar</a></li>
 <? }else{?>
 <? 
$order=mysql_query(" SELECT COUNT(id_kustomer) as Od  FROM orders WHERE id_kustomer=$_SESSION[kustomer] ");
$Od=mysql_fetch_array($order);
		?>
 <li><a href='index.php?l=lihat&aksi=pesanansaya'>Pesanan Saya <b>(<?=$Od[Od]?>)</b></a></li> <li><a class="off" href='logout.php'>Keluar</a></li>
 <? }?>


<li><a href="?l=lihat&aksi=ongkir">Ongkos Kirim</a></li></ul>
</li>
 <li> <a href="?l=lihat&aksi=testi">Testimoni</a></li>

						</ul>
		</div>
                      <!--.primary menu--> 	
                    


</body>
</html>
