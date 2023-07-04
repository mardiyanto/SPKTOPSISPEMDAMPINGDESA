<?php require_once('includes/init.php'); ?>

<?php
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
}
?>

<?php
$judul_page = 'Detail alternatif';
require_once('template-parts/header.php');
?>
 <div class="card">
                            <h5 class="card-header">Table</h5>
                            <div class="card-body">
                            <div class="header">
                                <h4 class="title">Alternatif</h4>
                                <p class="category">detail Alternatif</p>
                            </div>
						
                            <div class="content">	
			
			<?php if($ada_error): ?>
			
				<?php echo '<p>'.$ada_error.'</p>'; ?>
				
			<?php elseif(!empty($result)): ?>
			
				<h4>Kode</h4>
				<p><?php echo $result['no_alternatif']; ?></p>
				
				<h4>Nama</h4>
				<p><?php echo nl2br($result['ciri_khas']); ?></p>
				
				<h4>Tanggal Input</h4>
				<p><?php
					$tgl = strtotime($result['tanggal_input']);
					echo date('j F Y', $tgl);
				?></p>
				
				<?php
				$query2 = $pdo->prepare('SELECT nilai_alternatif.nilai AS nilai, kriteria.nama AS nama FROM kriteria 
				LEFT JOIN nilai_alternatif ON nilai_alternatif.id_kriteria = kriteria.id_kriteria 
				AND nilai_alternatif.id_alternatif = :id_alternatif ORDER BY kriteria.urutan_order ASC');
				$query2->execute(array(
					'id_alternatif' => $id_alternatif
				));
				$query2->setFetchMode(PDO::FETCH_ASSOC);
				$kriterias = $query2->fetchAll();
				if(!empty($kriterias)):
				?>
					
					<table class='table table-bordered table-striped'>
						<thead>
							<tr>
								<?php foreach($kriterias as $kriteria ): ?>
									<th><?php echo $kriteria['nama']; ?></th>
								<?php endforeach; ?>
							</tr>
						</thead>
						<tbody>
							<tr>
								<?php foreach($kriterias as $kriteria ): ?>
									<th><?php echo ($kriteria['nilai']) ? $kriteria['nilai'] : 0; ?></th>
								<?php endforeach; ?>
							</tr>
						</tbody>
					</table>
				<?php
				endif;
				?>

				<p><a href="edit-alternatif.php?id=<?php echo $id_alternatif; ?>" class="button"><span class="fa fa-pencil"></span> Edit</a> &nbsp; <a href="hapus-alternatif.php?id=<?php echo $id_alternatif; ?>" class="button button-red yaqin-hapus"><span class="fa fa-times"></span> Hapus</a></p>
			
			<?php endif; ?>			

                </div>
	</div><!-- .container -->
	</div><!-- .main-content-row -->


<?php
require_once('template-parts/footer.php');