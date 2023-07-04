<?php require_once('includes/init.php'); ?>
<?php cek_login($role = array(1)); ?>

<?php
$ada_error = false;
$result = '';

$id_kriteria = (isset($_GET['id'])) ? trim($_GET['id']) : '';

if(!$id_kriteria) {
	$ada_error = 'Maaf, data tidak dapat diproses.';
} else {
	$query = $pdo->prepare('SELECT * FROM kriteria WHERE kriteria.id_kriteria = :id_kriteria');
	$query->execute(array('id_kriteria' => $id_kriteria));
	$result = $query->fetch();
	
	if(empty($result)) {
		$ada_error = 'Maaf, data tidak dapat diproses.';
	}
}
?>

<?php
$judul_page = 'Detail Kriteria';
require_once('template-parts/header.php');
?>
 <div class="card">
                            <h5 class="card-header">Table</h5>
                            <div class="card-body">
                            <div class="header">
                                <h4 class="title">Kriteria</h4>
                                <p class="category">detail Kriteria</p>
                            </div>
						
                            <div class="content">	
			
			
			<?php if($ada_error): ?>
			
				<?php echo '<p>'.$ada_error.'</p>'; ?>
				
			<?php elseif(!empty($result)): ?>
			
				<h4>Nama Kriteria</h4>
				<p><?php echo $result['nama']; ?></p>
				
				<h4>Type Kriteria</h4>
				<p><?php
				if($result['type'] == 'benefit') {
					echo 'Benefit (keuntungan)';
				} elseif($result['type'] == 'cost') {
					echo 'Cost (kerugian)';
				}
				?></p>
				
				<h4>Bobot Kriteria</h4>
				<p><?php echo $result['bobot']; ?></p>
				
				<h4>Urutan</h4>
				<p><?php echo $result['urutan_order']; ?></p>

				
				<p><a href="edit-kriteria.php?id=<?php echo $id_kriteria; ?>" class="button"><span class="fa fa-pencil"></span> Edit</a> &nbsp; <a href="hapus-kriteria.php?id=<?php echo $id_kriteria; ?>" class="button button-red yaqin-hapus"><span class="fa fa-times"></span> Hapus</a></p>
			
			
			<?php endif; ?>

                </div>
	</div><!-- .container -->
	</div><!-- .main-content-row -->

<?php
require_once('template-parts/footer.php');