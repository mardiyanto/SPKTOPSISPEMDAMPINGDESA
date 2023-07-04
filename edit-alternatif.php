<?php require_once('includes/init.php'); ?>
<?php cek_login($role = array(1, 2)); ?>

<?php
$errors = array();
$sukses = false;

$ada_error = false;
$result = '';

$id_alternatif = (isset($_GET['id'])) ? trim($_GET['id']) : '';

if(!$id_alternatif) {
	$ada_error = 'Maaf, data tidak dapat diproses.';
} else {
	$query = $pdo->prepare('SELECT * FROM alternatif WHERE id_alternatif = :id_alternatif');
	$query->execute(array('id_alternatif' => $id_alternatif));
	$result = $query->fetch();
	
	if(empty($result)) {
		$ada_error = 'Maaf, data tidak dapat diproses.';
	}

	$id_alternatif = (isset($result['id_alternatif'])) ? trim($result['id_alternatif']) : '';
	$no_alternatif = (isset($result['no_alternatif'])) ? trim($result['no_alternatif']) : '';
	$ciri_khas = (isset($result['ciri_khas'])) ? trim($result['ciri_khas']) : '';
	$warna = (isset($result['warna'])) ? trim($result['warna']) : '';
	$tanggal_input = (isset($result['tanggal_input'])) ? trim($result['tanggal_input']) : '';
}

if(isset($_POST['submit'])):	
	
	$no_alternatif = (isset($_POST['no_alternatif'])) ? trim($_POST['no_alternatif']) : '';
	$ciri_khas = (isset($_POST['ciri_khas'])) ? trim($_POST['ciri_khas']) : '';
	$warna = (isset($_POST['warna'])) ? trim($_POST['warna']) : '';
	$tanggal_input = (isset($_POST['tanggal_input'])) ? trim($_POST['tanggal_input']) : '';
	$kriteria = (isset($_POST['kriteria'])) ? $_POST['kriteria'] : array();
	
	// Validasi ID alternatif
	if(!$id_alternatif) {
		$errors[] = 'ID alternatif tidak ada';
	}
	// Validasi
	if(!$no_alternatif) {
		$errors[] = 'Nomor alternatif tidak boleh kosong';
	}
	// Validasi
	if(!$warna) {
		$errors[] = 'warna untuk grafik tidak boleh kosong';
	}
	if(!$tanggal_input) {
		$errors[] = 'Tanggal input tidak boleh kosong';
	}
	
	// Jika lolos validasi lakukan hal di bawah ini
	if(empty($errors)):
		
		$prepare_query = 'UPDATE alternatif SET no_alternatif = :no_alternatif, ciri_khas = :ciri_khas, warna = :warna, tanggal_input = :tanggal_input WHERE id_alternatif = :id_alternatif';
		$data = array(
			'no_alternatif' => $no_alternatif,
			'ciri_khas' => $ciri_khas,
			'warna' => $warna,
			'tanggal_input' => $tanggal_input,
			'id_alternatif' => $id_alternatif,
		);		
		$handle = $pdo->prepare($prepare_query);		
		$sukses = $handle->execute($data);
		
		if(!empty($kriteria)):
			foreach($kriteria as $id_kriteria => $nilai):
				$handle = $pdo->prepare('INSERT INTO nilai_alternatif (id_alternatif, id_kriteria, nilai) 
				VALUES (:id_alternatif, :id_kriteria, :nilai)
				ON DUPLICATE KEY UPDATE nilai = :nilai');
				$handle->execute( array(
					'id_alternatif' => $id_alternatif,
					'id_kriteria' => $id_kriteria,
					'nilai' =>$nilai
				) );
			endforeach;
		endif;
		
		redirect_to('list-alternatif.php?status=sukses-edit');
	
	endif;

endif;
?>

<?php
$judul_page = 'Edit alternatif';
require_once('template-parts/header.php');
?>
 <div class="card">
                            <h5 class="card-header">Table</h5>
                            <div class="card-body">
                            <div class="header">
                                <h4 class="title">edit alternatif</h4>
                 
                            </div>
						
                            <div class="content">
			
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
			
			<?php if($sukses): ?>
			
				<div class="msg-box">
					<p>Data berhasil disimpan</p>
				</div>	
				
			<?php elseif($ada_error): ?>
				
				<p><?php echo $ada_error; ?></p>
			
			<?php else: ?>				
				
				<form action="edit-alternatif.php?id=<?php echo $id_alternatif; ?>" method="post">
					<div class="field-wrap clearfix">					
						<label>Kode Alternatif <span class="red">*</span></label>
						<input class="form-control" type="text" name="no_alternatif" value="<?php echo $no_alternatif; ?>">
					</div>					
					<div class="field-wrap clearfix">					
						<label>Nama Alternatif</label>
						<input class="form-control" type="text" name="ciri_khas" value="<?php echo $ciri_khas; ?>" >
					</div>
						 <div class="form-group">
                <label>Gambar Untuk Grafik:</label>

                <div id="my-colorpicker2" class="input-group my-colorpicker2">
                  <input type="text" name="warna" value="<?php echo $warna; ?>" class="form-control" >

                  <div class="input-group-addon">
                    <i></i>
                  </div>
                </div>
                <!-- /.input group -->
              </div>
			  
					<div class="field-wrap clearfix">					
						<label>Tanggal Input <span class="red">*</span></label>
						<input class="form-control" id="datepicker" type="text" name="tanggal_input" value="<?php echo $tanggal_input; ?>" class="datepicker">
					</div>	
					
					<h3>Nilai Kriteria</h3>
					<?php
					$query2 = $pdo->prepare('SELECT nilai_alternatif.nilai AS nilai, kriteria.nama AS nama, kriteria.id_kriteria AS id_kriteria, kriteria.ada_pilihan AS jenis_nilai 
					FROM kriteria LEFT JOIN nilai_alternatif 
					ON nilai_alternatif.id_kriteria = kriteria.id_kriteria 
					AND nilai_alternatif.id_alternatif = :id_alternatif 
					ORDER BY kriteria.urutan_order ASC');
					$query2->execute(array(
						'id_alternatif' => $id_alternatif
					));
					$query2->setFetchMode(PDO::FETCH_ASSOC);
					
					if($query2->rowCount() > 0):
					
						while($kriteria = $query2->fetch()):
						?>
							<div class="field-wrap clearfix">					
								<label><?php echo $kriteria['nama']; ?></label>
								<?php if(!$kriteria['jenis_nilai']): ?>
									<input class="form-control" type="number" step="0.001" name="kriteria[<?php echo $kriteria['id_kriteria']; ?>]" value="<?php echo ($kriteria['nilai']) ? $kriteria['nilai'] : 0; ?>">								
								<?php else: ?>
									<select class="form-control" name="kriteria[<?php echo $kriteria['id_kriteria']; ?>]">
										<option value="0">-- Pilih Variabel --</option>
										<?php
										$query3 = $pdo->prepare('SELECT * FROM pilihan_kriteria WHERE id_kriteria = :id_kriteria ORDER BY urutan_order ASC');			
										$query3->execute(array(
											'id_kriteria' => $kriteria['id_kriteria']
										));
										// menampilkan berupa nama field
										$query3->setFetchMode(PDO::FETCH_ASSOC);
										if($query3->rowCount() > 0): while($hasl = $query3->fetch()):
										?>
											<option value="<?php echo $hasl['nilai']; ?>" <?php selected($kriteria['nilai'], $hasl['nilai']); ?>><?php echo $hasl['nama']; ?></option>
										<?php
										endwhile; endif;
										?>
									</select>
								<?php endif; ?>
							</div>		
						<?php
						endwhile;
						
					else:					
						echo '<p>Kriteria masih kosong.</p>';						
					endif;
					?>
					</br>
					<div class="field-wrap clearfix">
						<button type="submit" name="submit" value="submit" class="btn btn-primary">Simpan alternatif</button>
					</div>
				</form>
				
			<?php endif; ?>			

                </div>
	</div><!-- .container -->
	</div><!-- .main-content-row -->

<?php
require_once('template-parts/footer.php');