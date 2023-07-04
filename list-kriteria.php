<?php require_once('includes/init.php'); ?>
<?php cek_login($role = array(1)); ?>

<?php
$judul_page = 'List Kriteria';
require_once('template-parts/header.php');
?>
 <div class="card">
                            <h5 class="card-header">Table</h5>
                            <div class="card-body">
                            <div class="header">
                                <h4 class="title">Kriteria</h4>
                                <p class="category">Input Kriteria</p>
                            </div>
						
                            <div class="content">		
				<div class="field-wrap clearfix">
				<a class="btn btn-primary" href="tambah-kriteria.php">Tambah Kriteria</a>
					</div></br>
			
			<?php
			$status = isset($_GET['status']) ? $_GET['status'] : '';
			$msg = '';
			switch($status):
				case 'sukses-baru':
					$msg = 'Kriteria baru berhasil dibuat';
					break;
				case 'sukses-hapus':
					$msg = 'Kriteria behasil dihapus';
					break;
				case 'sukses-edit':
					$msg = 'Kriteria behasil diedit';
					break;
			endswitch;
			
			if($msg):
				echo '<div class="msg-box msg-box-full">';
				echo '<p><span class="fa fa-bullhorn"></span> &nbsp; '.$msg.'</p>';
				echo '</div>';
			endif;
			?>
			
			<?php
			$query = $pdo->prepare('SELECT * FROM kriteria ORDER BY urutan_order ASC');			
			$query->execute();
			// menampilkan berupa nama field
			$query->setFetchMode(PDO::FETCH_ASSOC);
			
			if($query->rowCount() > 0):
			?>
			
			<table id='example1' class='table table-bordered table-striped'>
				<thead>
					<tr>
						<th>Nama Kriteria</th>
						<th>Type</th>
						<th>Bobot</th>
						<th>aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php while($hasil = $query->fetch()): ?>
						<tr>
							<td><?php echo $hasil['kode']; ?> (<?php echo $hasil['nama']; ?>)</td>
							<td>
							<?php
							if($hasil['type'] == 'benefit') {
								echo 'Benefit';
							} elseif($hasil['type'] == 'cost') {
								echo 'Cost';
							}
							?>
							</td>
							<td><?php echo $hasil['bobot']; ?></td>							
							<td><a href="data-profil.php?module=edikriteria&id_kriteria=<?php echo $hasil['id_kriteria']; ?>"><span class="fa fa-pencil"></span> Edit</a>|
							<a href="hapus-kriteria.php?id=<?php echo $hasil['id_kriteria']; ?>" class="red yaqin-hapus"><span class="fa fa-times"></span> Hapus</a></td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>

			<?php else: ?>
				<p>Maaf, belum ada data untuk kriteria.</p>
			<?php endif; ?>

                </div>
	</div><!-- .container -->
	</div><!-- .main-content-row -->


<?php
require_once('template-parts/footer.php');