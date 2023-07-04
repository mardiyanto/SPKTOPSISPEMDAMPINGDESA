-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 04 Jul 2023 pada 11.05
-- Versi Server: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spk_pendampingdesa`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alternatif`
--

CREATE TABLE `alternatif` (
  `id_alternatif` int(10) NOT NULL,
  `no_alternatif` varchar(6) NOT NULL,
  `ciri_khas` text NOT NULL,
  `tanggal_input` date NOT NULL,
  `warna` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `alternatif`
--

INSERT INTO `alternatif` (`id_alternatif`, `no_alternatif`, `ciri_khas`, `tanggal_input`, `warna`) VALUES
(6, 'A1', 'SOEBARI ,S.Sos,Msi.', '2017-05-23', '#c90e5d'),
(7, 'A2', 'ARI KUSNADI,S.Kom', '2017-05-24', '#ffb53e'),
(8, 'A3', 'AGUS PONADI ,S.Sos.', '2017-05-24', '#1ebfae'),
(9, 'A4', 'SUCI MUTIAWA, S.Kom', '2019-05-01', '#f9243f'),
(10, 'A5', 'AULIA SAPITRI,S.Ip', '2019-05-01', '#1611ed'),
(11, 'A6', 'MARDIBEST.M.T.I', '2019-05-01', '#ed4a11'),
(12, 'yanto', 'mardiyanto', '2019-07-21', '#b31846'),
(13, 'JEMBUT', 'mardi', '2020-07-17', '#169989');

-- --------------------------------------------------------

--
-- Struktur dari tabel `daftar`
--

CREATE TABLE `daftar` (
  `id_daftar` int(100) NOT NULL,
  `no_daftar` varchar(100) NOT NULL,
  `nik` varchar(100) NOT NULL,
  `nama_daftar` varchar(100) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `pekerjaan` varchar(100) NOT NULL,
  `hp` varchar(30) NOT NULL,
  `jk` varchar(100) NOT NULL,
  `ttl` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `daftar`
--

INSERT INTO `daftar` (`id_daftar`, `no_daftar`, `nik`, `nama_daftar`, `nama_lengkap`, `alamat`, `pekerjaan`, `hp`, `jk`, `ttl`) VALUES
(1, 'KD/20190721/002/22:33:41', '2123135412155454', 'yanto', 'mardiyanto', 'sfdfsfd', '', '', 'laki-laki', 'marga,07/25/2019'),
(2, 'KD/20200717/002/21:34:09', '1804170102910001', 'JEMBUT', 'mardi', 'sss', '', '78977988966', 'laki-laki', 'JEMBUT,07/18/2020');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` int(10) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `kode` varchar(100) NOT NULL,
  `type` enum('benefit','cost') NOT NULL,
  `bobot` float NOT NULL,
  `ada_pilihan` tinyint(1) DEFAULT NULL,
  `urutan_order` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `nama`, `kode`, `type`, `bobot`, `ada_pilihan`, `urutan_order`) VALUES
(11, 'C1', 'bidang keahlian', 'benefit', 0.25, 1, 1),
(12, 'C2', 'pendidikan', 'benefit', 0.15, 1, 2),
(13, 'C3', 'Umur', 'benefit', 0.1, 1, 3),
(14, 'C4', 'Komunikasi', 'benefit', 0.2, 1, 4),
(15, 'C5', 'pengalaman kerja', 'benefit', 0.3, 1, 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_alternatif`
--

CREATE TABLE `nilai_alternatif` (
  `id_nilai_alternatif` int(11) NOT NULL,
  `id_alternatif` int(10) NOT NULL,
  `id_kriteria` int(10) NOT NULL,
  `nilai` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `nilai_alternatif`
--

INSERT INTO `nilai_alternatif` (`id_nilai_alternatif`, `id_alternatif`, `id_kriteria`, `nilai`) VALUES
(25, 8, 11, 2),
(26, 8, 12, 2),
(27, 8, 13, 4),
(28, 8, 14, 3),
(30, 6, 11, 2),
(31, 6, 12, 4),
(32, 6, 13, 4),
(33, 6, 14, 4),
(35, 7, 11, 4),
(36, 7, 12, 3),
(37, 7, 13, 4),
(38, 7, 14, 2),
(43, 6, 15, 1),
(48, 7, 15, 4),
(53, 8, 15, 2),
(114, 9, 11, 2),
(115, 9, 12, 4),
(116, 9, 13, 4),
(117, 9, 14, 3),
(118, 9, 15, 1),
(121, 10, 11, 4),
(122, 10, 12, 2),
(123, 10, 13, 4),
(124, 10, 14, 4),
(125, 10, 15, 4),
(128, 11, 11, 4),
(129, 11, 12, 4),
(130, 11, 13, 4),
(131, 11, 14, 4),
(132, 11, 15, 4),
(134, 12, 11, 3),
(135, 12, 12, 2),
(136, 12, 13, 3),
(137, 12, 14, 4),
(138, 12, 15, 4),
(139, 13, 11, 1),
(140, 13, 12, 1),
(141, 13, 13, 2),
(142, 13, 14, 2),
(143, 13, 15, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pilihan_kriteria`
--

CREATE TABLE `pilihan_kriteria` (
  `id_pil_kriteria` int(10) NOT NULL,
  `id_kriteria` int(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nilai` float NOT NULL,
  `urutan_order` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pilihan_kriteria`
--

INSERT INTO `pilihan_kriteria` (`id_pil_kriteria`, `id_kriteria`, `nama`, `nilai`, `urutan_order`) VALUES
(1, 13, 'Umur > 45', 1, 1),
(2, 13, 'Umur 34-45', 2, 2),
(3, 13, 'Umur 26-34', 3, 3),
(4, 13, 'Umur 20-25', 4, 4),
(5, 12, 'SMA Sederajat', 1, 1),
(6, 12, 'Diploma 3', 2, 2),
(7, 12, 'Sarjana', 3, 3),
(8, 12, 'Megister Atau lebih Tinggi', 4, 4),
(9, 14, 'Belum Pernah Jadi Moderator/MC', 1, 1),
(10, 14, 'Sudah Pernah Jadi Moderator/MC', 2, 2),
(11, 14, 'Sering Jadi Moderator/MC', 3, 3),
(12, 14, 'Ada Sertifikat Pembicara Publi', 4, 4),
(13, 15, 'belum pernah kerja', 1, 1),
(14, 15, 'pernah bekeraja di bidang lain <=1 tahun', 2, 2),
(15, 15, 'pernah bekeraja bidang sosial <=1 tahun', 3, 3),
(16, 15, 'pernah bekeraja bidang pemberdayaan >=1 tahun', 4, 4),
(17, 11, 'bidang lainya', 1, 1),
(18, 11, 'bidang sosiologi', 2, 2),
(19, 11, 'bidang sosial masyarakat', 3, 3),
(20, 11, 'bidang pemberdayaan masyarakat', 4, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `profil`
--

CREATE TABLE `profil` (
  `id_profil` int(11) NOT NULL,
  `foto` text NOT NULL,
  `aktif` enum('Y','N') NOT NULL,
  `nama` varchar(50) NOT NULL,
  `isi` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `profil`
--

INSERT INTO `profil` (`id_profil`, `foto`, `aktif`, `nama`, `isi`) VALUES
(1, '', 'N', 'Visi Dan Misi', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>\r\n<ol>\r\n	<li>Ruang lingkup subjek Kabupaten Lampung Tengah</li>\r\n	<li>Ruang lingkup objek penelitian</li>\r\n</ol>\r\n\r\n<p style=\"margin-left:35.45pt;\">Penelitian dilakukan terhadap SPK Rekrutmen Pendamping Lokal Desa Di Kabupaten Lampung Tengah Berbasis Website Menggunakan Metode TOPSIS, serta dilakukan dengan data-data yang sifatnya bisa dilihat oleh publik.</p>\r\n\r\n<ol>\r\n	<li value=\"3\">Ruang lingkup waktu penelitian</li>\r\n</ol>\r\n\r\n<p style=\"margin-left:35.45pt;\">Penelitian dilakukan pada tahun 2019</p>\r\n</body>\r\n</html>\r\n'),
(2, 'Rekrutmen Pendamping Lokal Desa ', 'Y', 'Website SPK TOPSIS', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>\r\n<p>Pendamping Lokal Desa merupakan salah satu yang ada di setiap Desa. Dan tidak sembarangan orang bisa menjadi Pendamping Lokal Desa di setiap desanya. Untuk menyelesaikan permasalahan tersebut dibutuhkan pembuatan aplikasi berupa rekrutmen Pendamping Lokal Desa di Kabupaten Lampung Tengah. Selain itu agar dapat membantu pihak terkait dalam proses rekrutmen Pendamping Lokal Desa yang nantinya akan diselesaikan dengan metode TOPSIS (Technique for Order of Preference by Similarity to Ideal Solution).</p>\r\n\r\n<p>Keputusan yang diambil dalam proses seleksi calon Pendamping Lokal Desa, sering dipengaruhi oleh subyektifitas dari para pengambil keputusan. Subyektifitas dapat terjadi karena tidak ada metode standar yang sistematis untuk menilai kelayakan calon Pendamping Lokal Desa. Model yang digunakan dalam sistem pendukung keputusan ini adalah berbasis website dengan metode TOPSIS diharapkan bisa memudahkan akses bagi masyarakat dan pemerintahan dalam melakukan pengaksesan seleksi rekrutmen Pendamping Lokal Desa, selain itu sistem pendukung keputusan tersebut juga dapat digunakan sebagai alat untuk mengolah data secara akurat dalam proses seleksi.</p>\r\n</body>\r\n</html>\r\n'),
(3, '', 'N', 'Profil Kami', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>1.	Apakah dengan menggunakan metode TOPSIS pada Sistem Pendukung Keputusan mampu menyelesaikan masalah yang ada dalam rekrutmen Pendamping Lokal Desa Berbasis Website di Kabupaten Lampung Tengah. </body>\r\n</html>\r\n');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(5) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nama` varchar(70) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `role` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `email`, `alamat`, `role`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Zunan Arif R.', 'oxzygenz@gmail.com', 'Jalan Naik Turun 3312', '1'),
(7, 'petugas', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Anton S', 'test@thesamplemail.com', 'test', '2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id_alternatif`);

--
-- Indexes for table `daftar`
--
ALTER TABLE `daftar`
  ADD PRIMARY KEY (`id_daftar`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indexes for table `nilai_alternatif`
--
ALTER TABLE `nilai_alternatif`
  ADD PRIMARY KEY (`id_nilai_alternatif`),
  ADD UNIQUE KEY `id_alternatif_2` (`id_alternatif`,`id_kriteria`),
  ADD KEY `id_alternatif` (`id_alternatif`),
  ADD KEY `id_kriteria` (`id_kriteria`);

--
-- Indexes for table `pilihan_kriteria`
--
ALTER TABLE `pilihan_kriteria`
  ADD PRIMARY KEY (`id_pil_kriteria`),
  ADD KEY `id_kriteria` (`id_kriteria`);

--
-- Indexes for table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`id_profil`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alternatif`
--
ALTER TABLE `alternatif`
  MODIFY `id_alternatif` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `daftar`
--
ALTER TABLE `daftar`
  MODIFY `id_daftar` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `nilai_alternatif`
--
ALTER TABLE `nilai_alternatif`
  MODIFY `id_nilai_alternatif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;
--
-- AUTO_INCREMENT for table `pilihan_kriteria`
--
ALTER TABLE `pilihan_kriteria`
  MODIFY `id_pil_kriteria` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `profil`
--
ALTER TABLE `profil`
  MODIFY `id_profil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `nilai_alternatif`
--
ALTER TABLE `nilai_alternatif`
  ADD CONSTRAINT `nilai_alternatif_ibfk_1` FOREIGN KEY (`id_alternatif`) REFERENCES `alternatif` (`id_alternatif`),
  ADD CONSTRAINT `nilai_alternatif_ibfk_2` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`);

--
-- Ketidakleluasaan untuk tabel `pilihan_kriteria`
--
ALTER TABLE `pilihan_kriteria`
  ADD CONSTRAINT `pilihan_kriteria_ibfk_1` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
