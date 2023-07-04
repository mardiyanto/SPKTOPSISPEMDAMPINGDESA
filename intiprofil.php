<?php

// Bagian Home
if ($_GET['module']=='home'){
 echo"  <section class='content'>
<div class='row'>

        <div class='col-xs-12'>
              <div class='panel panel-primary'>
			   <div class='table-responsive'> <div class='box-header'>
				   <h3 class='box-title'>Data Profil</h3>
                </div>
           
			</br>
				  <div class='box-header'>
 </div>
                <div class='box-body'>
				
	 <table id='example1' class='table table-bordered table-striped'>
                    <thead>
					<tr>
	<th>No.</th>
	<th>Judul</th>
	<th>Nama Website</th>
	<th>Aksi</th>
</tr></thead>
                    <tbody>";

$tebaru=mysql_query(" SELECT * FROM profil where aktif='Y' order by id_profil DESC ");
$no='$posisi'+1;
while ($t=mysql_fetch_array($tebaru)){
		echo "<tr><td>$no</td>
				<td>$t[nama]</td>
				<td>$t[foto]</td>
				<td><a href=profil.php?module=edit&id_p=$t[id_profil]>Edit</a> |
				<a href=profil.php?module=proseshapus&id=$t[id_profil]&namafile=$t[foto]>Hapus</a></td>
			</tr>";
	$no++;
}
echo "</tbody></table>
    </div>
                        </div>
                    </div> </div> </div> </div></section>";
}

elseif ($_GET['module']=='halaman'){
 echo"  <section class='content'>
<div class='row'>

        <div class='col-xs-12'>
              <div class='panel panel-primary'>
			   <div class='table-responsive'> <div class='box-header'>
				   <h3 class='box-title'>Data Profil</h3>
                </div>
                <div class='box-header'>
				<button class='btn btn-primary btn-sm' type='submit' onclick=\"window.location.href='proses.php?module=input';\">Tambah</button>
				</div>
			</br>
				  <div class='box-header'>
 </div>
                <div class='box-body'>
				
		 <table id='example1' class='table table-bordered table-striped'>
                    <thead>
					<tr>
	<th>No.</th>
	<th>Judul</th>
	<th>Aksi</th>
</tr></thead>
                    <tbody>";

$tebaru=mysql_query(" SELECT * FROM profil where aktif='N' order by id_profil DESC ");
$no='$posisi'+1;
while ($t=mysql_fetch_array($tebaru)){
		echo "<tr><td>$no</td>
				<td>$t[nama]</td>
				<td><a href=profil.php?module=edit&id_p=$t[id_profil]>Edit</a> |
				<a href=profil.php?module=proseshapus&id=$t[id_profil]&namafile=$t[foto]>Hapus</a></td>
			</tr>";
	$no++;
}
echo "</tbody></table>
    </div>
                        </div>
                    </div> </div> </div> </div></section>";
}


?>