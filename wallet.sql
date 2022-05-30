-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 27 Paź 2021, 23:22
-- Wersja serwera: 10.4.21-MariaDB
-- Wersja PHP: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `wallet`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `password`
--

CREATE TABLE `password` (
  `id` int(11) NOT NULL,
  `password` varchar(256) NOT NULL,
  `id_user` int(11) NOT NULL,
  `web_adress` varchar(256) NOT NULL,
  `descryption` varchar(256) NOT NULL,
  `login` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `password`
--

INSERT INTO `password` (`id`, `password`, `id_user`, `web_adress`, `descryption`, `login`) VALUES
(47, 'URw18g==', 28, 'user.pl', 'user', 'user'),
(48, 'Vxsl5GRlgg==', 28, 'student.pl', 'student', 'student'),
(49, 'yfYQwrhc', 29, 'user12.pl', 'user12', 'user12'),
(50, 'z/EA1OwA1x/q', 29, 'student12.pl', 'student12', 'student12');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `isHash` tinyint(1) NOT NULL,
  `password` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `username`, `isHash`, `password`) VALUES
(28, 'user', 1, '69f2788e0c1f3053636e240c2960f43253f8a214f5235f311ae390d3cec45196a65114dbc83741b25429b6430e34a06744946288e9f3e4cd1c347e89a790c29a'),
(29, 'user12', 0, '38c4921bbd99b6e9f7ce62102832a0d29181ee6e237482a545b77439641ded7f');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `password`
--
ALTER TABLE `password`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `password`
--
ALTER TABLE `password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `password`
--
ALTER TABLE `password`
  ADD CONSTRAINT `password_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
