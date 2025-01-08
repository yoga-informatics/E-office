-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Jan 2025 pada 13.42
-- Versi server: 10.4.25-MariaDB
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_revisikp`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `file_surat`
--

CREATE TABLE `file_surat` (
  `id_file` int(11) NOT NULL,
  `surat_id` int(11) NOT NULL,
  `nama_file` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `file_surat`
--

INSERT INTO `file_surat` (`id_file`, `surat_id`, `nama_file`) VALUES
(28, 12, '1481-2869-1-SM.pdf'),
(29, 13, '44459-File Utama Naskah-200871-1-10-20221223.pdf'),
(30, 13, 'JISMA+Transformasi+AI+Pendidikan+Indonesia.pdf'),
(31, 14, 'S2-2024-485080-bibliography.pdf'),
(32, 15, 'S2-2024-485080-title.pdf'),
(33, 16, 'S2-2024-485080-bibliography.pdf'),
(34, 17, 'VOL+2.+NO+2+HAL+87-103 (1).pdf'),
(35, 14, 'VOL+2.+NO+2+HAL+87-103.pdf'),
(36, 18, 'S2-2024-485080-bibliography.pdf'),
(37, 19, '9024-Article Text-37618-1-10-20220703.pdf'),
(38, 20, '9024-Article Text-37618-1-10-20220703.pdf'),
(39, 21, '16611054 Adhelia Nurfira Rachmi.pdf'),
(40, 22, 'JISMA+Transformasi+AI+Pendidikan+Indonesia.pdf'),
(41, 23, 'S2-2024-485080-title.pdf'),
(42, 24, 'S2-2024-485080-bibliography.pdf'),
(43, 25, '9024-Article Text-37618-1-10-20220703.pdf'),
(44, 26, 'Intan Kusumawardani_1201174423_TI-41-05.pdf'),
(45, 27, 'Intan Kusumawardani_1201174423_TI-41-05.pdf'),
(46, 28, '9024-Article Text-37618-1-10-20220703.pdf'),
(47, 29, 'S2-2024-485080-bibliography.pdf'),
(48, 30, 'S2-2024-485080-bibliography.pdf'),
(49, 31, 'Intan Kusumawardani_1201174423_TI-41-05.pdf'),
(50, 32, 'Intan Kusumawardani_1201174423_TI-41-05.pdf'),
(51, 33, 'Intan Kusumawardani_1201174423_TI-41-05.pdf'),
(52, 34, 'Intan Kusumawardani_1201174423_TI-41-05.pdf'),
(53, 35, '9024-Article Text-37618-1-10-20220703.pdf'),
(54, 15, '10.1007@s13748-015-0080-y.pdf'),
(55, 16, 'S2-2024-485080-bibliography.pdf'),
(56, 36, 'HowBibliographicDatasetPortraysDecreasingNumberofScientificPublicationfromIndonesia.pdf'),
(57, 37, 'Kuis Artifak Pra UTS 2023_2024.pdf'),
(58, 38, '7296-Article Text-30572-1-10-20240106.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `file_surat_k`
--

CREATE TABLE `file_surat_k` (
  `id_file_sk` int(11) NOT NULL,
  `sk_id` int(11) NOT NULL,
  `nama_file` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_ajukan`
--

CREATE TABLE `tb_ajukan` (
  `id_ajukan` int(11) NOT NULL,
  `pg_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_arsip_sk`
--

CREATE TABLE `tb_arsip_sk` (
  `id_arsip_sk` int(11) NOT NULL,
  `sk_id` int(11) NOT NULL,
  `lokasi_arsip_sk` varchar(50) NOT NULL,
  `tgl_arsip_sk` date NOT NULL,
  `status_dispo` int(11) NOT NULL,
  `tgl_disposisi` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_arsip_sm`
--

CREATE TABLE `tb_arsip_sm` (
  `id_arsip_sm` int(11) NOT NULL,
  `sm_id` int(11) NOT NULL,
  `lokasi_arsip_sm` varchar(50) NOT NULL,
  `tgl_arsip_sm` date NOT NULL,
  `status_dispo` int(11) NOT NULL,
  `tgl_disposisi` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_disposisi`
--

CREATE TABLE `tb_disposisi` (
  `id_disposisi` int(11) NOT NULL,
  `sm_id` int(11) NOT NULL,
  `tujuan_disposisi` varchar(50) NOT NULL,
  `catatan` text NOT NULL,
  `status_dispo` int(11) NOT NULL,
  `tgl_disposisi` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_disposisi`
--

INSERT INTO `tb_disposisi` (`id_disposisi`, `sm_id`, `tujuan_disposisi`, `catatan`, `status_dispo`, `tgl_disposisi`) VALUES
(22, 38, 'Pimpinan', 'a', 1, '2024-11-14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kategori`
--

CREATE TABLE `tb_kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori_s` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_kategori`
--

INSERT INTO `tb_kategori` (`id_kategori`, `nama_kategori_s`) VALUES
(1, 'Surat Resmi'),
(2, 'Surat Pribadi'),
(3, 'Surat Bisnis'),
(5, 'Surat Izin atau Permohonan'),
(6, 'Surat Resmi Pemerintah'),
(7, 'Surat Berita'),
(8, 'Surat Perjanjian'),
(10, 'Surat Pengaduan atau Keluhan'),
(11, 'Surat Tugas atau Perintah'),
(12, 'Surat Pemberitahuan Perubahan Informasi'),
(13, 'Surat Undangan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pengguna`
--

CREATE TABLE `tb_pengguna` (
  `id_pg` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(80) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `izin_akses` varchar(50) NOT NULL,
  `foto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_pengguna`
--

INSERT INTO `tb_pengguna` (`id_pg`, `username`, `password`, `nama_lengkap`, `jabatan`, `izin_akses`, `foto`) VALUES
(11, 'Admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin', 'Admin', 'Admin', 'personaje-dibujos-animados-gafas-traje_1248162-1939-removebg-preview.png'),
(12, 'pimpinan', '90973652b88fe07d05a4304f0a945de8', 'Pimpinan', 'Pimpinan ', 'Pimpinan', 'org.jpg'),
(13, 'petugas', 'afb91ef692fd08c445e8cb1bab2ccf9c', 'Petugas Umum', 'Pimpinan', 'Admin', 'ic.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_sk`
--

CREATE TABLE `tb_sk` (
  `id_sk` int(11) NOT NULL,
  `nomor_agenda` varchar(50) NOT NULL,
  `kode` varchar(50) NOT NULL,
  `nomor_sk` varchar(50) NOT NULL,
  `tgl_keluar` date NOT NULL,
  `tgl_sk` date NOT NULL,
  `penerima_sk` varchar(50) NOT NULL,
  `perihal_sk` varchar(50) NOT NULL,
  `lampiran_sk` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `tindakan` text NOT NULL,
  `berkas_kesalahan` text NOT NULL,
  `dari_disposisi` varchar(80) NOT NULL,
  `status_arsip` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_sk`
--

INSERT INTO `tb_sk` (`id_sk`, `nomor_agenda`, `kode`, `nomor_sk`, `tgl_keluar`, `tgl_sk`, `penerima_sk`, `perihal_sk`, `lampiran_sk`, `status`, `tindakan`, `berkas_kesalahan`, `dari_disposisi`, `status_arsip`) VALUES
(16, '', 'Kode SK01', 'NS01', '2024-11-13', '2024-11-13', 'PT.ABC', 'Pemberitahuan', '', 0, '', '', '', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_sm`
--

CREATE TABLE `tb_sm` (
  `id_sm` int(11) NOT NULL,
  `nomor_agenda` varchar(50) NOT NULL,
  `kode_sm` varchar(50) NOT NULL,
  `nomor_sm` varchar(80) NOT NULL,
  `tgl_surat` date DEFAULT NULL,
  `tgl_sm` date NOT NULL,
  `kategori` int(11) NOT NULL,
  `pengirim` varchar(80) NOT NULL,
  `perihal_surat` varchar(50) NOT NULL,
  `lampiran` varchar(50) NOT NULL,
  `disposisi` varchar(80) NOT NULL,
  `status` int(11) NOT NULL,
  `status_baca` int(11) NOT NULL,
  `tgl_disposisi` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_sm`
--

INSERT INTO `tb_sm` (`id_sm`, `nomor_agenda`, `kode_sm`, `nomor_sm`, `tgl_surat`, `tgl_sm`, `kategori`, `pengirim`, `perihal_surat`, `lampiran`, `disposisi`, `status`, `status_baca`, `tgl_disposisi`) VALUES
(38, '1', '', '1', '2024-11-14', '2024-11-14', 8, '1', '1', '', 'da', 3, 0, '0000-00-00');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `file_surat`
--
ALTER TABLE `file_surat`
  ADD PRIMARY KEY (`id_file`);

--
-- Indeks untuk tabel `file_surat_k`
--
ALTER TABLE `file_surat_k`
  ADD PRIMARY KEY (`id_file_sk`);

--
-- Indeks untuk tabel `tb_ajukan`
--
ALTER TABLE `tb_ajukan`
  ADD PRIMARY KEY (`id_ajukan`);

--
-- Indeks untuk tabel `tb_arsip_sk`
--
ALTER TABLE `tb_arsip_sk`
  ADD PRIMARY KEY (`id_arsip_sk`),
  ADD KEY `sm_id` (`sk_id`);

--
-- Indeks untuk tabel `tb_arsip_sm`
--
ALTER TABLE `tb_arsip_sm`
  ADD PRIMARY KEY (`id_arsip_sm`),
  ADD KEY `sm_id` (`sm_id`);

--
-- Indeks untuk tabel `tb_disposisi`
--
ALTER TABLE `tb_disposisi`
  ADD PRIMARY KEY (`id_disposisi`),
  ADD KEY `sm_id` (`sm_id`);

--
-- Indeks untuk tabel `tb_kategori`
--
ALTER TABLE `tb_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `tb_pengguna`
--
ALTER TABLE `tb_pengguna`
  ADD PRIMARY KEY (`id_pg`);

--
-- Indeks untuk tabel `tb_sk`
--
ALTER TABLE `tb_sk`
  ADD PRIMARY KEY (`id_sk`);

--
-- Indeks untuk tabel `tb_sm`
--
ALTER TABLE `tb_sm`
  ADD PRIMARY KEY (`id_sm`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `file_surat`
--
ALTER TABLE `file_surat`
  MODIFY `id_file` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT untuk tabel `file_surat_k`
--
ALTER TABLE `file_surat_k`
  MODIFY `id_file_sk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `tb_ajukan`
--
ALTER TABLE `tb_ajukan`
  MODIFY `id_ajukan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tb_arsip_sk`
--
ALTER TABLE `tb_arsip_sk`
  MODIFY `id_arsip_sk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_arsip_sm`
--
ALTER TABLE `tb_arsip_sm`
  MODIFY `id_arsip_sm` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_disposisi`
--
ALTER TABLE `tb_disposisi`
  MODIFY `id_disposisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `tb_kategori`
--
ALTER TABLE `tb_kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `tb_pengguna`
--
ALTER TABLE `tb_pengguna`
  MODIFY `id_pg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `tb_sk`
--
ALTER TABLE `tb_sk`
  MODIFY `id_sk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `tb_sm`
--
ALTER TABLE `tb_sm`
  MODIFY `id_sm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
