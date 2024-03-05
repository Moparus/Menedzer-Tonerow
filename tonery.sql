-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql1.small.pl
-- Generation Time: Mar 04, 2024 at 05:51 PM
-- Wersja serwera: 8.0.35
-- Wersja PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `m1475_tonery`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `archiwum_drukarka_pokoj`
--

CREATE TABLE `archiwum_drukarka_pokoj` (
  `archiwum_drukarka_pokoj_id` int NOT NULL,
  `drukarka_id` int NOT NULL,
  `pokoj_id` int NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_polish_ci;

--
-- Dumping data for table `archiwum_drukarka_pokoj`
--

INSERT INTO `archiwum_drukarka_pokoj` (`archiwum_drukarka_pokoj_id`, `drukarka_id`, `pokoj_id`, `data`) VALUES
(1, 1, 1, '2024-01-01');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `archiwum_toner`
--

CREATE TABLE `archiwum_toner` (
  `archiwum_toner_id` int NOT NULL,
  `toner_model_id` int NOT NULL,
  `toner_stan_id` int DEFAULT NULL,
  `drukarka_id` int NOT NULL,
  `stan_licznika` int UNSIGNED NOT NULL,
  `data` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_polish_ci;

--
-- Dumping data for table `archiwum_toner`
--

INSERT INTO `archiwum_toner` (`archiwum_toner_id`, `toner_model_id`, `toner_stan_id`, `drukarka_id`, `stan_licznika`, `data`) VALUES
(1, 1, 1, 1, 1000, '2024-01-01 12:37:03');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `drukarka`
--

CREATE TABLE `drukarka` (
  `drukarka_id` int NOT NULL,
  `numer_inwentarzowy` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL,
  `adres_ip` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci,
  `kod_kreskowy` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL,
  `mac` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci,
  `numer_seryjny` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci,
  `data_zakupu` date DEFAULT NULL,
  `drukarka_model_id` int NOT NULL,
  `pokoj_id` int NOT NULL,
  `stan_licznika` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_polish_ci;

--
-- Dumping data for table `drukarka`
--

INSERT INTO `drukarka` (`drukarka_id`, `numer_inwentarzowy`, `adres_ip`, `kod_kreskowy`, `mac`, `numer_seryjny`, `data_zakupu`, `drukarka_model_id`, `pokoj_id`, `stan_licznika`) VALUES
(1, 'N/111/1111', '10.100.1.1', 'brak', '', 'SERNUM123', '2023-01-01', 1, 1, 1111);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `drukarka_model`
--

CREATE TABLE `drukarka_model` (
  `drukarka_model_id` int NOT NULL,
  `firma_id` int NOT NULL,
  `model` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_polish_ci;

--
-- Dumping data for table `drukarka_model`
--

INSERT INTO `drukarka_model` (`drukarka_model_id`, `firma_id`, `model`) VALUES
(1, 1, 'ECOSYS P6230cdn');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `drukarka_toner`
--

CREATE TABLE `drukarka_toner` (
  `drukarka_toner_id` int NOT NULL,
  `drukarka_model_id` int NOT NULL,
  `toner_model_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_polish_ci;

--
-- Dumping data for table `drukarka_toner`
--

INSERT INTO `drukarka_toner` (`drukarka_toner_id`, `drukarka_model_id`, `toner_model_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `firma`
--

CREATE TABLE `firma` (
  `firma_id` int NOT NULL,
  `nazwa` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_polish_ci;

--
-- Dumping data for table `firma`
--

INSERT INTO `firma` (`firma_id`, `nazwa`) VALUES
(1, 'Kyocera');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `inwentaryzacja`
--

CREATE TABLE `inwentaryzacja` (
  `inwentaryzacja_id` int NOT NULL,
  `toner_id` int NOT NULL,
  `ilosc` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_polish_ci;


--
-- Struktura tabeli dla tabeli `ip`
--

CREATE TABLE `ip` (
  `adres` char(16) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `czas` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pokoj`
--

CREATE TABLE `pokoj` (
  `pokoj_id` int NOT NULL,
  `numer` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_polish_ci;

--
-- Dumping data for table `pokoj`
--

INSERT INTO `pokoj` (`pokoj_id`, `numer`) VALUES
(1, 'serwis');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `sesja`
--

CREATE TABLE `sesja` (
  `sesja_id` int NOT NULL,
  `klucz` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL,
  `szyfr` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_polish_ci;

--
-- Dumping data for table `sesja`
--

INSERT INTO `sesja` (`sesja_id`, `klucz`, `szyfr`) VALUES
(1, 'klucz', 'szyfr'),
(2, 'klucz', 'szyfr');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `toner`
--

CREATE TABLE `toner` (
  `toner_id` int NOT NULL,
  `toner_model_id` int NOT NULL,
  `ilosc` int NOT NULL,
  `toner_stan_id` int NOT NULL,
  `dodatkowy_kod` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_polish_ci;

--
-- Dumping data for table `toner`
--

INSERT INTO `toner` (`toner_id`, `toner_model_id`, `ilosc`, `toner_stan_id`, `dodatkowy_kod`) VALUES
(1, 1, 4, 1, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `toner_kolor`
--

CREATE TABLE `toner_kolor` (
  `toner_kolor_id` int NOT NULL,
  `kolor` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_polish_ci;

--
-- Dumping data for table `toner_kolor`
--

INSERT INTO `toner_kolor` (`toner_kolor_id`, `kolor`) VALUES
(1, 'brak'),
(2, 'black'),
(3, 'cyan'),
(4, 'magenta'),
(5, 'yellow');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `toner_model`
--

CREATE TABLE `toner_model` (
  `toner_model_id` int NOT NULL,
  `firma_id` int DEFAULT NULL,
  `model` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL,
  `toner_kolor_id` int DEFAULT NULL,
  `kod_kreskowy` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_polish_ci;

--
-- Dumping data for table `toner_model`
--

INSERT INTO `toner_model` (`toner_model_id`, `firma_id`, `model`, `toner_kolor_id`, `kod_kreskowy`) VALUES
(1, 1, 'TNP80C', 3, '039281067389');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `toner_stan`
--

CREATE TABLE `toner_stan` (
  `toner_stan_id` int NOT NULL,
  `stan` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_polish_ci;

--
-- Dumping data for table `toner_stan`
--

INSERT INTO `toner_stan` (`toner_stan_id`, `stan`) VALUES
(1, 'Oryginalny / Nowy'),
(2, 'Oryginalny / Otwarty'),
(3, 'Zamiennik / Nowy'),
(4, 'Zamiennik / Otwarty'),
(5, 'Nieznany');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownik`
--

CREATE TABLE `uzytkownik` (
  `uzytkownik_id` int NOT NULL,
  `login` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL,
  `haslo` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_polish_ci;

--
-- Dumping data for table `uzytkownik`
--

INSERT INTO `uzytkownik` (`uzytkownik_id`, `login`, `haslo`) VALUES
(1, 'uzy1', ''),
(2, 'uzy2', '');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `archiwum_drukarka_pokoj`
--
ALTER TABLE `archiwum_drukarka_pokoj`
  ADD PRIMARY KEY (`archiwum_drukarka_pokoj_id`),
  ADD KEY `drukarka_id` (`drukarka_id`),
  ADD KEY `pokoj_id` (`pokoj_id`);

--
-- Indeksy dla tabeli `archiwum_toner`
--
ALTER TABLE `archiwum_toner`
  ADD PRIMARY KEY (`archiwum_toner_id`),
  ADD KEY `drukarka_id` (`drukarka_id`),
  ADD KEY `toner_model_id` (`toner_model_id`),
  ADD KEY `toner_stan_id` (`toner_stan_id`);

--
-- Indeksy dla tabeli `drukarka`
--
ALTER TABLE `drukarka`
  ADD PRIMARY KEY (`drukarka_id`),
  ADD KEY `drukarka_model_id` (`drukarka_model_id`),
  ADD KEY `pokoj_id` (`pokoj_id`);

--
-- Indeksy dla tabeli `drukarka_model`
--
ALTER TABLE `drukarka_model`
  ADD PRIMARY KEY (`drukarka_model_id`),
  ADD KEY `firma_id` (`firma_id`);

--
-- Indeksy dla tabeli `drukarka_toner`
--
ALTER TABLE `drukarka_toner`
  ADD PRIMARY KEY (`drukarka_toner_id`),
  ADD KEY `drukarka_toner_ibfk_1` (`drukarka_model_id`),
  ADD KEY `drukarka_toner_ibfk_2` (`toner_model_id`);

--
-- Indeksy dla tabeli `firma`
--
ALTER TABLE `firma`
  ADD PRIMARY KEY (`firma_id`);

--
-- Indeksy dla tabeli `inwentaryzacja`
--
ALTER TABLE `inwentaryzacja`
  ADD PRIMARY KEY (`inwentaryzacja_id`),
  ADD KEY `toner_id` (`toner_id`);

--
-- Indeksy dla tabeli `pokoj`
--
ALTER TABLE `pokoj`
  ADD PRIMARY KEY (`pokoj_id`);

--
-- Indeksy dla tabeli `sesja`
--
ALTER TABLE `sesja`
  ADD PRIMARY KEY (`sesja_id`);

--
-- Indeksy dla tabeli `toner`
--
ALTER TABLE `toner`
  ADD PRIMARY KEY (`toner_id`),
  ADD KEY `toner_model_id` (`toner_model_id`),
  ADD KEY `toner_stan_id` (`toner_stan_id`);

--
-- Indeksy dla tabeli `toner_kolor`
--
ALTER TABLE `toner_kolor`
  ADD PRIMARY KEY (`toner_kolor_id`);

--
-- Indeksy dla tabeli `toner_model`
--
ALTER TABLE `toner_model`
  ADD PRIMARY KEY (`toner_model_id`),
  ADD KEY `firma_id` (`firma_id`),
  ADD KEY `toner_model_ibfk_2` (`toner_kolor_id`);

--
-- Indeksy dla tabeli `toner_stan`
--
ALTER TABLE `toner_stan`
  ADD PRIMARY KEY (`toner_stan_id`);

--
-- Indeksy dla tabeli `uzytkownik`
--
ALTER TABLE `uzytkownik`
  ADD PRIMARY KEY (`uzytkownik_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `archiwum_drukarka_pokoj`
--
ALTER TABLE `archiwum_drukarka_pokoj`
  MODIFY `archiwum_drukarka_pokoj_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `archiwum_toner`
--
ALTER TABLE `archiwum_toner`
  MODIFY `archiwum_toner_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `drukarka`
--
ALTER TABLE `drukarka`
  MODIFY `drukarka_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- AUTO_INCREMENT for table `drukarka_model`
--
ALTER TABLE `drukarka_model`
  MODIFY `drukarka_model_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `drukarka_toner`
--
ALTER TABLE `drukarka_toner`
  MODIFY `drukarka_toner_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `firma`
--
ALTER TABLE `firma`
  MODIFY `firma_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `inwentaryzacja`
--
ALTER TABLE `inwentaryzacja`
  MODIFY `inwentaryzacja_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `pokoj`
--
ALTER TABLE `pokoj`
  MODIFY `pokoj_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `sesja`
--
ALTER TABLE `sesja`
  MODIFY `sesja_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `toner`
--
ALTER TABLE `toner`
  MODIFY `toner_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `toner_kolor`
--
ALTER TABLE `toner_kolor`
  MODIFY `toner_kolor_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `toner_model`
--
ALTER TABLE `toner_model`
  MODIFY `toner_model_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `toner_stan`
--
ALTER TABLE `toner_stan`
  MODIFY `toner_stan_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `uzytkownik`
--
ALTER TABLE `uzytkownik`
  MODIFY `uzytkownik_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `archiwum_drukarka_pokoj`
--
ALTER TABLE `archiwum_drukarka_pokoj`
  ADD CONSTRAINT `archiwum_drukarka_pokoj_ibfk_1` FOREIGN KEY (`drukarka_id`) REFERENCES `drukarka` (`drukarka_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `archiwum_drukarka_pokoj_ibfk_2` FOREIGN KEY (`pokoj_id`) REFERENCES `pokoj` (`pokoj_id`) ON DELETE CASCADE;

--
-- Constraints for table `archiwum_toner`
--
ALTER TABLE `archiwum_toner`
  ADD CONSTRAINT `archiwum_toner_ibfk_2` FOREIGN KEY (`drukarka_id`) REFERENCES `drukarka` (`drukarka_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `archiwum_toner_ibfk_3` FOREIGN KEY (`toner_model_id`) REFERENCES `toner_model` (`toner_model_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `archiwum_toner_ibfk_4` FOREIGN KEY (`toner_stan_id`) REFERENCES `toner_stan` (`toner_stan_id`);

--
-- Constraints for table `drukarka`
--
ALTER TABLE `drukarka`
  ADD CONSTRAINT `drukarka_ibfk_1` FOREIGN KEY (`drukarka_model_id`) REFERENCES `drukarka_model` (`drukarka_model_id`),
  ADD CONSTRAINT `drukarka_ibfk_2` FOREIGN KEY (`pokoj_id`) REFERENCES `pokoj` (`pokoj_id`);

--
-- Constraints for table `drukarka_model`
--
ALTER TABLE `drukarka_model`
  ADD CONSTRAINT `drukarka_model_ibfk_1` FOREIGN KEY (`firma_id`) REFERENCES `firma` (`firma_id`);

--
-- Constraints for table `drukarka_toner`
--
ALTER TABLE `drukarka_toner`
  ADD CONSTRAINT `drukarka_toner_ibfk_1` FOREIGN KEY (`drukarka_model_id`) REFERENCES `drukarka_model` (`drukarka_model_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `drukarka_toner_ibfk_2` FOREIGN KEY (`toner_model_id`) REFERENCES `toner_model` (`toner_model_id`) ON DELETE CASCADE;

--
-- Constraints for table `inwentaryzacja`
--
ALTER TABLE `inwentaryzacja`
  ADD CONSTRAINT `inwentaryzacja_ibfk_1` FOREIGN KEY (`toner_id`) REFERENCES `toner` (`toner_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `toner`
--
ALTER TABLE `toner`
  ADD CONSTRAINT `toner_ibfk_1` FOREIGN KEY (`toner_model_id`) REFERENCES `toner_model` (`toner_model_id`),
  ADD CONSTRAINT `toner_ibfk_2` FOREIGN KEY (`toner_stan_id`) REFERENCES `toner_stan` (`toner_stan_id`);

--
-- Constraints for table `toner_model`
--
ALTER TABLE `toner_model`
  ADD CONSTRAINT `toner_model_ibfk_1` FOREIGN KEY (`firma_id`) REFERENCES `firma` (`firma_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `toner_model_ibfk_2` FOREIGN KEY (`toner_kolor_id`) REFERENCES `toner_kolor` (`toner_kolor_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
