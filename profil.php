<?php

/* ---------------------------------------------
 * Konek ke database & load fungsi-fungsi
 * ------------------------------------------- */
require_once('includes/init.php'); 
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?=$r3['foto']?></title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="tema/lib/css/reset.css" type="text/css" media="screen, projection" />
<link rel="stylesheet" href="tema/lib/css/defaults.css" type="text/css" media="screen, projection" />
<link rel="stylesheet" href="tema/style.css" type="text/css" media="screen, projection" />
<link href="tema/font-awesome/css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" href="tema1/assets/vendor/bootstrap/css/bootstrap.min.css">
<link href="css/dataTables.bootstrap.min.css" rel="stylesheet">
<link type="text/css" href="css/jquery.toastmessage.css" rel="stylesheet"/>
<script src="tema1/assets/vendor/jquery/jquery-3.3.1.min.js"></script>
<link rel="stylesheet" href="tema1/css/datepicker/datepicker3.css">
<script src="tema1/js/bootstrap-datepicker.js"></script>
	<script>
  $(function () {
    $('#datepicker').datepicker({
      autoclose: true
    });
  });
</script>	 
</head>
<body class="home blog page-builder">
<div id="container">
    <div class="clearfix">
        			<div class="menu-primary-container">
					<ul id="menu-atas" class="menus menu-primary">				
<li><a href="list-user.php"><i class="fa fa-user fa-fw"></i></a>
  </ul>
</div>           <!--.primary menu--> 	
                


    </div>
	<div id="header">
    
        <div class="logo">
         <div class="header-part">
				<a href="#"><img src="tema/images/logo.png" alt="vitalove" title="vitalove" class="logoimg" /></a>							
					</div>  
        </div><!-- .logo -->

        <div class="header-right">
 
        </div><!-- .header-right -->
        
    </div><!-- #header -->
    
	        <div class="clearfix">
            		<?php include"menu.php"?>
                      <!--.primary menu--> 	
               </div>	
			
       <div id="main">	
		          <div class="container-fluid  dashboard-content">
                <!-- ============================================================== -->
                <!-- pageheader -->
                <!-- ============================================================== -->
               <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">SELAMAT DATANG DI <?=$r3['nama']?></h2>
                            <p class="pageheader-text"><?=$r3['foto']?></p>
       
                        </div>
                    </div>
                </div>
	<?php 
if ($_GET['module']=='home'){
$edit=mysql_query("SELECT * FROM profil WHERE id_profil='$_GET[id_profil]'");
$r=mysql_fetch_array($edit);
echo"				      <div class='row'>
                    <!-- ============================================================== -->
                    <!-- pie chart  -->
                    <!-- ============================================================== -->
                    <div class='col-xl-12 col-lg-6 col-md-6 col-sm-12 col-12'>
                        <div class='card'>
                            <h4 class='card-header'>$r[nama]</h4>
                            <div class='card-body'>
                               <section class='content'>

          <!-- Default box -->
          <div class='box'>
			<div class='alert alert-success alert-dismissable'>               
                    $r[isi]
              </div>

          </div><!-- /.box -->

                            </div>
                        </div>
                    </div>
					</div>
";
}
elseif($_GET['module']=='daftartki'){
$i = date("Ymd");
$j = gmdate('H:i:s',time()+60*60*7);   
$sql = @mysql_query('SELECT RIGHT(id_daftar ,3) AS id_daftar  FROM daftar ORDER BY id_daftar DESC LIMIT 1') or die('Error : '.mysql_error());
 $num = mysql_num_rows($sql);
 if($num <> 0)
 {
 $data = mysql_fetch_array($sql);
 $kode = $data['id_daftar'] + 1;
 }else
 {
 $kode = 1;
 }
 //mulai bikin kode
 $bikin_kode = str_pad($kode, 3, "0", STR_PAD_LEFT);
 $kode_jadi = "$bikin_kode"; 
 echo" <div class='post-33'>
        <h2 class='title'>Form Pendaftaran Calon Kariawan</h2>
		<div class='entry'> 
		<form name='form1' id='form_combo' role='form'  method='post' action='profil.php?module=prosespesan'>
 
        <div style='font-weigth:bold; font-size:15px; border-bottom: 1px solid #000000; margin-bottom:5px;'>A.Identitas Calon Kariawan</div>
    	<div class='col-md-12'>
		<label>Kode Pendaftaran</label>
		<div class='form-group input-group'>
        <input type='text' class='form-control'  value='KD/$i/$kode_jadi/$j'  disabled='disabled'>
		 <input type='hidden' class='form-control' value='KD/$i/$kode_jadi/$j'  name='no_daftar'></div>
		  	   
			   <label>NIK</label>
		<div class='form-group input-group'>
         <input type='text' class='form-control' name='nik' id='ValidNisn' maxlength='17' onkeyup=\"this.value=this.value.replace(/[^0-9]/g,'')\" / >
		</div>

				
		<label>Nama Pangilan</label>
		<div class='form-group input-group'>
        <input type='text' class='form-control'   name='nama_daftar' id='Namalengkap' onKeyUp=\"this.value=this.value.replace(/[^A-Z | a-z]/g,'')\"/ required>
</div>
<label>Nama Lengkap + Gelar</label>
		<div class='form-group input-group'>
        <input type='text' class='form-control'   name='nama_lengkap' id='Namalengkap' onKeyUp=\"this.value=this.value.replace(/[^A-Z | a-z]/g,'')\"/ required>
</div>
<label>No Hp Aktif</label>
		<div class='form-group input-group'>
         <input type='text' class='form-control' name='hp' id='ValidNisn' maxlength='13' onkeyup=\"this.value=this.value.replace(/[^0-9]/g,'')\" / >
		</div>

		<label>Tempat Tanggal Lahir</label>
		<div class='form-group input-group'>
        <input type='text' class='form-control'  name='tempat' required><span class='input-group-addon'>
		<input type='text' class='form-control' id='datepicker'  name='tgl' required>
		</div>
		
		
	<label>Alamat</label>
		<div class='form-group input-group'>
        <input type='text' class='form-control'   name='alamat' required></div>
		</div>
<div class='col-md-12'>	
<label>Jenis Kelamin</label>
		<div class='form-group input-group'>
		   <select class='form-control select2' style='width: 100%;' name='jk' id='Validjk' >
                  <option selected='selected'>Pilih Jenis Kelamin</option>
                  <option value='laki-laki'>Laki-Laki</option>
            <option value='perempuan'>perempuan</option>
                </select></div>
		<label>Alamat Lengkap Sesui KTP</label>
       	<div class='form-group input-group'>
		<textarea  class='form-control'  name=alamat style='width: 95%;'></textarea></div>	
	</div>	
	<br>

		<div class='col-md-12'>
            <button class='btn btn-primary btn-sm' type='submit'>DAFTAR</button>
            <button class='btn btn-primary btn-sm' type='reset'>Reset</button>
			<a href='index.aspx' class='btn btn-primary btn-sm'>Kembali</a></div>
   </form></div>      
    </div> ";
	 }
// Modul hubungi aksi
elseif ($_GET['module']=='prosespesan'){
$tgl_skrg = date("Y-m-d");
$jam_skrg = gmdate('H:i:s',time()+60*60*7);
    mysql_query("INSERT INTO daftar (no_daftar, nik, nama_daftar, nama_lengkap, pekerjaan, hp, alamat, ttl, jk)
             VALUES('$_POST[no_daftar]',
			 '$_POST[nik]',
			 '$_POST[nama_daftar]',
			 '$_POST[nama_lengkap]',
			 '$_POST[pekerjaan]',
			 '$_POST[hp]',
			 '$_POST[alamat]',
			 '$_POST[tempat],$_POST[tgl]',
			 '$_POST[jk]')"); 
 $ok=$_POST[no_daftar];
echo "<script>window.alert('Silahkan melanjutkan pengisian data anda, Terimakasih Banyak..... ');
        window.location=('daftarkariawan.php?no_daftar=$_POST[no_daftar]')</script>";

}
elseif ($_GET['module']=='prosesdaftarkariawan'){
echo "<script>window.alert('Data Anda Bershasil di simpan, Terimakasi Telah Mepercayai kami');
        window.location=('index.php')</script>";

}
?>
            </div>
		 
</div><!-- #main -->
   <div id="footer">
    
        <div id="copyrights">
            Copyright, <a href="index.php">SPK <?=$r3['foto']?> <?=$saiki?></a>, Networks All Rights Reserved.</div>
    </div><!-- #footer -->
    
</div><!-- #container -->
</body>
</html>