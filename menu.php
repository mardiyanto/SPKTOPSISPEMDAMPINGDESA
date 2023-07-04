	<div class="menu-secondary-container">
							<ul id="menu-bawah" class="menus menu-secondary">
     <li class='limk'><a href='index.php'>Beranda</a></li>
					<?php $user_role = get_role(); ?>
						<?php if($user_role == 'admin'): ?>
					  <li>
                    <a href="list-user.php">
                        <i class="pe-7s-science"></i>
                        <p>User</p>
                    </a>
						<ul>
					<li class="active">
                    <a href="data-profil.php?module=home">
                        <i class="pe-7s-graph"></i>
                        Profil
                    </a>
                </li>
					</ul>
                </li>	

			  <li>
                    <a href="list-kriteria.php">
                        <i class="pe-7s-news-paper"></i>
                        <p>Kriteria</p>
                    </a>
                </li>
				
			<?php endif; ?>
						<?php if($user_role == 'admin' || $user_role == 'petugas'): ?>
					   <li>
                    <a href="list-alternatif.php">
                        <i class="pe-7s-note2"></i>
                        <p>alternatif</p>
                    </a>
                </li>	
					<li class="active">
                    <a href="ranking-topsis.php">
                        <i class="pe-7s-graph"></i>
                        <p>Hasil Perhitungan</p>
                    </a>
					<ul>
					<li class="active">
                    <a href="cetak-topsis.php" target='_blank'>
                        <i class="pe-7s-graph"></i>
                        Cetak Laporan
                    </a>
                </li>
					</ul>
                </li>
	<?php endif; ?>
					<li > <a href="charts-topsis.php">
                        <i class="pe-7s-graph"></i>
                        <p>Ranking</p>
                    </a>
					
                </li>
				
			<?php if(isset($_SESSION['user_id'])): ?>
				<li>
                    <a href="logout.php">
                        <i class="pe-7s-rocket"></i>
                        <p>Log Out</p>
                    </a>
                </li>
					<?php else: ?>
	<li>
                    <a href="profil.php?module=home&id_profil=3">
                        <i class="pe-7s-user"></i>
                        <p>Profil Kami</p>
                    </a>
					<ul>
					<li class="active">
                    <a href="profil.php?module=home&id_profil=3">
                        <i class="pe-7s-graph"></i>
                        Profil
                    </a>
                </li>
					<li class="active">
                    <a href="profil.php?module=home&id_profil=1">
                        <i class="pe-7s-graph"></i>
                        visi dan Misi
                    </a>
                </li>
					<li class="active">
                    <a href="profil.php?module=home&id_profil=2">
                        <i class="pe-7s-graph"></i>
                        Tentang SPK
                    </a>
                </li>
					</ul>
                </li>						
<li>
                    <a href="login.php">
                        <i class="pe-7s-user"></i>
                        <p>Login</p>
                    </a>
                </li>
					<li>
                    <a href="profil.php?module=daftartki">
                        <i class="pe-7s-user"></i>
                       <p>Pendaftaran</p>
                    </a>
                </li>
					<?php endif; ?>
	                
		</ul>
		</div>