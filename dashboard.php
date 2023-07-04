<!DOCTYPE html>
<?php
/* ---------------------------------------------
 * Konek ke database & load fungsi-fungsi
 * ------------------------------------------- */
require_once('includes/init.php');

/* ---------------------------------------------
 * Load Header
 * ------------------------------------------- */
$judul_page = 'Perankingan Menggunakan Metode SAW';

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
$query2 = $pdo->prepare('SELECT id_alternatif, ciri_khas, no_alternatif, warna FROM alternatif');
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
	$ranks[$alternatif['id_alternatif']]['ciri_khas'] = $alternatif['ciri_khas'];
	$ranks[$alternatif['id_alternatif']]['warna'] = $alternatif['warna'];
	$ranks[$alternatif['id_alternatif']]['nilai'] = $total_nilai;
	
endforeach;
 
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?php	if(isset($judul_page)) {
			echo $judul_page;
		}
	?></title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="tema/lib/css/reset.css" type="text/css" media="screen, projection" />
<link rel="stylesheet" href="tema/lib/css/defaults.css" type="text/css" media="screen, projection" />
<link rel="stylesheet" href="tema/style.css" type="text/css" media="screen, projection" />
<link href="tema/font-awesome/css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" href="tema1/assets/vendor/bootstrap/css/bootstrap.min.css">
<link href="css/dataTables.bootstrap.min.css" rel="stylesheet">
<link type="text/css" href="css/jquery.toastmessage.css" rel="stylesheet"/>  
</head>
<body class="home blog page-builder">
<div id="container">
    <div class="clearfix">
        			<div class="menu-primary-container">
										<ul id="menu-atas" class="menus menu-primary">				
<li><a href="list-user.php"><i class="fa fa-user fa-fw"></i></a>
  </ul>
</div>           <!--.primary menu--> 	
                


    </div>
	<div id="header">
    
        <div class="logo">
         <div class="header-part">
				<a href="#"><img src="tema/images/logo.png" alt="vitalove" title="vitalove" class="logoimg" /></a>							
					</div>  
        </div><!-- .logo -->

        <div class="header-right">
 
        </div><!-- .header-right -->
        
    </div><!-- #header -->
    
	        <div class="clearfix">
            		<?php include"menu.php"?>
                      <!--.primary menu--> 	
               </div>	
			
			
       <div id="main">	
            <div class="container-fluid  dashboard-content">
                <!-- ============================================================== -->
                <!-- pageheader -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">HALAMAN ADMIN WEBSITE SPK SAW</h2>
							<p class="pageheader-text"><?=$r3['foto']?></p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                        
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
						<!-- Step 7: Perangkingan ==================== -->
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
          
                <div class="row">
                    <!-- ============================================================== -->
                    <!-- pie chart  -->
                    <!-- ============================================================== -->
                           <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card">
                            <h4 class="card-header">Selamat datang Di Menu ADMIN</h4>
                            <div class="card-body">
                               <section class='content'>

          <!-- Default box -->
          <div class='box'>
			<div class='alert alert-success alert-dismissable'>
                                      
                    <p align='justify'>
Silahkan kelola data anda di menu  dengan baik dan benar
				</p>
              </div>

          </div><!-- /.box -->

        </section>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end pie chart  -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- doughnut chart  -->
                    <!-- ============================================================== -->
                   <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Pie Charts</h5>
                            <div class="card-body">
                                <canvas id="chartjs_pie"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end doughnut chart  -->
                    <!-- ============================================================== -->
                </div>
            </div>
		 
</div><!-- #main -->
   <div id="footer">
    
        <div id="copyrights">
            Copyright, <a href="index.php">SPK <?=$r3['foto']?> <?=$saiki?></a>, Networks All Rights Reserved.</div>
    </div><!-- #footer -->
    
</div><!-- #container -->

    <!-- ============================================================== -->
    <!-- end main wrapper -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="tema1/assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="tema1/assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="tema1/assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <script src="tema1/assets/vendor/charts/charts-bundle/Chart.bundle.js"></script>
<script >
(function(window, document, $, undefined) {
        "use strict";
        $(function() {
            if ($('#chartjs_bar').length) {
                var ctx = document.getElementById("chartjs_bar").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [<?php foreach($sorted_ranks as $alternatif ): ?>"<?php echo $alternatif['no_alternatif']; ?>: <?php echo $alternatif['ciri_khas']; ?>", <?php endforeach; ?>],
                        datasets: [{
                            label: '',
                            data: [<?php foreach($sorted_ranks as $alternatif ): ?>
		"<?php echo round($alternatif['nilai'], $digit); ?>",<?php endforeach; ?>],
                           backgroundColor: "rgba(89, 105, 255,0.5)",
                                    borderColor: "rgba(89, 105, 255,0.7)",
                            borderWidth: 2
                        }, {
                            label: '',
                            data: [<?php foreach($sorted_ranks as $alternatif ): ?>
		"<?php echo round($alternatif['nilai'], $digit); ?>",<?php endforeach; ?>],
                           backgroundColor: "rgba(255, 64, 123,0.5)",
                                    borderColor: "rgba(255, 64, 123,0.7)",
                            borderWidth: 2
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{

                            }]
                        },
                             legend: {
                        display: true,
                        position: 'bottom',

                        labels: {
                            fontColor: '#71748d',
                            fontFamily: 'Circular Std Book',
                            fontSize: 14,
                        }
                    },

                    scales: {
                        xAxes: [{
                            ticks: {
                                fontSize: 14,
                                fontFamily: 'Circular Std Book',
                                fontColor: '#71748d',
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                fontSize: 14,
                                fontFamily: 'Circular Std Book',
                                fontColor: '#71748d',
                            }
                        }]
                    }
                }

                    
                });
            }


            if ($('#chartjs_pie').length) {
                var ctx = document.getElementById("chartjs_pie").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: [<?php foreach($sorted_ranks as $alternatif ): ?>"<?php echo $alternatif['no_alternatif']; ?>: <?php echo $alternatif['ciri_khas']; ?>", <?php endforeach; ?>],
                        datasets: [{
                            backgroundColor: [
                               <?php foreach($sorted_ranks as $alternatif ): ?>"<?php echo $alternatif['warna']; ?>", <?php endforeach; ?>
                            ],
                            data: [<?php foreach($sorted_ranks as $alternatif ): ?>
		"<?php echo round($alternatif['nilai'] * 100); ?>",<?php endforeach; ?>]
                        }]
                    },
                    options: {
                           legend: {
                        display: true,
                        position: 'bottom',

                        labels: {
                            fontColor: '#71748d',
                            fontFamily: 'Circular Std Book',
                            fontSize: 14,
                        }
                    },

                    
                }
                });
            }


            if ($('#chartjs_doughnut').length) {
                var ctx = document.getElementById("chartjs_doughnut").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: [<?php foreach($sorted_ranks as $alternatif ): ?>"<?php echo $alternatif['no_alternatif']; ?>: <?php echo $alternatif['ciri_khas']; ?>", <?php endforeach; ?>],
                        datasets: [{
                            backgroundColor: [
                                <?php foreach($sorted_ranks as $alternatif ): ?>"<?php echo $alternatif['warna']; ?>", <?php endforeach; ?>
                            ],
                            data: [<?php foreach($sorted_ranks as $alternatif ): ?>
		"<?php echo round($alternatif['nilai'] * 100); ?>",<?php endforeach; ?>]
                        }]
                    },
                    options: {

                             legend: {
                        display: true,
                        position: 'bottom',

                        labels: {
                            fontColor: '#71748d',
                            fontFamily: 'Circular Std Book',
                            fontSize: 14,
                        }
                    },

                    
                }

                });
            }


        });

})(window, document, window.jQuery);</script>
    <script src="tema1/assets/libs/js/main-js.js"></script>
</body>

 
</html>
</html>