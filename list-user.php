<?php require_once('includes/init.php'); ?>
<?php cek_login($role = array(1)); ?>

<?php
$judul_page = 'List User';
require_once('template-parts/header.php');
?>
 <div class="card">
                            <h5 class="card-header">Table</h5>
                            <div class="card-body">

          
						
                            <div class="content">		
				<div class="field-wrap clearfix">
				<a class="btn btn-primary" href="tambah-user.php">Tambah admin/petugas</a>
					</div></br>
			<?php
			$query = $pdo->prepare('SELECT id_user, username, nama, role FROM user');			
			$query->execute();
			// menampilkan berupa nama field
			$query->setFetchMode(PDO::FETCH_ASSOC);
			
			if($query->rowCount() > 0):
			?>
			
			<table id='example1' class='table table-bordered table-striped'>
				<thead>
					<tr>
						<th>Username</th>
						<th>Nama</th>
						<th>Role</th>
						<th>Detail</th>
						<th>Edit</th>
						<th>Hapus</th>
					</tr>
				</thead>
				<tbody>
					<?php while($hasil = $query->fetch()): ?>
						<tr>
							<td><?php echo $hasil['username']; ?></td>
							<td><?php echo $hasil['nama']; ?></td>
							<td>
							<?php
							if($hasil['role'] == 1) {
								echo 'Administrator';
							} elseif($hasil['role'] == 2) {
								echo 'Petugas';
							}
							?>
							</td>
							<td><a href="single-user.php?id=<?php echo $hasil['id_user']; ?>"><span class="fa fa-eye"></span> Detail</a></td>
							<td><a href="edit-user.php?id=<?php echo $hasil['id_user']; ?>"><span class="fa fa-pencil"></span> Edit</a></td>
							<td><a href="hapus-user.php?id=<?php echo $hasil['id_user']; ?>" class="red yaqin-hapus"><span class="fa fa-times"></span> Hapus</a></td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>

			<?php else: ?>
				<p>Maaf, belum ada data untuk user.</p>
			<?php endif; ?>

	</div><!-- .container -->
	</div><!-- .main-content-row -->
</div><!-- .main-content-row -->


<?php
require_once('template-parts/footer.php');