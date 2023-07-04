<?php require_once('includes/init.php'); ?>
<?php cek_login($role = array(1, 2)); ?>

<?php
$errors = array();
$sukses = false;

$no_alternatif = (isset($_POST['no_alternatif'])) ? trim($_POST['no_alternatif']) : '';
$ciri_khas = (isset($_POST['ciri_khas'])) ? trim($_POST['ciri_khas']) : '';
$warna = (isset($_POST['warna'])) ? trim($_POST['warna']) : '';
$kriteria = (isset($_POST['kriteria'])) ? $_POST['kriteria'] : array();


if(isset($_POST['submit'])):	
	
	// Validasi
	if(!$no_alternatif) {
		$errors[] = 'Nomor alternatif tidak boleh kosong';
	}	
	// Validasi
	if(!$warna) {
		$errors[] = 'warna tidak boleh kosong';
	}
	
	// Jika lolos validasi lakukan hal di bawah ini
	if(empty($errors)):
		
		$handle = $pdo->prepare('INSERT INTO alternatif (no_alternatif, ciri_khas, warna, tanggal_input) 
			VALUES (:no_alternatif, :ciri_khas, :warna, :tanggal_input)');
		$handle->execute( array(
			'no_alternatif' => $no_alternatif,
			'ciri_khas' => $ciri_khas,
			'warna' => $warna,
			'tanggal_input' => date('Y-m-d')
		) );
		$sukses = "alternatif no. <strong>{$no_alternatif}</strong> berhasil dimasukkan.";
		$id_alternatif = $pdo->lastInsertId();
		
		// Jika ada kriteria yang diinputkan:
		if(!empty($kriteria)):
			foreach($kriteria as $id_kriteria => $nilai):
				$handle = $pdo->prepare('INSERT INTO nilai_alternatif (id_alternatif, id_kriteria, nilai) VALUES (:id_alternatif, :id_kriteria, :nilai)');
				$handle->execute( array(
					'id_alternatif' => $id_alternatif,
					'id_kriteria' => $id_kriteria,
					'nilai' =>$nilai
				) );
			endforeach;
		endif;
		
		redirect_to('list-alternatif.php?status=sukses-baru');		
		
	endif;

endif;
?>

<?php
$judul_page = 'Tambah alternatif';
require_once('template-parts/header.php');
?>
 <div class="card">
                            <h5 class="card-header">Table</h5>
                            <div class="card-body">
                            <div class="header">
                                <h4 class="title">Tambah alternatif</h4>
                 
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
			
			
				<form action="tambah-alternatif.php" method="post">
					<div class="field-wrap clearfix">					
						<label>Kode Alternatif <span class="red">*</span></label>
						<input class="form-control" type="text" name="no_alternatif" value="<?php echo $no_alternatif; ?>">
					</div>					
					<div class="field-wrap clearfix">					
						<label>Nama Alternatif</label>
						<input class="form-control" type="text" name="ciri_khas" value="<?php echo $ciri_khas; ?>">
					</div>			
					 <div class="form-group">
                <label>Gambar Untuk Grafik:</label>

                <div id="my-colorpicker2" class="input-group my-colorpicker2">
                  <input type="text" name="warna" class="form-control">

                  <div class="input-group-addon">
                    <i></i>
                  </div>
                </div>
                <!-- /.input group -->
              </div>
					<h3>Nilai Kriteria</h3>
					<?php
					$query = $pdo->prepare('SELECT id_kriteria, nama, ada_pilihan FROM kriteria ORDER BY urutan_order ASC');			
					$query->execute();
					// menampilkan berupa nama field
					$query->setFetchMode(PDO::FETCH_ASSOC);
					
					if($query->rowCount() > 0):
					
						while($kriteria = $query->fetch()):							
						?>
						
							<div class="field-wrap clearfix">					
								<label><?php echo $kriteria['nama']; ?></label>
								<?php if(!$kriteria['ada_pilihan']): ?>
									<input class="form-control" type="number" step="0.001" name="kriteria[<?php echo $kriteria['id_kriteria']; ?>]">								
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
											<option value="<?php echo $hasl['nilai']; ?>"><?php echo $hasl['nama']; ?></option>
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
						<button type="submit" name="submit" value="submit" class="btn btn-primary">Tambah alternatif</button>
					</div>
				</form>


                </div>
	</div><!-- .container -->
	</div><!-- .main-content-row -->

<?php
require_once('template-parts/footer.php');