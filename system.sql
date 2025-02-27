-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 27 Lut 2025, 10:16
-- Wersja serwera: 10.4.22-MariaDB
-- Wersja PHP: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `system`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dokumenty`
--

CREATE TABLE `dokumenty` (
  `id` int(11) NOT NULL,
  `id_pracownika` int(11) NOT NULL,
  `nazwa` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `nazwa_pliku` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `dokumenty`
--

INSERT INTO `dokumenty` (`id`, `id_pracownika`, `nazwa`, `nazwa_pliku`) VALUES
(5, 1, 'dokument', '1740647716.pdf');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `urlopy`
--

CREATE TABLE `urlopy` (
  `id` int(11) NOT NULL,
  `id_pracownika` int(11) NOT NULL,
  `od` date NOT NULL,
  `do` date NOT NULL,
  `dni` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `urlopy`
--

INSERT INTO `urlopy` (`id`, `id_pracownika`, `od`, `do`, `dni`) VALUES
(1, 1, '2022-05-31', '2022-06-03', 3),
(2, 1, '2022-06-22', '2022-06-30', 6),
(3, 3, '2022-06-14', '2022-06-22', 5),
(4, 1, '2022-09-05', '2022-09-14', 7),
(5, 1, '2024-06-06', '2024-06-13', 5);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `haslo` char(32) COLLATE utf8_polish_ci NOT NULL,
  `imie` varchar(40) COLLATE utf8_polish_ci NOT NULL,
  `nazwisko` varchar(40) COLLATE utf8_polish_ci NOT NULL,
  `stanowisko` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `pensja` decimal(8,2) NOT NULL,
  `zdjecie` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `data_zatrudnienia` date NOT NULL,
  `data_urodzenia` date NOT NULL,
  `adres_email` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `numer_telefonu` varchar(15) COLLATE utf8_polish_ci NOT NULL,
  `adres_zamieszkania` varchar(150) COLLATE utf8_polish_ci NOT NULL,
  `czy_admin` tinyint(1) NOT NULL DEFAULT 0,
  `dni_urlopu` int(11) NOT NULL DEFAULT 20
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `login`, `haslo`, `imie`, `nazwisko`, `stanowisko`, `pensja`, `zdjecie`, `data_zatrudnienia`, `data_urodzenia`, `adres_email`, `numer_telefonu`, `adres_zamieszkania`, `czy_admin`, `dni_urlopu`) VALUES
(1, 'admin', '46616fd82d746358dab4d0119e23e43b', 'Jan', 'Nowak', 'właściciel', '14000.00', 'default.png', '2021-05-11', '1997-02-01', 'jannowak@gmail.com', '876 365 276', 'Katowice ul. Wiejska 3', 1, 26),
(3, 'marcin2000', '202cb962ac59075b964b07152d234b70', 'Marcin', 'Jakubiak', 'programista', '7200.00', '1652963129.jpg', '2021-04-12', '1999-04-23', 'marcin@gmail.com', '124 231 352', 'Sosnowiec ul. Jagiellońska 2', 0, 26),
(5, 'zz1', '6d6d83f2e0f33d4dce3f331e013c53b6', 'Zuzanna', 'Kiedrowicz', 'grafik', '6800.00', '1652452786.jpg', '2021-05-23', '2000-04-05', 'zzk@wp.pl', '423 654 342', 'Zabrze ul. Długa 14a', 0, 20),
(7, 'joma', 'e99a18c428cb38d5f260853678922e03', 'Joanna', 'Mączewska', 'projektantka', '8200.00', '1653581156.jpg', '2020-11-23', '1994-03-12', 'joanna@abc.pl', '123 432 123', 'Będzin, Czeladzka 44', 0, 26);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wiadomosci`
--

CREATE TABLE `wiadomosci` (
  `id` int(11) NOT NULL,
  `id_nadawcy` int(11) NOT NULL,
  `id_odbiorcy` int(11) NOT NULL,
  `tresc` text COLLATE utf8_polish_ci NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `wiadomosci`
--

INSERT INTO `wiadomosci` (`id`, `id_nadawcy`, `id_odbiorcy`, `tresc`, `data`) VALUES
(13, 1, 3, 'yo', '2022-05-31 20:43:37'),
(14, 1, 5, 'witam', '2022-05-31 20:43:39'),
(15, 1, 3, 'druga wiadomosc', '2022-05-31 20:43:55'),
(16, 3, 1, 'test\r\n', '2022-05-31 21:03:32'),
(17, 3, 5, 'inny\r\n\r\ntest', '2022-05-31 21:03:35'),
(18, 1, 3, 'fd\r\n', '2022-05-31 21:04:12'),
(19, 1, 3, 'fsd', '2022-05-31 21:04:12'),
(20, 1, 3, 'fsd', '2022-05-31 21:04:13'),
(21, 1, 3, 'fsd', '2022-05-31 21:04:14'),
(22, 1, 3, 'fsd', '2022-05-31 21:04:15'),
(23, 1, 3, 'fsd', '2022-05-31 21:04:15'),
(24, 1, 7, 'a', '2022-05-31 21:21:43'),
(25, 1, 7, 'halo\r\n', '2024-05-31 09:49:27');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `dokumenty`
--
ALTER TABLE `dokumenty`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `urlopy`
--
ALTER TABLE `urlopy`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `wiadomosci`
--
ALTER TABLE `wiadomosci`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `dokumenty`
--
ALTER TABLE `dokumenty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `urlopy`
--
ALTER TABLE `urlopy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `wiadomosci`
--
ALTER TABLE `wiadomosci`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
