<?php
/* ---------------------------------------------
 * SPK SAW
 * Author: Zunan Arif Rahmanto - 15111131
 * ------------------------------------------- */

/* ---------------------------------------------
 * Konek ke database & load fungsi-fungsi
 * ------------------------------------------- */
require_once('includes/init.php');

/* ---------------------------------------------
 * Load Header
 * ------------------------------------------- */
$judul_page = 'Perankingan Menggunakan Metode WP';
require_once('template-parts/header.php');

/* ---------------------------------------------
 * Set jumlah digit di belakang koma
 * ------------------------------------------- */
$digit = 4;

/* ---------------------------------------------
 * Fetch semua kriteria
 * ------------------------------------------- */
$query = $pdo->prepare('SELECT id_kriteria, nama, type, bobot
	FROM kriteria ORDER BY urutan_order ASC');
$query->execute();
$query->setFetchMode(PDO::FETCH_ASSOC);
$kriterias = $query->fetchAll();

/* ---------------------------------------------
 * Fetch semua alternatif (alternatif)
 * ------------------------------------------- */
$query2 = $pdo->prepare('SELECT id_alternatif, no_alternatif FROM alternatif');
$query2->execute();			
$query2->setFetchMode(PDO::FETCH_ASSOC);
$alternatifs = $query2->fetchAll();


/* >>> STEP 1 ===================================
 * Matrix Keputusan (X)
 * ------------------------------------------- */
$matriks_x = array();
$list_kriteria = array();
foreach($kriterias as $kriteria):
	$list_kriteria[$kriteria['id_kriteria']] = $kriteria;
	foreach($alternatifs as $alternatif):
		
		$id_alternatif = $alternatif['id_alternatif'];
		$id_kriteria = $kriteria['id_kriteria'];
		
		// Fetch nilai dari db
		$query3 = $pdo->prepare('SELECT nilai FROM nilai_alternatif
			WHERE id_alternatif = :id_alternatif AND id_kriteria = :id_kriteria');
		$query3->execute(array(
			'id_alternatif' => $id_alternatif,
			'id_kriteria' => $id_kriteria,
		));			
		$query3->setFetchMode(PDO::FETCH_ASSOC);
		if($nilai_alternatif = $query3->fetch()) {
			// Jika ada nilai kriterianya
			$matriks_x[$id_kriteria][$id_alternatif] = $nilai_alternatif['nilai'];
		} else {			
			$matriks_x[$id_kriteria][$id_alternatif] = 0;
		}

	endforeach;
endforeach;


/* >>> STEP 3 ================================
 * Pembobotan
 * ------------------------------------------- */	
//skrip yang di paker penjumlahan bobot w
$query5 = $pdo->prepare('SELECT sum(bobot) as hasilbb FROM kriteria');
$query5->execute();
$query5->setFetchMode(PDO::FETCH_ASSOC);
$result = $query5->fetch();
$bobot_w = $result['hasilbb'];
/* >>> STEP 4 ===================================
 * Matriks Ternormalisasi (R)
 * ------------------------------------------- */
$matriks_ri = array();
foreach($kriterias as $kriteria):
	$tipe = $list_kriteria[$id_kriteria]['type'];
	$kriteria['bobot'];
	$bagi=$kriteria['bobot']/round($bobot_w, $digit);
	$ww= $matriks_x[$id_kriteria][$id_alternatif];
		if($tipe == 'benefit') {
			$nilai_normal = pow($ww,$bagi);;
		} elseif($tipe == 'cost') {
			$nilai_normal = pow($ww,-$bagi);
		}
		$matriks_ri[$id_kriteria] = $nilai_normal;
endforeach;


/* >>> STEP 3 ===================================
 * Matriks Ternormalisasi (R)
 * ------------------------------------------- */
$matriks_r = array();
foreach($matriks_x as $id_kriteria => $nilai_alternatifs):
	
	$tipe = $list_kriteria[$id_kriteria]['type'];
	foreach($nilai_alternatifs as $id_alternatif => $nilai) {
		if($tipe == 'benefit') {
			$nilai_normal = $nilai / max($nilai_alternatifs);
		} elseif($tipe == 'cost') {
			$nilai_normal = min($nilai_alternatifs) / $nilai;
		}
		
		$matriks_r[$id_kriteria][$id_alternatif] = $nilai_normal;
	}
	
endforeach;


/* >>> STEP 4 ================================
 * Perangkingan
 * ------------------------------------------- */
$ranks = array();
foreach($alternatifs as $alternatif):

	$total_nilai = 0;
	foreach($list_kriteria as $kriteria) {
	
		$bobot = $kriteria['bobot'];
		$id_alternatif = $alternatif['id_alternatif'];
		$id_kriteria = $kriteria['id_kriteria'];
		
		$nilai_r = $matriks_r[$id_kriteria][$id_alternatif];
		$total_nilai = $total_nilai + ($bobot * $nilai_r);

	}
	
	$ranks[$alternatif['id_alternatif']]['id_alternatif'] = $alternatif['id_alternatif'];
	$ranks[$alternatif['id_alternatif']]['no_alternatif'] = $alternatif['no_alternatif'];
	$ranks[$alternatif['id_alternatif']]['nilai'] = $total_nilai;
	
endforeach
 
?>

<div class="main-content-row">
<div class="container clearfix">	

	<div class="main-content main-content-full the-content">
		
		<h1><?php echo $judul_page; ?></h1>
		
		<!-- STEP 1. Matriks Keputusan(X) ==================== -->		
		<h3>Step 1: Matriks Keputusan (X)</h3>
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
						foreach($kriterias as $kriteria):
							$id_alternatif = $alternatif['id_alternatif'];
							$id_kriteria = $kriteria['id_kriteria'];
							echo '<td>';
							echo $matriks_x[$id_kriteria][$id_alternatif];
							echo '</td>';
						endforeach;
						?>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<!-- STEP 2. Bobot Preferensi (W) ==================== -->
		<h3>Step 2: Bobot Preferensi (W)</h3>			
		<table id='example1' class='table table-bordered table-striped'>
			<thead>
				<tr>
					<th>Nama Kriteria</th>
					<th>Type</th>
					<th>Bobot (W)</th>	
<th>pembagi(W)</th>					
				</tr>
			</thead>
			<tbody>
				<?php foreach($kriterias as $hasil): ?>
					<tr>
						<td><?php echo $hasil['nama']; ?></td>
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
                        <td>
						<?php echo $hasil['bobot']/round($bobot_w, $digit); ?></td>							
					</tr>
				<?php endforeach; ?>
				
				
				<tr><td>Jumlah Bobot</td>
				<td></td>
				<td>=</td>
				<td><?php echo round($bobot_w, $digit); ?></td>
				</tr>
			</tbody>
		</table>
		
		<!-- Step 3: Matriks Ternormalisasi (R) ==================== -->
		<h3>Step 3: Matriks Ternormalisasi (R)</h3>			
		<table id='example1' class='table table-bordered table-striped'>
			<thead>
				<tr class="super-top">
					<th rowspan="3" class="super-top-left">No. alternatif</th>
					
					<th colspan="<?php echo count($kriterias); ?>">Kriteria dan terbobot W</th>
					<th rowspan="3">Vektor S</th>
					<th rowspan="3">Preferensi (Vi)</th>
				</tr>
				
				<tr>
					<?php foreach($kriterias as $kriteria ): ?>
						<th><?php echo $kriteria['nama']; ?></th>
						
					<?php endforeach; ?>
				</tr>
				<tr>
					<?php foreach($kriterias as $kriteria ): ?>
						<th><?php echo $kriteria['bobot']/round($bobot_w, $digit); ?></th>
					<?php endforeach; ?>
				</tr>
			</thead>
			<tbody>
				<?php foreach($alternatifs as $alternatif): ?>
					<tr>
						<td><?php echo $alternatif['no_alternatif']; ?></td>
						<?php						
						foreach($kriterias as $kriteria):
						    
							$id_alternatif = $alternatif['id_alternatif'];
							$id_kriteria = $kriteria['id_kriteria'];
							$kriteria['bobot'];
							$bagi=$kriteria['bobot']/round($bobot_w, $digit);
							$ww= $matriks_x[$id_kriteria][$id_alternatif];
						if($hasil['type'] == 'benefit') {
							$ww1= pow($ww,$bagi);
						} elseif($hasil['type'] == 'cost') {
							$ww1= pow($ww,-$bagi);
						}	
							echo '<td>';
							echo round($ww1, $digit);
							echo '</td>';
							
						endforeach;
						?>
						<td> <?php echo round($ww1, $digit); ?></td>
						<td> saya</td>
					</tr>
					
				<?php endforeach; ?>				
			</tbody>
		</table>		
		
		
		<!-- Step 4: Perangkingan ==================== -->
		<?php		
		$sorted_ranks = $ranks;		
		// Sorting
		if(function_exists('array_multisort')):
			$no_alternatif = array();
			$nilai = array();
			foreach ($sorted_ranks as $key => $row) {
				$no_alternatif[$key]  = $row['no_alternatif'];
				$nilai[$key] = $row['nilai'];
			}
			array_multisort($nilai, SORT_DESC, $no_alternatif, SORT_ASC, $sorted_ranks);
		endif;
		?>		
		<h3>Step 4: Vektor S dan Preferensi (Vi) </h3>			
		<table id='example1' class='table table-bordered table-striped'>
			<thead>					
				<tr>
					<th class="super-top-left">No. alternatif</th>
					<th>Vektor S</th>
					<th>Preferensi (Vi)</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($sorted_ranks as $alternatif ): ?>
					<tr>
						<td><?php echo $alternatif['no_alternatif']; ?></td>
						<td><?php echo round($alternatif['nilai'], $digit); ?></td>	
                        <td><?php echo round($alternatif['nilai'], $digit); ?></td>						
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>			
		
	</div>

</div><!-- .container -->
</div><!-- .main-content-row -->

<?php
require_once('template-parts/footer.php');