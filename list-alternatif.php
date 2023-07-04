<?php require_once('includes/init.php'); ?>
<?php cek_login($role = array(1, 2)); ?>

<?php
$judul_page = 'List alternatif';
require_once('template-parts/header.php');
?>

 <div class="card">
                            <h5 class="card-header">Table</h5>
                            <div class="card-body">
                            <div class="header">
                                <h4 class="title">Alternatif</h4>
                                <p class="category">Input Alternatif Setiap Kriteria</p>
                            </div>
						
                            <div class="content">		
				<div class="field-wrap clearfix">
				<a class="btn btn-primary" href="tambah-alternatif.php">Tambah Alternatif</a>
					</div></br>
			<?php
			$status = isset($_GET['status']) ? $_GET['status'] : '';
			$msg = '';
			switch($status):
				case 'sukses-baru':
					$msg = 'Data alternatif baru berhasil ditambahkan';
					break;
				case 'sukses-hapus':
					$msg = 'alternatif behasil dihapus';
					break;
				case 'sukses-edit':
					$msg = 'alternatif behasil diedit';
					break;
			endswitch;
			
			if($msg):
				echo '<div class="msg-box msg-box-full">';
				echo '<p><span class="fa fa-bullhorn"></span> &nbsp; '.$msg.'</p>';
				echo '</div>';
			endif;
			?>
			
			<?php
			$query = $pdo->prepare('SELECT * FROM alternatif');			
			$query->execute();
			// menampilkan berupa nama field
			$query->setFetchMode(PDO::FETCH_ASSOC);
			
			if($query->rowCount() > 0):
			?>
			
			<table id='example1' class='table table-bordered table-striped'>
				<thead>
					<tr>
						<th>Kode</th>
						<th>Nama</th>
						<th>Detail</th>						
						<th>Edit</th>
						<th>Hapus</th>
					</tr>
				</thead>
				<tbody>
					<?php while($hasil = $query->fetch()): ?>
						<tr>
							<td><?php echo $hasil['no_alternatif']; ?></td>							
							<td><?php echo $hasil['ciri_khas']; ?></td>							
							<td><a href="single-alternatif.php?id=<?php echo $hasil['id_alternatif']; ?>"><span class="fa fa-eye"></span> Detail</a></td>
							<td><a href="edit-alternatif.php?id=<?php echo $hasil['id_alternatif']; ?>"><span class="fa fa-pencil"></span> Edit</a></td>
							<td><a href="hapus-alternatif.php?id=<?php echo $hasil['id_alternatif']; ?>" class="red yaqin-hapus"><span class="fa fa-times"></span> Hapus</a></td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
			
			
			<!-- STEP 1. Matriks Keputusan(X) ==================== -->
			<?php
			// Fetch semua kriteria
			$query = $pdo->prepare('SELECT id_kriteria, nama, type, bobot FROM kriteria
				ORDER BY urutan_order ASC');
			$query->execute();			
			$kriterias = $query->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_UNIQUE);
			
			// Fetch semua alternatif
			$query2 = $pdo->prepare('SELECT id_alternatif, no_alternatif FROM alternatif');
			$query2->execute();			
			$query2->setFetchMode(PDO::FETCH_ASSOC);
			$alternatifs = $query2->fetchAll();			
			?>
			
			<h3>Matriks Keputusan (X)</h3>
			<table id='example1' class='table table-bordered table-striped'>
				<thead>
					<tr class="super-top">
						<th rowspan="2" class="super-top-left">No. alternatif</th>
						<th colspan="<?php echo count($kriterias); ?>">Kriteria</th>
					</tr>
					<tr>
						<?php foreach($kriterias as $kriteria ): ?>
							<th><?php echo $kriteria['nama']; ?></th>
						<?php endforeach; ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach($alternatifs as $alternatif): ?>
						<tr>
							<td><?php echo $alternatif['no_alternatif']; ?></td>
							<?php
							// Ambil Nilai
							$query3 = $pdo->prepare('SELECT id_kriteria, nilai FROM nilai_alternatif
								WHERE id_alternatif = :id_alternatif');
							$query3->execute(array(
								'id_alternatif' => $alternatif['id_alternatif']
							));			
							$query3->setFetchMode(PDO::FETCH_ASSOC);
							$nilais = $query3->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_UNIQUE);
							
							foreach($kriterias as $id_kriteria => $values):
								echo '<td>';
								if(isset($nilais[$id_kriteria])) {
									echo $nilais[$id_kriteria]['nilai'];
									$kriterias[$id_kriteria]['nilai'][$alternatif['id_alternatif']] = $nilais[$id_kriteria]['nilai'];
								} else {
									echo 0;
									$kriterias[$id_kriteria]['nilai'][$alternatif['id_alternatif']] = 0;
								}
								
								if(isset($kriterias[$id_kriteria]['tn_kuadrat'])){
									$kriterias[$id_kriteria]['tn_kuadrat'] += pow($kriterias[$id_kriteria]['nilai'][$alternatif['id_alternatif']], 2);
								} else {
									$kriterias[$id_kriteria]['tn_kuadrat'] = pow($kriterias[$id_kriteria]['nilai'][$alternatif['id_alternatif']], 2);
								}
								echo '</td>';
							endforeach;
							?>
							</pre>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

			<?php else: ?>
				<p>Maaf, belum ada data untuk alternatif.</p>
			<?php endif; ?>
	</div><!-- .container -->
	</div><!-- .main-content-row -->
</div><!-- .main-content-row -->

<?php
require_once('template-parts/footer.php');