<?php require_once('includes/init.php'); ?>
<?php cek_login($role = array(1)); ?>

<?php
$judul_page = 'List User';
require_once('template-parts/header.php');
?>
 <div class="card">
                            <h5 class="card-header">Table</h5>
                            <div class="card-body">

 
			<?php 
if ($_GET['module']=='home'){
 echo" 

                <div class='box-body'>
				
	 <table id='example1' class='table table-bordered table-striped'>
                    <thead>
					<tr>
	<th>No.</th>
	<th>Nama Website</th>
	<th>Judul</th>

	<th>Aksi</th>
</tr></thead>
                    <tbody>";

$tampil=mysql_query("SELECT * FROM  profil ORDER BY id_profil DESC ");
$no='$posisi'+1;
while($r=mysql_fetch_array($tampil)){
		echo "<tr><td>$no</td>
				<td>$r[foto]</td>
				<td>$r[nama]</td>

				<td><a href=data-profil.php?module=profil&id_profil=$r[id_profil]>Edit</a></td>
			</tr>";
	$no++;
}
echo "</tbody></table>
    </div>

";
}
elseif ($_GET['module']=='profil'){
 $edit=mysql_query("SELECT * FROM profil WHERE id_profil='$_GET[id_profil]'");
$r=mysql_fetch_array($edit);
echo"<section class='content'>
<div class='row'>
<div class='col-lg-12'>

<div class='row'>
                       
                        <div class='col-md-12'>
                            <div class='panel panel-default'>

                                <div class='panel-body'>

<form name='form1' id='form_combo' role='form'  method='post' action='data-profil.php?module=prosesedit'>
        <input type=hidden name=id_profil value='$r[id_profil]'>
	  <input type=hidden name=aktif value='$r[aktif]'>

		<label>Judul</label>
         <input type='text' class='form-control' name='nama' value='$r[nama]' ><br>
	
<label>Nama Spk</label>
         <input type='text' class='form-control' name='foto' value='$r[foto]' ><br>
	<label>isi</label>
	<textarea id='tinymce_basic' class='form-control' rows='5' name='isi' id='comment'>$r[isi]</textarea><script>

			CKEDITOR.replace( 'tinymce_basic', {
				fullPage: true,
				allowedContent: true,
				extraPlugins: 'wysiwygarea'
			});

		</script><br>
            <button class='btn btn-primary btn-sm' type='submit'>Simpan</button>
			<a href='javascript:history.go(-1)' class='btn btn-primary btn-sm'>Kembali</a><br /><br />
   </form> 
 
	       </div>
                        </div>
                    </div> </div> </div> </div></section>
";
}
// Modul edit
elseif ($_GET['module']=='prosesedit'){
   mysql_query("UPDATE profil SET id_profil='$_POST[id_profil]',
								nama='$_POST[nama]',
								foto='$_POST[foto]',
								isi='$_POST[isi]',
								aktif='$_POST[aktif]'
					WHERE id_profil='$_POST[id_profil]'");
  
echo "<script>window.alert('Data Anda Bershasil di simpan');
        window.location=('data-profil.php?module=home')</script>";

} 
elseif ($_GET['module']=='edikriteria'){
 $edit=mysql_query("SELECT * FROM kriteria WHERE id_kriteria='$_GET[id_kriteria]'");
$r=mysql_fetch_array($edit);
echo"<section class='content'>
<div class='row'>
<div class='col-lg-12'>

<div class='row'>
                       
                        <div class='col-md-12'>
                            <div class='panel panel-default'>

                                <div class='panel-body'>
KRITERIA
<form name='form1' id='form_combo' role='form'  method='post' action='data-profil.php?module=proseseditkriteria'>
        <input type=hidden name=id_kriteria value='$r[id_kriteria]'>
		<label>Kode Kriteria</label>
         <input type='text' class='form-control' name='nama' value='$r[nama]' ><br>
	<label>Nama Kriteria</label>
         <input type='text' class='form-control' name='kode' value='$r[kode]' ><br>
       <label>Bobot Kriteria</label>
         <input type='text' class='form-control' name='bobot' value='$r[bobot]' ><br>
	<label>Type</label>
	<select class='form-control select2' style='width: 100%;' name=type>
				<option value='$r[type]' selected>$r[type]</option>
				<option value='benefit'>Benefit</option>
				<option value='cost'>cost</option>
	</select>
		<br>
		<label>Sub Pilihan</label>
	<select class='form-control select2' style='width: 100%;' name=ada_pilihan>
				<option value='$r[ada_pilihan]' selected>";
				if($r[ada_pilihan]=='1'){ echo"
				Mengunakan Pilihan ";
		   } else{
			   echo"Mengunakan Input Manual ";
			   } echo"</option>
				<option value='1'>Mengunakan Pilihan</option>
				<option value='0'>Inputan Manual</option>
	</select>
		<br>
 <label>Urutan Kriteria</label>
         <input type='text' class='form-control' name='urutan_order' value='$r[urutan_order]' ><br>
            <button class='btn btn-primary btn-sm' type='submit'>Simpan</button>
			<a href='javascript:history.go(-1)' class='btn btn-primary btn-sm'>Kembali</a><br /><br />
   </form> ";
   if($r[ada_pilihan]=='1'){
	   echo"
	  
 <a class='btn btn-primary' href='data-profil.php?module=pilihankriteria&id_kriteria=$r[id_kriteria]'>Edit Pilihan Kriteria</a>
	       ";
		   } else{
			   echo"Mengunakan Input Manual ";
			   } echo"</div>
                        </div>
                    </div> </div> </div> </div></section>
";
}
// Modul edit
elseif ($_GET['module']=='proseseditkriteria'){
   mysql_query("UPDATE kriteria SET id_kriteria='$_POST[id_kriteria]',
								nama='$_POST[nama]',
								kode='$_POST[kode]',
								type='$_POST[type]',
								bobot='$_POST[bobot]',
								ada_pilihan='$_POST[ada_pilihan]',
								urutan_order='$_POST[urutan_order]'
					WHERE id_kriteria='$_POST[id_kriteria]'");
  
echo "<script>window.alert('Data Anda Bershasil di simpan');
        window.location=('list-kriteria.php')</script>";

} 
elseif ($_GET['module']=='pilihankriteria'){
$sql = mysql_query("SELECT * FROM pilihan_kriteria WHERE  id_kriteria='$_GET[id_kriteria]'");
$jumlah = mysql_num_rows($sql);
$sql1 = mysql_query("SELECT * FROM kriteria WHERE  id_kriteria='$_GET[id_kriteria]'");
$rt=mysql_fetch_array($sql1);	
 echo" 
                <div class='box-body'>	
				 <a class='btn btn-primary' href='data-profil.php?module=tambahpilihankriteria&id_kriteria=$rt[id_kriteria]'>Tambah Pilihan Kriteria</a>
	</br>
	 <table id='example1' class='table table-bordered table-striped'>
                    <thead>
					<tr>
	<th>No.</th>
	<th>Nama Pilihan Kriteria</th>
	<th>nilai</th>
	<th>Aksi</th>
</tr></thead>
<tbody>";
$no='$posisi'+1;
if ($jumlah > 0){
  while ($r=mysql_fetch_array($sql)){
		echo "<tr><td>$no</td>
				<td>$r[nama]</td>
				<td>$r[nilai]</td>
				<td><a href=data-profil.php?module=editpilihankriteria&id_pil_kriteria=$r[id_pil_kriteria]>Edit</a></td>
			</tr>";
	$no++;
}
echo"</tbody></table>";
}
  else{
    echo "<p align=center>Belum ada kriteria pada bagian ini.</p>";
  }
echo "
    </div>

";
}
elseif ($_GET['module']=='editpilihankriteria'){
 $edit=mysql_query("SELECT * FROM pilihan_kriteria WHERE id_pil_kriteria='$_GET[id_pil_kriteria]'");
$r=mysql_fetch_array($edit);
echo"<section class='content'>
<div class='row'>
<div class='col-lg-12'>

<div class='row'>
                       
                        <div class='col-md-12'>
                            <div class='panel panel-default'>

                                <div class='panel-body'>

<form name='form1' id='form_combo' role='form'  method='post' action='data-profil.php?module=proseseditpilihankriteria'>
       <input type=hidden name=id_pil_kriteria value='$r[id_pil_kriteria]'>
		<label>Nama Kriteria</label>
         <input type='text' class='form-control' name='nama' value='$r[nama]' ><br>
	
       <label>nilai Kriteria</label>
         <input type='text' class='form-control' name='nilai' value='$r[nilai]' ><br>
	<label>Kriteria</label>
	<select class='form-control select2' style='width: 100%;' name=id_kriteria>";
		$tampil=mysql_query("SELECT * FROM kriteria ORDER BY id_kriteria");
		while ($w=mysql_fetch_array($tampil))
		{
			if ($r[id_kriteria]==$w[id_kriteria]) {
				echo "<option value='$w[id_kriteria]' selected>$w[nama]</option>";
			}
			else {
				echo "<option value='$w[id_kriteria]'>$w[nama]</option>";
			}
		}
		echo "</select>
		<br>

 <label>Urutan sub Kriteria</label>
         <input type='text' class='form-control' name='urutan_order' value='$r[urutan_order]' ><br>
            <button class='btn btn-primary btn-sm' type='submit'>Simpan</button>
			<a href='javascript:history.go(-1)' class='btn btn-primary btn-sm'>Kembali</a><br /><br />
   </form> 
	       </div>
                        </div>
                    </div> </div> </div> </div></section>
";
}
// Modul edit
elseif ($_GET['module']=='proseseditpilihankriteria'){
   mysql_query("UPDATE pilihan_kriteria  SET id_kriteria='$_POST[id_kriteria]',
								nama='$_POST[nama]',
								nilai='$_POST[nilai]',
								urutan_order='$_POST[urutan_order]'
					WHERE id_pil_kriteria='$_POST[id_pil_kriteria]'");
  
echo "<script>window.alert('Data Anda Bershasil di simpan');
        window.location=('data-profil.php?module=pilihankriteria&id_kriteria=$_POST[id_kriteria]')</script>";

} 
elseif ($_GET['module']=='tambahpilihankriteria'){
 $edit=mysql_query("SELECT * FROM kriteria WHERE id_kriteria='$_GET[id_kriteria]'");
$r=mysql_fetch_array($edit);
echo"<section class='content'>
<div class='row'>
<div class='col-lg-12'>

                            <div class='panel panel-default'>

                                <div class='panel-body'>

<form name='form1' id='form_combo' role='form'  method='post' action='data-profil.php?module=prosinputpilihankriteria'>
       <input type=hidden name=id_kriteria value='$r[id_kriteria]'>
		<label>Nama Pilihan Kriteria</label>
         <input type='text' class='form-control' name='nama'  ><br>
	
       <label>nilai Kriteria</label>
         <input type='text' class='form-control' name='nilai'  ><br>
	<label>Kriteria</label>";
		$tampil=mysql_query("SELECT * FROM kriteria ");
		$rt=mysql_fetch_array($edit);
				echo "<input type='text' class='form-control'  value='$r[nama] ($r[id_kriteria])' disabled='disabled'><br>";
		echo "</select>
		<br>

 <label>Urutan sub Kriteria</label>
         <input type='text' class='form-control' name='urutan_order'><br>
            <button class='btn btn-primary btn-sm' type='submit'>Simpan</button>
			<a href='javascript:history.go(-1)' class='btn btn-primary btn-sm'>Kembali</a><br /><br />
   </form> 

                    </div> </div> </div> </div></section>
";
}
// Modul input
elseif ($_GET['module']=='prosinputpilihankriteria'){
    mysql_query("INSERT INTO pilihan_kriteria (id_kriteria, nama, nilai, urutan_order) 
             VALUES('$_POST[id_kriteria]',
			 '$_POST[nama]',
			 '$_POST[nilai]',
			 '$_POST[urutan_order]')"); 

  
echo "<script>window.alert('Data Anda Bershasil di simpan, Silahakan Melanjutkan Ke menu berikutnya');
        window.location=('data-profil.php?module=pilihankriteria&id_kriteria=$_POST[id_kriteria]')</script>";

}
?>


	</div><!-- .main-content-row -->
</div><!-- .main-content-row -->


<?php
require_once('template-parts/footer.php');