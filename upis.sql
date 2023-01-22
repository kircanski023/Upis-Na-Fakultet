-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2023 at 04:58 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `upis`
--

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE `korisnik` (
  `id_korisnika` int(11) NOT NULL,
  `korisnicko_ime` varchar(50) NOT NULL,
  `sifra` varchar(255) NOT NULL,
  `datum_kreiranja_naloga` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`id_korisnika`, `korisnicko_ime`, `sifra`, `datum_kreiranja_naloga`) VALUES
(4, 'slobodan', '$2y$10$vcX2PvF3TDUap7sTxEUWeeEAclG2s8UsxiHhDA2VleGqCQVxE4fB6', '2022-12-26 17:40:50'),
(5, 'kircanski', '$2y$10$9MmTjK6EIIRG66oIggqTFu4QK6aslo2/cmK9XZiq4kIh1csuvSKje', '2022-12-26 18:07:59'),
(6, 'kircanskis', '$2y$10$0ZnVwAaMlrW6eGl8m0SnMuNnJRNVpLSEndg4kBA2juLE67W7wH3LS', '2023-01-20 22:38:13');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(10) NOT NULL,
  `broj_indeksa` varchar(12) NOT NULL,
  `ime_studenta` text NOT NULL,
  `prezime_studenta` text NOT NULL,
  `ime_oca` text NOT NULL,
  `jmbg` varchar(13) NOT NULL,
  `datum_rodjenja` text NOT NULL,
  `pol` varchar(6) NOT NULL,
  `email` text NOT NULL,
  `broj_telefona` varchar(10) NOT NULL,
  `drzavljanstvo` varchar(12) NOT NULL,
  `grad` text NOT NULL,
  `ulica` text NOT NULL,
  `opstina` text NOT NULL,
  `postanski_broj` text NOT NULL,
  `ime_majke` varchar(30) NOT NULL,
  `napomena` text NOT NULL,
  `id_sluzbenika` varchar(12) NOT NULL,
  `slika` varchar(150) NOT NULL,
  `upisan` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `broj_indeksa`, `ime_studenta`, `prezime_studenta`, `ime_oca`, `jmbg`, `datum_rodjenja`, `pol`, `email`, `broj_telefona`, `drzavljanstvo`, `grad`, `ulica`, `opstina`, `postanski_broj`, `ime_majke`, `napomena`, `id_sluzbenika`, `slika`, `upisan`) VALUES
(3, 'SI 16/18', 'Slobodan', 'Kircanski', 'Sinisa', '0306999850008', '2023-01-03', 'Male', '', '0614280432', 'Srpsko', '', '', '', '', 'Milena', '', '', '', '2023-01-22 14:17:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`id_korisnika`),
  ADD UNIQUE KEY `username` (`korisnicko_ime`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `korisnik`
--
ALTER TABLE `korisnik`
  MODIFY `id_korisnika` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
